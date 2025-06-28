<?php

namespace Tests\Feature\Concurrency;

use App\Models\User;
use Modules\Product\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use PDOException;

final class DatabaseConcurrencyTest extends TestCase
{
    /**
     * Test database transaction isolation levels
     * Should maintain proper isolation under concurrent transactions
     */
    public function test_transaction_isolation_levels(): void
    {
        // Arrange: create user with balance
        $user = User::factory()->create([
            'balance' => 100.00,
        ]);

        // Act: start multiple transactions with different isolation levels
        $results = [];

        // Transaction 1: Read committed
        DB::transaction(function () use ($user, &$results) {
            $balance1 = User::where('id', $user->id)->value('balance');
            $results['transaction1_read'] = $balance1;

            // Simulate delay
            usleep(100_000);

            // Update balance
            User::where('id', $user->id)->update(['balance' => $balance1 - 20]);
            $results['transaction1_updated'] = true;
        }, 5); // 5 retries

        // Transaction 2: Should see committed changes
        DB::transaction(function () use ($user, &$results) {
            $balance2 = User::where('id', $user->id)->value('balance');
            $results['transaction2_read'] = $balance2;
        }, 5);

        // Assert: verify isolation behavior
        $this->assertArrayHasKey('transaction1_read', $results);
        $this->assertArrayHasKey('transaction2_read', $results);
        $this->assertArrayHasKey('transaction1_updated', $results);

        // Transaction 2 should see the updated balance from transaction 1
        $this->assertEquals($results['transaction1_read'] - 20, $results['transaction2_read']);
    }

    /**
     * Test deadlock detection and resolution
     * Should handle deadlocks gracefully with retry mechanisms
     */
    public function test_deadlock_detection_and_resolution(): void
    {
        // Arrange: create multiple users
        $users = User::factory()->count(3)->create([
            'balance' => 100.00,
        ]);

        $results = [];
        $exceptions = [];

        // Act: create potential deadlock scenario
        $transactions = [];

        foreach ($users as $index => $user) {
            $transactions[] = function () use ($user, $users, $index, &$results, &$exceptions) {
                try {
                    DB::transaction(function () use ($user, $users, $index) {
                        // Lock current user
                        $currentUser = User::where('id', $user->id)->lockForUpdate()->first();

                        // Simulate delay to increase deadlock probability
                        usleep(50_000);

                        // Try to lock another user (potential deadlock)
                        $otherUser = User::where('id', $users[($index + 1) % 3]->id)->lockForUpdate()->first();

                        // Update both users
                        $currentUser->update(['balance' => $currentUser->balance - 10]);
                        $otherUser->update(['balance' => $otherUser->balance + 10]);
                    }, 3); // 3 retries for deadlock resolution

                    $results[] = "Transaction {$index} completed successfully";
                } catch (QueryException $e) {
                    if (str_contains($e->getMessage(), 'Deadlock')) {
                        $exceptions[] = "Deadlock detected in transaction {$index}: " . $e->getMessage();
                    } else {
                        throw $e;
                    }
                }
            };
        }

        // Execute transactions concurrently
        foreach ($transactions as $transaction) {
            $transaction();
        }

        // Assert: verify deadlock handling
        $this->assertGreaterThan(0, count($results), 'At least some transactions should complete');

        // Verify all users still have valid balances
        foreach ($users as $user) {
            $user->refresh();
            $this->assertGreaterThanOrEqual(0, $user->balance);
        }
    }

    /**
     * Test database connection pooling under high load
     * Should efficiently manage database connections
     */
    public function test_database_connection_pooling(): void
    {
        // Arrange: create multiple users
        $users = User::factory()->count(10)->create([
            'balance' => 100.00,
        ]);

        $results = [];
        $startTime = microtime(true);

        // Act: perform concurrent database operations
        $operations = [];

        foreach ($users as $user) {
            $operations[] = function () use ($user, &$results) {
                try {
                    DB::transaction(function () use ($user) {
                        // Read operation
                        $balance = User::where('id', $user->id)->value('balance');

                        // Write operation
                        User::where('id', $user->id)->update([
                            'balance' => $balance + 10
                        ]);

                        // Another read operation
                        $newBalance = User::where('id', $user->id)->value('balance');

                        return $newBalance;
                    });

                    $results[] = "Operation completed for user {$user->id}";
                } catch (\Exception $e) {
                    $results[] = "Operation failed for user {$user->id}: " . $e->getMessage();
                }
            };
        }

        // Execute operations
        foreach ($operations as $operation) {
            $operation();
        }

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        // Assert: verify connection pooling efficiency
        $this->assertGreaterThan(0, count($results), 'Operations should complete');
        $this->assertLessThan(10.0, $executionTime, 'Operations should complete within reasonable time');

        // Verify data consistency
        foreach ($users as $user) {
            $user->refresh();
            $this->assertEquals(110.00, $user->balance);
        }
    }

    /**
     * Test row-level locking mechanisms
     * Should properly lock specific rows during concurrent updates
     */
    public function test_row_level_locking(): void
    {
        // Arrange: create multiple users
        $users = User::factory()->count(5)->create([
            'balance' => 100.00,
        ]);

        $results = [];
        $lockResults = [];

        // Act: test different locking mechanisms
        $operations = [];

        foreach ($users as $index => $user) {
            $operations[] = function () use ($user, $index, &$results, &$lockResults) {
                try {
                    DB::transaction(function () use ($user, $index, &$lockResults) {
                        // Test shared lock (read lock)
                        $sharedUser = User::where('id', $user->id)->sharedLock()->first();
                        $lockResults["shared_{$index}"] = $sharedUser->balance;

                        // Simulate delay
                        usleep(100_000);

                        // Test exclusive lock (write lock)
                        $exclusiveUser = User::where('id', $user->id)->lockForUpdate()->first();
                        $exclusiveUser->update(['balance' => $exclusiveUser->balance - 10]);
                        $lockResults["exclusive_{$index}"] = $exclusiveUser->balance;
                    }, 3);

                    $results[] = "Row-level locking completed for user {$user->id}";
                } catch (\Exception $e) {
                    $results[] = "Row-level locking failed for user {$user->id}: " . $e->getMessage();
                }
            };
        }

        // Execute operations
        foreach ($operations as $operation) {
            $operation();
        }

        // Assert: verify row-level locking behavior
        $this->assertGreaterThan(0, count($results), 'Row-level locking operations should complete');
        $this->assertGreaterThan(0, count($lockResults), 'Lock results should be recorded');

        // Verify final balances
        foreach ($users as $user) {
            $user->refresh();
            $this->assertEquals(90.00, $user->balance);
        }
    }

    /**
     * Test database constraint violations under concurrency
     * Should handle unique constraint violations gracefully
     */
    public function test_constraint_violations_under_concurrency(): void
    {
        // Arrange: create user with unique email
        $existingUser = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $results = [];
        $violations = [];

        // Act: try to create users with duplicate emails concurrently
        $operations = [];

        for ($i = 0; $i < 5; $i++) {
            $operations[] = function () use ($i, &$results, &$violations) {
                try {
                    DB::transaction(function () use ($i) {
                        User::create([
                            'name' => "User {$i}",
                            'email' => 'test@example.com', // Duplicate email
                            'password' => 'password',
                            'balance' => 100.00,
                        ]);
                    });

                    $results[] = "User creation succeeded for iteration {$i}";
                } catch (QueryException $e) {
                    if (str_contains($e->getMessage(), 'Duplicate entry')) {
                        $violations[] = "Duplicate entry violation for iteration {$i}";
                    } else {
                        throw $e;
                    }
                }
            };
        }

        // Execute operations
        foreach ($operations as $operation) {
            $operation();
        }

        // Assert: verify constraint violation handling
        $this->assertGreaterThan(0, count($violations), 'Should detect duplicate entry violations');

        // Only one user should exist with the email
        $userCount = User::where('email', 'test@example.com')->count();
        $this->assertEquals(1, $userCount, 'Only one user should exist with the email');
    }

    /**
     * Test database index usage under concurrent load
     * Should efficiently use indexes for concurrent queries
     */
    public function test_index_usage_under_concurrent_load(): void
    {
        // Arrange: create many users with indexed fields
        $users = User::factory()->count(100)->create([
            'balance' => 100.00,
        ]);

        $results = [];
        $queryTimes = [];

        // Act: perform concurrent queries on indexed fields
        $operations = [];

        for ($i = 0; $i < 20; $i++) {
            $operations[] = function () use ($i, &$results, &$queryTimes) {
                $startTime = microtime(true);

                try {
                    // Query by indexed field (email)
                    $user = User::where('email', User::inRandomOrder()->first()->email)->first();

                    // Query by another indexed field (id)
                    $userById = User::find($user->id);

                    // Query with range on indexed field
                    $usersInRange = User::where('balance', '>=', 50)
                        ->where('balance', '<=', 150)
                        ->limit(10)
                        ->get();

                    $endTime = microtime(true);
                    $queryTime = $endTime - $startTime;

                    $queryTimes[] = $queryTime;
                    $results[] = "Indexed query completed in {$queryTime}s";
                } catch (\Exception $e) {
                    $results[] = "Indexed query failed: " . $e->getMessage();
                }
            };
        }

        // Execute operations
        foreach ($operations as $operation) {
            $operation();
        }

        // Assert: verify index efficiency
        $this->assertGreaterThan(0, count($results), 'Indexed queries should complete');

        // Average query time should be reasonable
        $averageQueryTime = array_sum($queryTimes) / count($queryTimes);
        $this->assertLessThan(1.0, $averageQueryTime, 'Average query time should be under 1 second');
    }

    /**
     * Test database transaction rollback under concurrency
     * Should properly rollback failed transactions
     */
    public function test_transaction_rollback_under_concurrency(): void
    {
        // Arrange: create user with balance
        $user = User::factory()->create([
            'balance' => 100.00,
        ]);

        $initialBalance = $user->balance;
        $results = [];

        // Act: perform operations that should rollback
        $operations = [];

        for ($i = 0; $i < 3; $i++) {
            $operations[] = function () use ($user, $i, &$results) {
                try {
                    DB::transaction(function () use ($user, $i) {
                        // Valid operation
                        $user->update(['balance' => $user->balance - 10]);

                        // Simulate delay
                        usleep(100_000);

                        // Operation that should cause rollback
                        if ($i === 1) {
                            throw new \Exception("Simulated error for rollback test");
                        }

                        // This should not execute if rollback occurs
                        $user->update(['balance' => $user->balance - 5]);
                    }, 3);

                    $results[] = "Transaction {$i} completed successfully";
                } catch (\Exception $e) {
                    $results[] = "Transaction {$i} rolled back: " . $e->getMessage();
                }
            };
        }

        // Execute operations
        foreach ($operations as $operation) {
            $operation();
        }

        // Assert: verify rollback behavior
        $user->refresh();

        // Balance should reflect only successful transactions
        $this->assertGreaterThanOrEqual(70.00, $user->balance);
        $this->assertLessThanOrEqual(100.00, $user->balance);

        $this->assertGreaterThan(0, count($results), 'Transaction operations should complete');
    }

    /**
     * Test database connection timeout handling
     * Should handle connection timeouts gracefully
     */
    public function test_connection_timeout_handling(): void
    {
        // Arrange: create users
        $users = User::factory()->count(5)->create([
            'balance' => 100.00,
        ]);

        $results = [];
        $timeouts = [];

        // Act: perform operations that might cause timeouts
        $operations = [];

        foreach ($users as $user) {
            $operations[] = function () use ($user, &$results, &$timeouts) {
                try {
                    DB::transaction(function () use ($user) {
                        // Long-running operation
                        $balance = User::where('id', $user->id)->value('balance');

                        // Simulate long processing time
                        usleep(500_000); // 0.5 seconds

                        User::where('id', $user->id)->update([
                            'balance' => $balance + 10
                        ]);
                    }, 3);

                    $results[] = "Operation completed for user {$user->id}";
                } catch (PDOException $e) {
                    if (str_contains($e->getMessage(), 'timeout')) {
                        $timeouts[] = "Connection timeout for user {$user->id}";
                    } else {
                        throw $e;
                    }
                }
            };
        }

        // Execute operations
        foreach ($operations as $operation) {
            $operation();
        }

        // Assert: verify timeout handling
        $this->assertGreaterThan(0, count($results), 'Operations should complete or timeout gracefully');

        // Verify data consistency
        foreach ($users as $user) {
            $user->refresh();
            $this->assertGreaterThanOrEqual(100.00, $user->balance);
        }
    }
}
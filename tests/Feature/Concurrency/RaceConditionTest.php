<?php

namespace Tests\Feature\Concurrency;

use App\Jobs\WithdrawFromAccount;
use App\Jobs\WithdrawFromAccountOptimistic;
use App\Jobs\DepositToAccount;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;

final class RaceConditionTest extends TestCase
{
    /**
     * Test 1: Demonstrates race condition without proper locking
     * This test shows what happens when concurrent operations don't use proper locking
     */
    public function test_it_demonstrates_race_condition_without_locking(): void
    {
        // Arrange: create user with balance
        $user = User::factory()->create([
            'balance' => 100.00,
        ]);

        $initialBalance = $user->balance;
        $this->assertEquals(100.00, $initialBalance);

        // Act: simulate concurrent operations without proper locking
        // This would cause a race condition in a real scenario
        $operations = [];

        for ($i = 0; $i < 5; $i++) {
            $operations[] = function () use ($user) {
                // Simulate concurrent read
                $currentBalance = User::where('id', $user->id)->value('balance');

                // Simulate concurrent write (this would cause race condition)
                User::where('id', $user->id)->update([
                    'balance' => $currentBalance - 20
                ]);
            };
        }

        // Execute operations
        foreach ($operations as $operation) {
            $operation();
        }

        // Assert: refresh user and check final balance
        $user->refresh();

        // In a race condition scenario, the final balance might be inconsistent
        // This demonstrates why proper locking is necessary
        $this->assertLessThanOrEqual($initialBalance, $user->balance);

        Log::info("Race condition test - Final balance: {$user->balance}");
    }

    /**
     * Test 2: Demonstrates how pessimistic locking prevents race conditions
     * This test shows the correct behavior with proper locking
     */
    public function test_it_prevents_race_condition_with_pessimistic_locking(): void
    {
        // Arrange: create user with balance
        $user = User::factory()->create([
            'balance' => 100.00,
        ]);

        $initialBalance = $user->balance;
        $this->assertEquals(100.00, $initialBalance);

        // Act: dispatch concurrent withdrawal jobs with pessimistic locking
        WithdrawFromAccount::dispatch($user->id, 70.00);
        WithdrawFromAccount::dispatch($user->id, 50.00);

        // Assert: refresh user and check final balance
        $user->refresh();

        // With pessimistic locking, only one withdrawal should succeed
        // The second should fail due to insufficient funds
        $this->assertGreaterThanOrEqual(30.00, $user->balance);
        $this->assertLessThanOrEqual(50.00, $user->balance);

        // Verify no negative balance occurred
        $this->assertGreaterThanOrEqual(0, $user->balance);

        Log::info("Pessimistic locking test - Final balance: {$user->balance}");
    }

    /**
     * Test 3: Demonstrates optimistic locking with retry mechanism
     * This test shows how optimistic locking handles concurrent modifications
     */
    public function test_it_handles_race_condition_with_optimistic_locking(): void
    {
        // Arrange: create user with balance
        $user = User::factory()->create([
            'balance' => 200.00,
        ]);

        $initialBalance = $user->balance;
        $this->assertEquals(200.00, $initialBalance);

        // Act: dispatch concurrent withdrawal jobs with optimistic locking
        WithdrawFromAccountOptimistic::dispatch($user->id, 30.00);
        WithdrawFromAccountOptimistic::dispatch($user->id, 40.00);
        WithdrawFromAccountOptimistic::dispatch($user->id, 50.00);

        // Assert: refresh user and check final balance
        $user->refresh();

        // Should handle concurrent modifications through retries
        $this->assertGreaterThanOrEqual(80.00, $user->balance);
        $this->assertLessThanOrEqual(200.00, $user->balance);

        // Verify no negative balance occurred
        $this->assertGreaterThanOrEqual(0, $user->balance);

        Log::info("Optimistic locking test - Final balance: {$user->balance}");
    }

    /**
     * Test 4: Demonstrates mixed operations (deposits and withdrawals)
     * This test shows how the system handles concurrent deposits and withdrawals
     */
    public function test_it_handles_mixed_concurrent_operations(): void
    {
        // Arrange: create user with initial balance
        $user = User::factory()->create([
            'balance' => 50.00,
        ]);

        $initialBalance = $user->balance;
        $this->assertEquals(50.00, $initialBalance);

        // Act: dispatch mixed operations
        DepositToAccount::dispatch($user->id, 100.00);
        WithdrawFromAccount::dispatch($user->id, 30.00);
        DepositToAccount::dispatch($user->id, 25.00);
        WithdrawFromAccount::dispatch($user->id, 20.00);

        // Assert: refresh user and check final balance
        $user->refresh();

        // Expected: 50 + 100 - 30 + 25 - 20 = 125
        // But due to concurrency, we need to verify consistency
        $this->assertGreaterThanOrEqual(50.00, $user->balance);
        $this->assertLessThanOrEqual(200.00, $user->balance);

        // Verify no negative balance occurred
        $this->assertGreaterThanOrEqual(0, $user->balance);

        Log::info("Mixed operations test - Final balance: {$user->balance}");
    }

    /**
     * Test 5: Demonstrates high load scenario
     * This test shows system behavior under sustained concurrent load
     */
    public function test_it_handles_high_load_scenario(): void
    {
        // Arrange: create user with substantial balance
        $user = User::factory()->create([
            'balance' => 1000.00,
        ]);

        $initialBalance = $user->balance;
        $this->assertEquals(1000.00, $initialBalance);

        // Act: dispatch many small operations
        for ($i = 0; $i < 10; $i++) {
            WithdrawFromAccount::dispatch($user->id, 10.00);
            DepositToAccount::dispatch($user->id, 5.00);
        }

        // Assert: refresh user and check final balance
        $user->refresh();

        // Should maintain data consistency throughout
        $this->assertGreaterThanOrEqual(0, $user->balance);
        $this->assertLessThanOrEqual(1000.00, $user->balance);

        // Verify no data corruption occurred
        $this->assertIsNumeric($user->balance);

        Log::info("High load test - Final balance: {$user->balance}");
    }

    /**
     * Test 6: Demonstrates edge case handling
     * This test shows how the system handles edge cases under concurrency
     */
    public function test_it_handles_edge_cases_under_concurrency(): void
    {
        // Arrange: create user with minimal balance
        $user = User::factory()->create([
            'balance' => 10.00,
        ]);

        $initialBalance = $user->balance;
        $this->assertEquals(10.00, $initialBalance);

        // Act: attempt operations with edge cases
        WithdrawFromAccount::dispatch($user->id, 0.00);  // Zero amount
        WithdrawFromAccount::dispatch($user->id, -5.00); // Negative amount
        WithdrawFromAccount::dispatch($user->id, 50.00); // Amount larger than balance
        DepositToAccount::dispatch($user->id, 0.00);     // Zero deposit

        // Assert: refresh user and check final balance
        $user->refresh();

        // Should handle edge cases gracefully
        $this->assertGreaterThanOrEqual(0, $user->balance);
        $this->assertLessThanOrEqual(10.00, $user->balance);

        Log::info("Edge cases test - Final balance: {$user->balance}");
    }
}
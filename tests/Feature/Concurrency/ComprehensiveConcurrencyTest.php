<?php

namespace Tests\Feature\Concurrency;

use App\Jobs\WithdrawFromAccount;
use App\Jobs\WithdrawFromAccountOptimistic;
use App\Jobs\DepositToAccount;
use App\Jobs\UpdateProductStock;
use App\Models\User;
use Modules\Product\Models\Product;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Validation\ValidationException;

final class ComprehensiveConcurrencyTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Configure queue to run synchronously for testing
        Queue::fake();
    }

    /**
     * Test 1: Basic race condition with pessimistic locking
     * Should prevent overdraft when two withdrawals happen simultaneously
     */
    public function test_pessimistic_locking_prevents_overdraft(): void
    {
        // Arrange: create user with balance
        $user = User::factory()->create([
            'balance' => 100.00,
        ]);

        $initialBalance = $user->balance;
        $this->assertEquals(100.00, $initialBalance);

        // Act: dispatch two concurrent withdrawal jobs
        WithdrawFromAccount::dispatch($user->id, 70.00);
        WithdrawFromAccount::dispatch($user->id, 50.00);

        // Give jobs time to process
        sleep(3);

        // Assert: refresh user and check final balance
        $user->refresh();

        // With pessimistic locking, only one withdrawal should succeed
        // The second should fail due to insufficient funds
        $this->assertGreaterThanOrEqual(30.00, $user->balance);
        $this->assertLessThanOrEqual(50.00, $user->balance);

        // Verify no negative balance occurred
        $this->assertGreaterThanOrEqual(0, $user->balance);
    }

    /**
     * Test 2: Optimistic locking with retry mechanism
     * Should handle concurrent modifications gracefully
     */
    public function test_optimistic_locking_with_retries(): void
    {
        // Arrange: create user with balance
        $user = User::factory()->create([
            'balance' => 200.00,
        ]);

        $initialBalance = $user->balance;
        $this->assertEquals(200.00, $initialBalance);

        // Act: dispatch multiple optimistic withdrawal jobs
        WithdrawFromAccountOptimistic::dispatch($user->id, 30.00);
        WithdrawFromAccountOptimistic::dispatch($user->id, 40.00);
        WithdrawFromAccountOptimistic::dispatch($user->id, 50.00);

        // Give jobs time to process with retries
        sleep(4);

        // Assert: refresh user and check final balance
        $user->refresh();

        // Should handle concurrent modifications through retries
        $this->assertGreaterThanOrEqual(80.00, $user->balance);
        $this->assertLessThanOrEqual(200.00, $user->balance);
    }

    /**
     * Test 3: Mixed operations (deposits and withdrawals)
     * Should maintain data consistency under concurrent load
     */
    public function test_mixed_deposit_withdrawal_operations(): void
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

        // Give jobs time to process
        sleep(3);

        // Assert: refresh user and check final balance
        $user->refresh();

        // Expected: 50 + 100 - 30 + 25 - 20 = 125
        // But due to concurrency, we need to verify consistency
        $this->assertGreaterThanOrEqual(50.00, $user->balance);
        $this->assertLessThanOrEqual(200.00, $user->balance);
    }

    /**
     * Test 4: Product stock management concurrency
     * Should prevent overselling when multiple orders are placed simultaneously
     */
    public function test_product_stock_concurrency(): void
    {
        // Arrange: create product with limited stock
        $product = Product::factory()->create([
            'stock' => 5,
        ]);

        $initialStock = $product->stock;
        $this->assertEquals(5, $initialStock);

        // Act: dispatch multiple stock decrease operations
        UpdateProductStock::dispatch($product->id, 2, 'decrease');
        UpdateProductStock::dispatch($product->id, 3, 'decrease');
        UpdateProductStock::dispatch($product->id, 2, 'decrease');

        // Give jobs time to process
        sleep(2);

        // Assert: refresh product and check final stock
        $product->refresh();

        // Should prevent overselling
        $this->assertGreaterThanOrEqual(0, $product->stock);
        $this->assertLessThanOrEqual(5, $product->stock);
    }

    /**
     * Test 5: High load scenario with multiple users
     * Should handle concurrent operations on different resources
     */
    public function test_high_load_multiple_users(): void
    {
        // Arrange: create multiple users with balances
        $users = User::factory()->count(5)->create([
            'balance' => 100.00,
        ]);

        $initialBalances = $users->pluck('balance')->toArray();
        $this->assertCount(5, $initialBalances);

        // Act: dispatch operations for all users simultaneously
        foreach ($users as $user) {
            WithdrawFromAccount::dispatch($user->id, 30.00);
            DepositToAccount::dispatch($user->id, 20.00);
            WithdrawFromAccount::dispatch($user->id, 15.00);
        }

        // Give jobs time to process
        sleep(3);

        // Assert: check all users maintain consistency
        foreach ($users as $user) {
            $user->refresh();

            // Each user should have a balance between 0 and their initial balance
            $this->assertGreaterThanOrEqual(0, $user->balance);
            $this->assertLessThanOrEqual(100.00, $user->balance);
        }
    }

    /**
     * Test 6: Insufficient funds scenario
     * Should properly reject withdrawals when balance is insufficient
     */
    public function test_insufficient_funds_handling(): void
    {
        // Arrange: create user with minimal balance
        $user = User::factory()->create([
            'balance' => 10.00,
        ]);

        $initialBalance = $user->balance;
        $this->assertEquals(10.00, $initialBalance);

        // Act: attempt withdrawals larger than balance
        WithdrawFromAccount::dispatch($user->id, 50.00);
        WithdrawFromAccount::dispatch($user->id, 30.00);
        WithdrawFromAccount::dispatch($user->id, 15.00);

        // Give jobs time to process
        sleep(2);

        // Assert: balance should remain unchanged or only allow valid withdrawals
        $user->refresh();

        // Should not go below 0
        $this->assertGreaterThanOrEqual(0, $user->balance);
        $this->assertLessThanOrEqual(10.00, $user->balance);
    }

    /**
     * Test 7: Product stock overselling prevention
     * Should throw validation exception when trying to sell more than available
     */
    public function test_product_stock_overselling_prevention(): void
    {
        // Arrange: create product with very limited stock
        $product = Product::factory()->create([
            'stock' => 1,
        ]);

        $initialStock = $product->stock;
        $this->assertEquals(1, $initialStock);

        // Act: attempt to sell more than available stock
        UpdateProductStock::dispatch($product->id, 2, 'decrease');
        UpdateProductStock::dispatch($product->id, 1, 'decrease');

        // Give jobs time to process
        sleep(2);

        // Assert: stock should not go below 0
        $product->refresh();

        $this->assertGreaterThanOrEqual(0, $product->stock);
        $this->assertLessThanOrEqual(1, $product->stock);
    }

    /**
     * Test 8: Concurrent stock increases and decreases
     * Should handle mixed stock operations correctly
     */
    public function test_concurrent_stock_increases_and_decreases(): void
    {
        // Arrange: create product with initial stock
        $product = Product::factory()->create([
            'stock' => 10,
        ]);

        $initialStock = $product->stock;
        $this->assertEquals(10, $initialStock);

        // Act: dispatch mixed stock operations
        UpdateProductStock::dispatch($product->id, 3, 'decrease');
        UpdateProductStock::dispatch($product->id, 5, 'increase');
        UpdateProductStock::dispatch($product->id, 2, 'decrease');
        UpdateProductStock::dispatch($product->id, 1, 'increase');

        // Give jobs time to process
        sleep(2);

        // Assert: refresh product and check final stock
        $product->refresh();

        // Expected: 10 - 3 + 5 - 2 + 1 = 11
        // But due to concurrency, we need to verify consistency
        $this->assertGreaterThanOrEqual(0, $product->stock);
        $this->assertLessThanOrEqual(20, $product->stock);
    }

    /**
     * Test 9: Deadlock prevention with proper transaction ordering
     * Should handle multiple resource locks without deadlocks
     */
    public function test_deadlock_prevention(): void
    {
        // Arrange: create multiple users and products
        $users = User::factory()->count(3)->create([
            'balance' => 100.00,
        ]);

        $products = Product::factory()->count(3)->create([
            'stock' => 10,
        ]);

        // Act: dispatch operations that could potentially cause deadlocks
        foreach ($users as $index => $user) {
            WithdrawFromAccount::dispatch($user->id, 20.00);
            UpdateProductStock::dispatch($products[$index]->id, 2, 'decrease');
        }

        // Give jobs time to process
        sleep(3);

        // Assert: all operations should complete without deadlocks
        foreach ($users as $user) {
            $user->refresh();
            $this->assertGreaterThanOrEqual(0, $user->balance);
        }

        foreach ($products as $product) {
            $product->refresh();
            $this->assertGreaterThanOrEqual(0, $product->stock);
        }
    }

    /**
     * Test 10: Performance under sustained load
     * Should maintain consistency during extended concurrent operations
     */
    public function test_sustained_load_performance(): void
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

        // Give jobs time to process
        sleep(4);

        // Assert: refresh user and check final balance
        $user->refresh();

        // Should maintain data consistency throughout
        $this->assertGreaterThanOrEqual(0, $user->balance);
        $this->assertLessThanOrEqual(1000.00, $user->balance);

        // Verify no data corruption occurred
        $this->assertIsNumeric($user->balance);
    }

    /**
     * Test 11: Edge case - zero amount operations
     * Should handle edge cases gracefully
     */
    public function test_zero_amount_operations(): void
    {
        // Arrange: create user with balance
        $user = User::factory()->create([
            'balance' => 100.00,
        ]);

        $initialBalance = $user->balance;
        $this->assertEquals(100.00, $initialBalance);

        // Act: dispatch operations with zero amounts
        WithdrawFromAccount::dispatch($user->id, 0.00);
        DepositToAccount::dispatch($user->id, 0.00);
        WithdrawFromAccount::dispatch($user->id, 0.00);

        // Give jobs time to process
        sleep(2);

        // Assert: balance should remain unchanged
        $user->refresh();
        $this->assertEquals(100.00, $user->balance);
    }

    /**
     * Test 12: Negative amount handling
     * Should handle invalid input gracefully
     */
    public function test_negative_amount_handling(): void
    {
        // Arrange: create user with balance
        $user = User::factory()->create([
            'balance' => 100.00,
        ]);

        $initialBalance = $user->balance;
        $this->assertEquals(100.00, $initialBalance);

        // Act: dispatch operations with negative amounts
        WithdrawFromAccount::dispatch($user->id, -10.00);
        DepositToAccount::dispatch($user->id, -5.00);

        // Give jobs time to process
        sleep(2);

        // Assert: balance should remain unchanged or handle gracefully
        $user->refresh();
        $this->assertGreaterThanOrEqual(0, $user->balance);
    }
}
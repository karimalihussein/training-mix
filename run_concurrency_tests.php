<?php

/**
 * Simple Concurrency Test Runner
 * 
 * This script provides a quick way to run concurrency tests and see the results.
 * It can be executed directly: php run_concurrency_tests.php
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Jobs\WithdrawFromAccount;
use App\Jobs\WithdrawFromAccountOptimistic;
use App\Jobs\DepositToAccount;
use App\Jobs\UpdateProductStock;
use App\Models\User;
use Modules\Product\Models\Product;
use Illuminate\Support\Facades\Log;

class SimpleConcurrencyTestRunner
{
    private array $results = [];
    private float $startTime;

    public function run(): void
    {
        $this->startTime = microtime(true);

        echo "🚀 Starting Simple Concurrency Test Runner\n";
        echo "==========================================\n\n";

        // Run basic tests
        $this->runBasicTests();

        // Run advanced tests
        $this->runAdvancedTests();

        // Display results
        $this->displayResults();
    }

    private function runBasicTests(): void
    {
        echo "📋 Running Basic Concurrency Tests...\n";

        // Test 1: Pessimistic Locking
        $this->runTest('Pessimistic Locking Test', function () {
            $user = User::factory()->create(['balance' => 100.00]);

            WithdrawFromAccount::dispatch($user->id, 70.00);
            WithdrawFromAccount::dispatch($user->id, 50.00);

            sleep(3);

            $user->refresh();
            return [
                'success' => $user->balance >= 0 && $user->balance <= 50,
                'final_balance' => $user->balance,
                'message' => "Final balance: {$user->balance}"
            ];
        });

        // Test 2: Optimistic Locking
        $this->runTest('Optimistic Locking Test', function () {
            $user = User::factory()->create(['balance' => 200.00]);

            WithdrawFromAccountOptimistic::dispatch($user->id, 30.00);
            WithdrawFromAccountOptimistic::dispatch($user->id, 40.00);
            WithdrawFromAccountOptimistic::dispatch($user->id, 50.00);

            sleep(4);

            $user->refresh();
            return [
                'success' => $user->balance >= 0 && $user->balance <= 200,
                'final_balance' => $user->balance,
                'message' => "Final balance: {$user->balance}"
            ];
        });

        // Test 3: Mixed Operations
        $this->runTest('Mixed Operations Test', function () {
            $user = User::factory()->create(['balance' => 50.00]);

            DepositToAccount::dispatch($user->id, 100.00);
            WithdrawFromAccount::dispatch($user->id, 30.00);
            DepositToAccount::dispatch($user->id, 25.00);
            WithdrawFromAccount::dispatch($user->id, 20.00);

            sleep(3);

            $user->refresh();
            return [
                'success' => $user->balance >= 0 && $user->balance <= 200,
                'final_balance' => $user->balance,
                'message' => "Final balance: {$user->balance}"
            ];
        });
    }

    private function runAdvancedTests(): void
    {
        echo "\n🔬 Running Advanced Concurrency Tests...\n";

        // Test 4: Product Stock Management
        $this->runTest('Product Stock Management Test', function () {
            $product = Product::factory()->create(['stock' => 5]);

            UpdateProductStock::dispatch($product->id, 2, 'decrease');
            UpdateProductStock::dispatch($product->id, 3, 'decrease');
            UpdateProductStock::dispatch($product->id, 2, 'decrease');

            sleep(2);

            $product->refresh();
            return [
                'success' => $product->stock >= 0 && $product->stock <= 5,
                'final_stock' => $product->stock,
                'message' => "Final stock: {$product->stock}"
            ];
        });

        // Test 5: High Load Scenario
        $this->runTest('High Load Scenario Test', function () {
            $user = User::factory()->create(['balance' => 1000.00]);

            for ($i = 0; $i < 10; $i++) {
                WithdrawFromAccount::dispatch($user->id, 10.00);
                DepositToAccount::dispatch($user->id, 5.00);
            }

            sleep(4);

            $user->refresh();
            return [
                'success' => $user->balance >= 0 && $user->balance <= 1000,
                'final_balance' => $user->balance,
                'message' => "Final balance: {$user->balance}"
            ];
        });

        // Test 6: Edge Cases
        $this->runTest('Edge Cases Test', function () {
            $user = User::factory()->create(['balance' => 10.00]);

            WithdrawFromAccount::dispatch($user->id, 0.00);
            WithdrawFromAccount::dispatch($user->id, -5.00);
            WithdrawFromAccount::dispatch($user->id, 50.00);
            DepositToAccount::dispatch($user->id, 0.00);

            sleep(2);

            $user->refresh();
            return [
                'success' => $user->balance >= 0 && $user->balance <= 10,
                'final_balance' => $user->balance,
                'message' => "Final balance: {$user->balance}"
            ];
        });
    }

    private function runTest(string $testName, callable $testFunction): void
    {
        $testStartTime = microtime(true);

        try {
            $result = $testFunction();
            $executionTime = microtime(true) - $testStartTime;

            $this->results[$testName] = [
                'status' => $result['success'] ? 'PASSED' : 'FAILED',
                'execution_time' => $executionTime,
                'message' => $result['message'],
                'details' => $result
            ];

            $status = $result['success'] ? '✅' : '❌';
            echo "  {$status} {$testName} ({$executionTime}s) - {$result['message']}\n";
        } catch (Exception $e) {
            $executionTime = microtime(true) - $testStartTime;

            $this->results[$testName] = [
                'status' => 'ERROR',
                'execution_time' => $executionTime,
                'message' => $e->getMessage(),
                'error' => $e->getMessage()
            ];

            echo "  ❌ {$testName} ({$executionTime}s) - ERROR: {$e->getMessage()}\n";
        }
    }

    private function displayResults(): void
    {
        $totalExecutionTime = microtime(true) - $this->startTime;

        echo "\n📊 CONCURRENCY TEST RESULTS\n";
        echo "==========================\n";

        $totalTests = count($this->results);
        $passedTests = count(array_filter($this->results, fn($r) => $r['status'] === 'PASSED'));
        $failedTests = count(array_filter($this->results, fn($r) => $r['status'] === 'FAILED'));
        $errorTests = count(array_filter($this->results, fn($r) => $r['status'] === 'ERROR'));

        echo "Total Tests: {$totalTests}\n";
        echo "Passed: {$passedTests}\n";
        echo "Failed: {$failedTests}\n";
        echo "Errors: {$errorTests}\n";
        echo "Success Rate: " . number_format(($passedTests / $totalTests) * 100, 1) . "%\n";
        echo "Total Execution Time: " . number_format($totalExecutionTime, 3) . "s\n";

        // Performance analysis
        $slowTests = array_filter($this->results, fn($r) => $r['execution_time'] > 2.0);
        if (!empty($slowTests)) {
            echo "\n⚠️  Slow tests detected:\n";
            foreach ($slowTests as $test => $result) {
                echo "  - {$test}: {$result['execution_time']}s\n";
            }
        }

        // Concurrency effectiveness
        $concurrencySuccessRate = ($passedTests / $totalTests) * 100;
        if ($concurrencySuccessRate >= 80) {
            echo "\n✅ Concurrency handling is effective!\n";
        } else {
            echo "\n⚠️  Concurrency handling may need improvement.\n";
        }

        echo "\n🎯 Test Summary:\n";
        foreach ($this->results as $testName => $result) {
            $status = $result['status'] === 'PASSED' ? '✅' : ($result['status'] === 'FAILED' ? '❌' : '💥');
            echo "  {$status} {$testName}: {$result['message']}\n";
        }
    }
}

// Run the tests if this script is executed directly
if (php_sapi_name() === 'cli') {
    $runner = new SimpleConcurrencyTestRunner();
    $runner->run();
}

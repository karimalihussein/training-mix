<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Tests\Feature\Concurrency\ComprehensiveConcurrencyTest;
use Tests\Feature\Concurrency\ApiConcurrencyTest;
use Tests\Feature\Concurrency\DatabaseConcurrencyTest;

class RunConcurrencyTests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:concurrency {--category=all : Test category to run (all, basic, api, database)} {--export : Export results to JSON file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run comprehensive concurrency tests';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting comprehensive concurrency test suite...');

        $category = $this->option('category');
        $shouldExport = $this->option('export');

        $startTime = microtime(true);
        $results = [];

        try {
            switch ($category) {
                case 'basic':
                    $results = $this->runBasicConcurrencyTests();
                    break;
                case 'api':
                    $results = $this->runApiConcurrencyTests();
                    break;
                case 'database':
                    $results = $this->runDatabaseConcurrencyTests();
                    break;
                case 'all':
                default:
                    $results = $this->runAllConcurrencyTests();
                    break;
            }

            $executionTime = microtime(true) - $startTime;

            $this->displayResults($results, $executionTime);

            if ($shouldExport) {
                $this->exportResults($results);
            }

            return 0;
        } catch (\Exception $e) {
            $this->error('Test execution failed: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Run basic concurrency tests
     */
    private function runBasicConcurrencyTests(): array
    {
        $this->info('Running basic concurrency tests...');

        $test = new ComprehensiveConcurrencyTest();
        $this->callProtectedMethod($test, 'setUp');

        $tests = [
            'test_pessimistic_locking_prevents_overdraft',
            'test_optimistic_locking_with_retries',
            'test_mixed_deposit_withdrawal_operations',
            'test_product_stock_concurrency',
            'test_high_load_multiple_users',
            'test_insufficient_funds_handling',
        ];

        return $this->executeTests($test, $tests, 'Basic Concurrency');
    }

    /**
     * Run API concurrency tests
     */
    private function runApiConcurrencyTests(): array
    {
        $this->info('Running API concurrency tests...');

        $test = new ApiConcurrencyTest();
        $this->callProtectedMethod($test, 'setUp');

        $tests = [
            'test_concurrent_api_requests',
            'test_concurrent_product_stock_api_requests',
            'test_race_condition_in_balance_updates',
            'test_api_transaction_isolation',
            'test_api_rate_limiting_concurrency',
        ];

        return $this->executeTests($test, $tests, 'API Concurrency');
    }

    /**
     * Run database concurrency tests
     */
    private function runDatabaseConcurrencyTests(): array
    {
        $this->info('Running database concurrency tests...');

        $test = new DatabaseConcurrencyTest();
        $this->callProtectedMethod($test, 'setUp');

        $tests = [
            'test_transaction_isolation_levels',
            'test_deadlock_detection_and_resolution',
            'test_row_level_locking',
            'test_constraint_violations_under_concurrency',
            'test_database_connection_pooling',
        ];

        return $this->executeTests($test, $tests, 'Database Concurrency');
    }

    /**
     * Call a protected method using reflection
     */
    private function callProtectedMethod(object $object, string $methodName): void
    {
        $reflection = new \ReflectionClass($object);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        $method->invoke($object);
    }

    /**
     * Run all concurrency tests
     */
    private function runAllConcurrencyTests(): array
    {
        $this->info('Running all concurrency tests...');

        $allResults = [];

        $allResults = array_merge($allResults, $this->runBasicConcurrencyTests());
        $allResults = array_merge($allResults, $this->runApiConcurrencyTests());
        $allResults = array_merge($allResults, $this->runDatabaseConcurrencyTests());

        return $allResults;
    }

    /**
     * Execute a set of tests
     */
    private function executeTests($testInstance, array $tests, string $category): array
    {
        $results = [];

        foreach ($tests as $testMethod) {
            $testStartTime = microtime(true);

            try {
                $testInstance->$testMethod();

                $results[$testMethod] = [
                    'status' => 'PASSED',
                    'execution_time' => microtime(true) - $testStartTime,
                    'category' => $category,
                ];

                $this->info("✓ {$testMethod} passed");
            } catch (\Exception $e) {
                $results[$testMethod] = [
                    'status' => 'FAILED',
                    'execution_time' => microtime(true) - $testStartTime,
                    'category' => $category,
                    'error' => $e->getMessage(),
                ];

                $this->error("✗ {$testMethod} failed: " . $e->getMessage());
            }
        }

        return $results;
    }

    /**
     * Display test results
     */
    private function displayResults(array $results, float $executionTime): void
    {
        $this->info("\n=== CONCURRENCY TEST RESULTS ===");

        $totalTests = count($results);
        $passedTests = count(array_filter($results, fn($r) => $r['status'] === 'PASSED'));
        $failedTests = $totalTests - $passedTests;
        $successRate = $totalTests > 0 ? ($passedTests / $totalTests) * 100 : 0;

        $this->info("Total Tests: {$totalTests}");
        $this->info("Passed: {$passedTests}");
        $this->info("Failed: {$failedTests}");
        $this->info("Success Rate: " . number_format($successRate, 1) . "%");
        $this->info("Total Execution Time: " . number_format($executionTime, 3) . "s");

        // Group by category
        $categoryResults = [];
        foreach ($results as $test => $result) {
            $category = $result['category'];
            if (!isset($categoryResults[$category])) {
                $categoryResults[$category] = [];
            }
            $categoryResults[$category][] = $result;
        }

        $this->info("\n=== DETAILED RESULTS BY CATEGORY ===");
        foreach ($categoryResults as $category => $categoryTests) {
            $passed = count(array_filter($categoryTests, fn($r) => $r['status'] === 'PASSED'));
            $total = count($categoryTests);
            $rate = ($passed / $total) * 100;

            $this->info("{$category}: {$passed}/{$total} passed (" . number_format($rate, 1) . "%)");
        }

        if ($successRate < 80) {
            $this->warn("\n⚠️  Concurrency handling may need improvement");
        } else {
            $this->info("\n✅ Concurrency handling is effective");
        }
    }

    /**
     * Export results to JSON file
     */
    private function exportResults(array $results): void
    {
        $filename = 'concurrency_test_results_' . date('Y-m-d_H-i-s') . '.json';
        $filepath = storage_path("logs/{$filename}");

        $exportData = [
            'timestamp' => now()->toISOString(),
            'results' => $results,
            'summary' => [
                'total_tests' => count($results),
                'passed_tests' => count(array_filter($results, fn($r) => $r['status'] === 'PASSED')),
                'failed_tests' => count(array_filter($results, fn($r) => $r['status'] === 'FAILED')),
            ]
        ];

        file_put_contents($filepath, json_encode($exportData, JSON_PRETTY_PRINT));
        $this->info("Results exported to: {$filepath}");
    }
}

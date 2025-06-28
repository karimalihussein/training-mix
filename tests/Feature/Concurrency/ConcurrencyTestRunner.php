<?php

namespace Tests\Feature\Concurrency;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;

final class ConcurrencyTestRunner
{
    private array $testResults = [];
    private array $performanceMetrics = [];

    /**
     * Run all concurrency tests with detailed reporting
     */
    public function runAllTests(): array
    {
        Log::info('Starting comprehensive concurrency test suite...');

        $startTime = microtime(true);

        // Test categories
        $testCategories = [
            'Basic Concurrency' => [
                'test_pessimistic_locking_prevents_overdraft',
                'test_optimistic_locking_with_retries',
                'test_mixed_deposit_withdrawal_operations',
            ],
            'Product Management' => [
                'test_product_stock_concurrency',
                'test_product_stock_overselling_prevention',
                'test_concurrent_stock_increases_and_decreases',
            ],
            'High Load Scenarios' => [
                'test_high_load_multiple_users',
                'test_sustained_load_performance',
                'test_deadlock_prevention',
            ],
            'Edge Cases' => [
                'test_insufficient_funds_handling',
                'test_zero_amount_operations',
                'test_negative_amount_handling',
            ],
            'Database Level' => [
                'test_transaction_isolation_levels',
                'test_deadlock_detection_and_resolution',
                'test_row_level_locking',
                'test_constraint_violations_under_concurrency',
            ],
            'API Level' => [
                'test_concurrent_api_requests',
                'test_concurrent_product_stock_api_requests',
                'test_race_condition_in_balance_updates',
            ],
        ];

        $totalTests = 0;
        $passedTests = 0;
        $failedTests = 0;

        foreach ($testCategories as $category => $tests) {
            Log::info("Running {$category} tests...");

            foreach ($tests as $testMethod) {
                $totalTests++;
                $testStartTime = microtime(true);

                try {
                    $this->runSingleTest($testMethod);
                    $passedTests++;
                    $this->testResults[$testMethod] = [
                        'status' => 'PASSED',
                        'execution_time' => microtime(true) - $testStartTime,
                        'category' => $category,
                    ];

                    Log::info("✓ {$testMethod} passed");
                } catch (\Exception $e) {
                    $failedTests++;
                    $this->testResults[$testMethod] = [
                        'status' => 'FAILED',
                        'execution_time' => microtime(true) - $testStartTime,
                        'category' => $category,
                        'error' => $e->getMessage(),
                    ];

                    Log::error("✗ {$testMethod} failed: " . $e->getMessage());
                }
            }
        }

        $totalExecutionTime = microtime(true) - $startTime;

        $this->performanceMetrics = [
            'total_tests' => $totalTests,
            'passed_tests' => $passedTests,
            'failed_tests' => $failedTests,
            'success_rate' => ($passedTests / $totalTests) * 100,
            'total_execution_time' => $totalExecutionTime,
            'average_test_time' => $totalExecutionTime / $totalTests,
        ];

        $this->generateReport();

        return [
            'results' => $this->testResults,
            'metrics' => $this->performanceMetrics,
        ];
    }

    /**
     * Run a single test method
     */
    private function runSingleTest(string $testMethod): void
    {
        // Create test instance and run the method
        $testInstance = new ComprehensiveConcurrencyTest();
        $this->callProtectedMethod($testInstance, 'setUp', []);

        if (method_exists($testInstance, $testMethod)) {
            $testInstance->$testMethod();
        } else {
            // Try API test class
            $apiTestInstance = new ApiConcurrencyTest();
            $this->callProtectedMethod($apiTestInstance, 'setUp', []);

            if (method_exists($apiTestInstance, $testMethod)) {
                $apiTestInstance->$testMethod();
            } else {
                // Try Database test class
                $dbTestInstance = new DatabaseConcurrencyTest();
                $this->callProtectedMethod($dbTestInstance, 'setUp', []);

                if (method_exists($dbTestInstance, $testMethod)) {
                    $dbTestInstance->$testMethod();
                } else {
                    throw new \Exception("Test method {$testMethod} not found in any test class");
                }
            }
        }
    }

    /**
     * Call a protected method using reflection
     */
    private function callProtectedMethod(object $object, string $methodName, array $parameters = []): void
    {
        $reflection = new \ReflectionClass($object);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        $method->invokeArgs($object, $parameters);
    }

    /**
     * Generate detailed test report
     */
    private function generateReport(): void
    {
        Log::info('=== CONCURRENCY TEST SUITE REPORT ===');
        Log::info("Total Tests: {$this->performanceMetrics['total_tests']}");
        Log::info("Passed: {$this->performanceMetrics['passed_tests']}");
        Log::info("Failed: {$this->performanceMetrics['failed_tests']}");
        Log::info("Success Rate: {$this->performanceMetrics['success_rate']}%");
        Log::info("Total Execution Time: {$this->performanceMetrics['total_execution_time']}s");
        Log::info("Average Test Time: {$this->performanceMetrics['average_test_time']}s");

        // Group results by category
        $categoryResults = [];
        foreach ($this->testResults as $test => $result) {
            $category = $result['category'];
            if (!isset($categoryResults[$category])) {
                $categoryResults[$category] = [];
            }
            $categoryResults[$category][] = $result;
        }

        Log::info('=== DETAILED RESULTS BY CATEGORY ===');
        foreach ($categoryResults as $category => $results) {
            $passed = count(array_filter($results, fn($r) => $r['status'] === 'PASSED'));
            $total = count($results);
            $successRate = ($passed / $total) * 100;

            Log::info("{$category}: {$passed}/{$total} passed ({$successRate}%)");

            foreach ($results as $result) {
                $status = $result['status'] === 'PASSED' ? '✓' : '✗';
                $time = number_format($result['execution_time'], 3);
                Log::info("  {$status} {$time}s");

                if (isset($result['error'])) {
                    Log::error("    Error: {$result['error']}");
                }
            }
        }

        // Performance analysis
        $this->analyzePerformance();
    }

    /**
     * Analyze test performance and identify bottlenecks
     */
    private function analyzePerformance(): void
    {
        Log::info('=== PERFORMANCE ANALYSIS ===');

        $slowTests = array_filter($this->testResults, function ($result) {
            return $result['execution_time'] > 2.0; // Tests taking more than 2 seconds
        });

        if (!empty($slowTests)) {
            Log::warning('Slow tests detected:');
            foreach ($slowTests as $test => $result) {
                Log::warning("  {$test}: {$result['execution_time']}s");
            }
        }

        $fastTests = array_filter($this->testResults, function ($result) {
            return $result['execution_time'] < 0.5; // Tests taking less than 0.5 seconds
        });

        Log::info("Fast tests (< 0.5s): " . count($fastTests));
        Log::info("Slow tests (> 2.0s): " . count($slowTests));

        // Concurrency effectiveness analysis
        $this->analyzeConcurrencyEffectiveness();
    }

    /**
     * Analyze how well the system handles concurrency
     */
    private function analyzeConcurrencyEffectiveness(): void
    {
        Log::info('=== CONCURRENCY EFFECTIVENESS ANALYSIS ===');

        $concurrencyTests = array_filter($this->testResults, function ($result) {
            return str_contains($result['category'], 'High Load') ||
                str_contains($result['category'], 'Concurrent');
        });

        $successfulConcurrencyTests = array_filter($concurrencyTests, function ($result) {
            return $result['status'] === 'PASSED';
        });

        $concurrencySuccessRate = count($concurrencyTests) > 0
            ? (count($successfulConcurrencyTests) / count($concurrencyTests)) * 100
            : 0;

        Log::info("Concurrency Test Success Rate: {$concurrencySuccessRate}%");

        if ($concurrencySuccessRate < 80) {
            Log::warning('Concurrency handling may need improvement');
        } else {
            Log::info('Concurrency handling is effective');
        }
    }

    /**
     * Get test results for external use
     */
    public function getResults(): array
    {
        return [
            'results' => $this->testResults,
            'metrics' => $this->performanceMetrics,
        ];
    }

    /**
     * Export results to JSON file
     */
    public function exportResults(string $filename = 'concurrency_test_results.json'): void
    {
        $results = $this->getResults();
        $json = json_encode($results, JSON_PRETTY_PRINT);

        file_put_contents(storage_path("logs/{$filename}"), $json);
        Log::info("Results exported to: storage/logs/{$filename}");
    }
}
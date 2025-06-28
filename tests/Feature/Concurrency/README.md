# Comprehensive Concurrency Test Suite

This test suite provides extensive coverage for all critical concurrency scenarios in the system, ensuring that database transactions, locking mechanisms, and API endpoints work correctly under high load and overlapping requests.

## Overview

The concurrency test suite is designed to:

-   **Simulate real-world scenarios** where multiple users or jobs access and update the same resources simultaneously
-   **Verify data integrity** by ensuring no race conditions cause data corruption or invalid states
-   **Test both optimistic and pessimistic locking** strategies to demonstrate their differences and effectiveness
-   **Cover failure scenarios** where operations should be rejected due to insufficient funds or conflicting operations
-   **Provide realistic timing** with delays that simulate actual processing times
-   **Generate detailed reports** with clear output for debugging and performance analysis

## Test Categories

### 1. Basic Concurrency Tests (`ComprehensiveConcurrencyTest.php`)

**Purpose**: Test fundamental concurrency scenarios with user balances and product stock management.

**Key Tests**:

-   `test_pessimistic_locking_prevents_overdraft()` - Verifies that pessimistic locking prevents negative balances
-   `test_optimistic_locking_with_retries()` - Tests optimistic locking with retry mechanisms
-   `test_mixed_deposit_withdrawal_operations()` - Tests concurrent deposits and withdrawals
-   `test_product_stock_concurrency()` - Verifies stock management under concurrent orders
-   `test_high_load_multiple_users()` - Tests system behavior with multiple users
-   `test_insufficient_funds_handling()` - Tests rejection of invalid operations
-   `test_product_stock_overselling_prevention()` - Prevents selling more than available stock
-   `test_concurrent_stock_increases_and_decreases()` - Tests mixed stock operations
-   `test_deadlock_prevention()` - Tests deadlock detection and resolution
-   `test_sustained_load_performance()` - Tests performance under extended load
-   `test_zero_amount_operations()` - Tests edge cases with zero amounts
-   `test_negative_amount_handling()` - Tests invalid input handling

### 2. API Concurrency Tests (`ApiConcurrencyTest.php`)

**Purpose**: Test HTTP endpoints under concurrent load to ensure API-level concurrency handling.

**Key Tests**:

-   `test_concurrent_api_requests()` - Tests multiple simultaneous API calls
-   `test_concurrent_product_stock_api_requests()` - Tests stock updates via API
-   `test_race_condition_in_balance_updates()` - Tests balance updates through API
-   `test_api_transaction_isolation()` - Tests transaction isolation in API calls
-   `test_api_rate_limiting_concurrency()` - Tests rate limiting under load
-   `test_api_session_concurrency()` - Tests session handling under concurrency
-   `test_api_cache_invalidation_concurrency()` - Tests cache updates under load
-   `test_api_error_handling_concurrency()` - Tests error handling under load
-   `test_api_database_connection_pooling()` - Tests connection pooling efficiency

### 3. Database Concurrency Tests (`DatabaseConcurrencyTest.php`)

**Purpose**: Test database-level concurrency mechanisms and transaction isolation.

**Key Tests**:

-   `test_transaction_isolation_levels()` - Tests different isolation levels
-   `test_deadlock_detection_and_resolution()` - Tests deadlock handling
-   `test_database_connection_pooling()` - Tests connection management
-   `test_row_level_locking()` - Tests row-level locking mechanisms
-   `test_constraint_violations_under_concurrency()` - Tests constraint handling
-   `test_index_usage_under_concurrent_load()` - Tests index efficiency
-   `test_transaction_rollback_under_concurrency()` - Tests rollback mechanisms
-   `test_connection_timeout_handling()` - Tests timeout scenarios

## Jobs and Services

### Core Jobs

1. **`WithdrawFromAccount`** - Pessimistic locking approach

    - Uses `lockForUpdate()` for row-level locking
    - Simulates 0.5-second processing delay
    - Prevents overdrafts through balance validation

2. **`WithdrawFromAccountOptimistic`** - Optimistic locking approach

    - Uses version checking with retry mechanism
    - Implements exponential backoff for retries
    - Handles concurrent modifications gracefully

3. **`DepositToAccount`** - Account deposits

    - Uses pessimistic locking for consistency
    - Simulates 0.3-second processing delay
    - Safe balance updates

4. **`UpdateProductStock`** - Product inventory management
    - Supports both increase and decrease operations
    - Prevents overselling through stock validation
    - Uses row-level locking for consistency

## Running the Tests

### Using PHPUnit

```bash
# Run all concurrency tests
php artisan test tests/Feature/Concurrency/

# Run specific test class
php artisan test tests/Feature/Concurrency/ComprehensiveConcurrencyTest.php

# Run specific test method
php artisan test --filter test_pessimistic_locking_prevents_overdraft
```

### Using Artisan Command

```bash
# Run all concurrency tests
php artisan test:concurrency

# Run specific category
php artisan test:concurrency --category=basic
php artisan test:concurrency --category=api
php artisan test:concurrency --category=database

# Export results to JSON
php artisan test:concurrency --export
```

### Manual Test Execution

```php
// Run individual tests
$test = new ComprehensiveConcurrencyTest();
$test->setUp();
$test->test_pessimistic_locking_prevents_overdraft();
```

## Test Scenarios Explained

### Race Condition Prevention

**Scenario**: Two users try to withdraw $70 and $50 from an account with $100 balance simultaneously.

**Expected Behavior**:

-   With pessimistic locking: First withdrawal succeeds, second fails due to insufficient funds
-   With optimistic locking: Both may succeed through retries, or one may fail after retries
-   Final balance should never go below $0

**Test**: `test_pessimistic_locking_prevents_overdraft()`

### Optimistic vs Pessimistic Locking

**Pessimistic Locking**:

-   Locks the row immediately when reading
-   Other transactions must wait until lock is released
-   Better for high-contention scenarios
-   May cause deadlocks

**Optimistic Locking**:

-   No locks during read, checks version during update
-   Retries if version has changed
-   Better for low-contention scenarios
-   More efficient but requires retry logic

### Product Stock Management

**Scenario**: Multiple orders try to purchase the same product with limited stock.

**Expected Behavior**:

-   Stock should never go below 0
-   Orders should be rejected when stock is insufficient
-   Final stock should be consistent

**Test**: `test_product_stock_concurrency()`

### High Load Scenarios

**Scenario**: Multiple users perform various operations simultaneously.

**Expected Behavior**:

-   All operations should complete successfully
-   Data consistency should be maintained
-   Performance should remain acceptable

**Test**: `test_high_load_multiple_users()`

## Performance Metrics

The test suite tracks several performance metrics:

-   **Execution Time**: How long each test takes to complete
-   **Success Rate**: Percentage of tests that pass
-   **Concurrency Effectiveness**: How well the system handles concurrent operations
-   **Database Performance**: Query execution times and connection efficiency

## Debugging and Logging

### Log Output

All tests generate detailed logs including:

-   Operation timestamps
-   Balance/stock changes
-   Error messages
-   Performance metrics

### Common Issues

1. **Deadlocks**: May occur with pessimistic locking

    - Solution: Implement retry mechanisms
    - Test: `test_deadlock_detection_and_resolution()`

2. **Race Conditions**: Data inconsistency under concurrent access

    - Solution: Use appropriate locking mechanisms
    - Test: `test_race_condition_in_balance_updates()`

3. **Performance Degradation**: Slow operations under load
    - Solution: Optimize queries and use indexes
    - Test: `test_index_usage_under_concurrent_load()`

## Best Practices

### Database Design

1. **Use appropriate indexes** for frequently queried fields
2. **Implement proper constraints** to prevent invalid data
3. **Choose the right isolation level** for your use case
4. **Use row-level locking** when updating specific records

### Application Design

1. **Keep transactions short** to reduce lock time
2. **Use retry mechanisms** for optimistic locking
3. **Implement proper error handling** for concurrent operations
4. **Monitor performance** under load

### Testing Strategy

1. **Test realistic scenarios** with actual timing delays
2. **Verify both success and failure cases**
3. **Test edge cases** like zero amounts and negative values
4. **Monitor for data consistency** in all scenarios

## Configuration

### Database Configuration

Ensure your database supports:

-   Row-level locking (`SELECT ... FOR UPDATE`)
-   Transaction isolation levels
-   Deadlock detection and resolution

### Queue Configuration

For job-based tests, configure your queue driver:

```php
// config/queue.php
'default' => env('QUEUE_CONNECTION', 'sync'), // Use 'sync' for testing
```

### Logging Configuration

Enable detailed logging for debugging:

```php
// config/logging.php
'level' => env('LOG_LEVEL', 'debug'),
```

## Extending the Test Suite

### Adding New Tests

1. Create test method in appropriate test class
2. Follow naming convention: `test_[scenario_name]()`
3. Include realistic delays with `usleep()`
4. Add proper assertions for expected behavior
5. Document the test scenario

### Adding New Job Types

1. Create job class implementing `ShouldQueue`
2. Use appropriate locking mechanism
3. Include realistic processing delays
4. Add proper error handling
5. Create corresponding tests

### Adding New Scenarios

1. Identify the concurrency scenario
2. Determine appropriate test category
3. Create test with realistic data
4. Add proper assertions
5. Update documentation

## Conclusion

This comprehensive concurrency test suite ensures that your system can handle real-world concurrent scenarios reliably. By testing both optimistic and pessimistic locking strategies, various failure modes, and performance under load, you can be confident that your application will maintain data integrity and provide consistent behavior even under high concurrency.

Regular execution of these tests during development and deployment will help catch concurrency-related issues early and ensure your system remains robust as it scales.

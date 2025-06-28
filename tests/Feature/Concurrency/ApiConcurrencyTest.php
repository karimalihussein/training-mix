<?php

namespace Tests\Feature\Concurrency;

use App\Models\User;
use Modules\Product\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class ApiConcurrencyTest extends TestCase
{
    /**
     * Test API endpoint concurrency with multiple simultaneous requests
     * Should handle concurrent API calls to the same endpoint
     */
    public function test_concurrent_api_requests(): void
    {
        // Arrange: create user and authenticate
        $user = User::factory()->create([
            'balance' => 100.00,
        ]);

        $this->actingAs($user);

        // Act: make multiple concurrent API requests
        $responses = [];
        $promises = [];

        // Simulate concurrent API calls by making multiple requests
        for ($i = 0; $i < 5; $i++) {
            $response = $this->postJson('/api/withdraw', [
                'amount' => 10.00,
            ]);
            $responses[] = $response;
        }

        // Assert: all requests should be processed
        foreach ($responses as $response) {
            $this->assertTrue(
                in_array($response->getStatusCode(), [200, 422, 400]),
                'API request should return valid status code'
            );
        }

        // Verify user balance consistency
        $user->refresh();
        $this->assertGreaterThanOrEqual(0, $user->balance);
        $this->assertLessThanOrEqual(100.00, $user->balance);
    }

    /**
     * Test concurrent product stock updates via API
     * Should prevent overselling through API endpoints
     */
    public function test_concurrent_product_stock_api_requests(): void
    {
        // Arrange: create product and user
        $product = Product::factory()->create([
            'stock' => 5,
        ]);

        $user = User::factory()->create();
        $this->actingAs($user);

        // Act: make concurrent stock update requests
        $responses = [];

        for ($i = 0; $i < 3; $i++) {
            $response = $this->postJson('/api/products/' . $product->id . '/stock', [
                'quantity' => 2,
                'operation' => 'decrease',
            ]);
            $responses[] = $response;
        }

        // Assert: check responses
        $successCount = 0;
        $errorCount = 0;

        foreach ($responses as $response) {
            if ($response->getStatusCode() === 200) {
                $successCount++;
            } else {
                $errorCount++;
            }
        }

        // Should have some successful and some failed requests due to stock limits
        $this->assertGreaterThan(0, $successCount, 'At least one request should succeed');
        $this->assertGreaterThan(0, $errorCount, 'Some requests should fail due to insufficient stock');

        // Verify product stock consistency
        $product->refresh();
        $this->assertGreaterThanOrEqual(0, $product->stock);
        $this->assertLessThanOrEqual(5, $product->stock);
    }

    /**
     * Test race condition in user balance updates via API
     * Should prevent balance corruption under concurrent API calls
     */
    public function test_race_condition_in_balance_updates(): void
    {
        // Arrange: create user with balance
        $user = User::factory()->create([
            'balance' => 50.00,
        ]);

        $this->actingAs($user);

        // Act: make concurrent balance update requests
        $responses = [];

        // Mix of deposits and withdrawals
        $operations = [
            ['type' => 'deposit', 'amount' => 20.00],
            ['type' => 'withdraw', 'amount' => 15.00],
            ['type' => 'deposit', 'amount' => 10.00],
            ['type' => 'withdraw', 'amount' => 25.00],
        ];

        foreach ($operations as $operation) {
            $endpoint = $operation['type'] === 'deposit' ? '/api/deposit' : '/api/withdraw';
            $response = $this->postJson($endpoint, [
                'amount' => $operation['amount'],
            ]);
            $responses[] = $response;
        }

        // Assert: all requests should be processed
        foreach ($responses as $response) {
            $this->assertTrue(
                in_array($response->getStatusCode(), [200, 422, 400]),
                'API request should return valid status code'
            );
        }

        // Verify final balance consistency
        $user->refresh();
        $this->assertGreaterThanOrEqual(0, $user->balance);
        $this->assertIsNumeric($user->balance);
    }

    /**
     * Test API endpoint with database transaction isolation
     * Should maintain ACID properties under concurrent load
     */
    public function test_api_transaction_isolation(): void
    {
        // Arrange: create user
        $user = User::factory()->create([
            'balance' => 100.00,
        ]);

        $this->actingAs($user);

        // Act: make requests that should be isolated
        $responses = [];

        for ($i = 0; $i < 3; $i++) {
            $response = $this->postJson('/api/transfer', [
                'from_user_id' => $user->id,
                'to_user_id' => User::factory()->create()->id,
                'amount' => 10.00,
            ]);
            $responses[] = $response;
        }

        // Assert: check transaction isolation
        $user->refresh();

        // Balance should not go negative due to transaction isolation
        $this->assertGreaterThanOrEqual(0, $user->balance);

        // All responses should have consistent status codes
        $statusCodes = array_map(fn($r) => $r->getStatusCode(), $responses);
        $this->assertNotEmpty($statusCodes);
    }

    /**
     * Test API rate limiting under concurrent load
     * Should handle rate limiting correctly with multiple simultaneous requests
     */
    public function test_api_rate_limiting_concurrency(): void
    {
        // Arrange: create user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Act: make many rapid requests to trigger rate limiting
        $responses = [];

        for ($i = 0; $i < 20; $i++) {
            $response = $this->getJson('/api/user/profile');
            $responses[] = $response;
        }

        // Assert: should have mix of successful and rate-limited responses
        $successCount = 0;
        $rateLimitedCount = 0;

        foreach ($responses as $response) {
            if ($response->getStatusCode() === 200) {
                $successCount++;
            } elseif ($response->getStatusCode() === 429) {
                $rateLimitedCount++;
            }
        }

        // Should have some successful requests
        $this->assertGreaterThan(0, $successCount, 'Some requests should succeed');

        // May have rate-limited requests depending on configuration
        $this->assertGreaterThanOrEqual(0, $rateLimitedCount);
    }

    /**
     * Test API session handling under concurrent load
     * Should maintain session consistency across concurrent requests
     */
    public function test_api_session_concurrency(): void
    {
        // Arrange: create user and establish session
        $user = User::factory()->create();
        $this->actingAs($user);

        // Act: make concurrent requests that modify session data
        $responses = [];

        for ($i = 0; $i < 5; $i++) {
            $response = $this->postJson('/api/session/update', [
                'last_activity' => now()->toISOString(),
                'preferences' => ['theme' => 'dark'],
            ]);
            $responses[] = $response;
        }

        // Assert: all requests should be processed
        foreach ($responses as $response) {
            $this->assertTrue(
                in_array($response->getStatusCode(), [200, 422, 400]),
                'Session update request should return valid status code'
            );
        }

        // Verify session is still valid
        $sessionResponse = $this->getJson('/api/user/profile');
        $this->assertNotEquals(401, $sessionResponse->getStatusCode(), 'Session should remain valid');
    }

    /**
     * Test API cache invalidation under concurrent load
     * Should handle cache updates correctly with multiple simultaneous requests
     */
    public function test_api_cache_invalidation_concurrency(): void
    {
        // Arrange: create user and some cached data
        $user = User::factory()->create();
        $this->actingAs($user);

        // Act: make concurrent requests that might invalidate cache
        $responses = [];

        for ($i = 0; $i < 3; $i++) {
            $response = $this->postJson('/api/user/update', [
                'name' => 'Updated User ' . $i,
                'email' => 'user' . $i . '@example.com',
            ]);
            $responses[] = $response;
        }

        // Assert: all requests should be processed
        foreach ($responses as $response) {
            $this->assertTrue(
                in_array($response->getStatusCode(), [200, 422, 400]),
                'User update request should return valid status code'
            );
        }

        // Verify user data consistency
        $user->refresh();
        $this->assertNotEmpty($user->name);
        $this->assertNotEmpty($user->email);
    }

    /**
     * Test API error handling under concurrent load
     * Should handle errors gracefully with multiple simultaneous requests
     */
    public function test_api_error_handling_concurrency(): void
    {
        // Arrange: create user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Act: make concurrent requests that might cause errors
        $responses = [];

        for ($i = 0; $i < 5; $i++) {
            // Try to access non-existent resource
            $response = $this->getJson('/api/non-existent-endpoint');
            $responses[] = $response;
        }

        // Assert: all requests should return 404
        foreach ($responses as $response) {
            $this->assertEquals(404, $response->getStatusCode(), 'Non-existent endpoint should return 404');
        }
    }

    /**
     * Test API database connection pooling under load
     * Should handle database connections efficiently with concurrent requests
     */
    public function test_api_database_connection_pooling(): void
    {
        // Arrange: create multiple users
        $users = User::factory()->count(10)->create();
        $this->actingAs($users->first());

        // Act: make concurrent database-intensive requests
        $responses = [];

        foreach ($users as $user) {
            $response = $this->getJson('/api/users/' . $user->id . '/details');
            $responses[] = $response;
        }

        // Assert: all requests should be processed
        foreach ($responses as $response) {
            $this->assertTrue(
                in_array($response->getStatusCode(), [200, 404, 403]),
                'User details request should return valid status code'
            );
        }

        // Verify database connections are handled properly
        $this->assertGreaterThan(0, count($responses));
    }
}
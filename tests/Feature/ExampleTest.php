<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');
        $response->assertSeeInOrder(['Documentation', 'Laracasts']);

        $response->assertStatus(200);
    }

    /**
     * A basic test example for about route
     *
     * @return void
     */
    public function test_the_about_route_returns_a_successful_response()
    {
        $response = $this->get('/about');

        $response->assertSee('about');

        $response->assertStatus(200);
    }
}

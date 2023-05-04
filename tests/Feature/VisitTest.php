<?php

namespace Tests\Feature;

use App\Models\Series;
use App\Models\User;
use Tests\TestCase;

class VisitTest extends TestCase
{
    /**
     * test to create visit
     */
    public function test_to_create_visit()
    {
        $series = Series::factory()->create();
        $series->visit();
        $this->assertCount(1, $series->visits);
    }

    /**
     * test to create visit with default ip address
     *
     * @test
     *
     * @return void
     */
    public function test_to_create_visit_with_default_ip_address()
    {
        $series = Series::factory()->create();
        $series->visit()->withIp();
        $this->assertCount(1, $series->visits);
        $this->assertEquals($series->visits->first()->data['ip'], request()->ip());
    }

    /**
     * test to create visit with Givien ip address
     *
     * @test
     *
     * @return void
     */
    public function test_to_create_visit_with_given_ip_address()
    {
        $series = Series::factory()->create();
        $series->visit()->withIp('localhost');
        $this->assertCount(1, $series->visits);
        $this->assertEquals($series->visits->first()->data['ip'], 'localhost');

    }

    /**
     * test to create visit with default user agent
     *
     * @test
     *
     * @return void
     */
    public function test_to_create_visit_with_default_user_agent()
    {
        $series = Series::factory()->create();
        $series->visit()->withUserAgent();
        $this->assertCount(1, $series->visits);
        $this->assertEquals($series->visits->first()->data['user_agent'], request()->header('User-Agent'));

    }

    /**
     * test to create visit with custom data
     *
     * @test
     *
     * @return void
     */
    public function test_to_create_visit_with_custom_data()
    {
        $series = Series::factory()->create();
        $series->visit()->withData(['test' => 'test']);
        $this->assertCount(1, $series->visits);
        // $this->assertEquals($series->visits->first()->data['test'],  'test');
    }

    /**
     * test to create visit with default user
     *
     * @test
     *
     * @return void
     */
    public function test_to_create_visit_with_default_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $series = Series::factory()->create();
        $series->visit()->withUser();
        $this->assertCount(1, $series->visits);
        $this->assertEquals($series->visits->first()->data['user_id'], $user->id);

    }
}

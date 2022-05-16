<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AchievementTest extends TestCase
{

    public function when_createing_achievement_some_fields_are_required()
    {
        $res = $this->postJson('/api/achievements', []);
        $res->assertStatus(422);
        $res->assertJsonStructure([
            'message',
            'errors' => [
                'name',
                'user_id',
                'datails',
            ],
        ]);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_api_can_create_achievement()
    {

        $response = $this->json('POST', '/api/achievements', [
            'name'        => 'test',
            'user_id'     => 1,
            'datails'     => 'test',
        ]);

        $response->assertStatus(201);



        
       
      
    }
}

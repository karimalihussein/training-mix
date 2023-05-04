<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AchievementTest extends TestCase
{
    public function when_createing_achievement_some_fields_are_required()
    {
        $url = route('achievements.store');
        $res = $this->postJson($url, []);
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
        $user = User::factory()->create();
        $url = route('achievements.store');
        $response = $this->postJson($url, [
            'name' => 'test',
            'user_id' => $user->id,
            'datails' => 'test',
        ]);

        $response->assertStatus(201);

    }
}

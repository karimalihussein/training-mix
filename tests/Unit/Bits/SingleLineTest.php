<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SingleLineTest extends TestCase
{
    public function test_is_user_can_gatway()
    {
        $user = User::factory()->create(['is_admin' => false]);
        $this->assertFalse($user->can('admin'));
    }
}

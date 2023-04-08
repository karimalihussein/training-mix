<?php

namespace Tests\Unit\Bits;


use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class SingleLineTest extends TestCase
{
    
    
    public function test_is_user_can_gatway()
    {
        $user = User::factory()->create(['is_admin' => false]);
        $this->assertFalse($user->can('admin'));
    }
}

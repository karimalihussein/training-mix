<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ThreadTest extends TestCase
{
  
    
   function test_speed_considirations()
   {
        $this->artisan('migrate:fresh');
        Thread::withoutEvents(function () {
          $threads =  Thread::factory(10)
            ->forUser()
            ->forCategory()
            // ->hasReplies(10, ['user_id' => User::factory()->create()->id])
            ->raw();
            Thread::insert($threads);
        });

        
        
   }
}

<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    public function test_speed_considirations()
    {
        $this->artisan('migrate:fresh');
        Thread::withoutEvents(function () {
            $threads = Thread::factory(10)
                ->forUser()
                ->forCategory()
              // ->hasReplies(10, ['user_id' => User::factory()->create()->id])
                ->raw();
            Thread::insert($threads);
        });

    }
}

<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\UserCreated;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(UserCreated $event)
    {
        \Log::info('User created:');
    }
}

<?php

namespace Modules\Booking\Providers;

use Illuminate\Support\ServiceProvider;

final class BookingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'booking');
        $this->app->register(RouteServiceProvider::class);
    }
}
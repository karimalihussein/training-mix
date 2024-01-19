<?php

namespace Modules\Shipment\Providers;

use Illuminate\Support\ServiceProvider;

final class ShipmentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'shipment');
        $this->app->register(RouteServiceProvider::class);
    }
}
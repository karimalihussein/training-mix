<?php

namespace App\Providers;

use App\Services\Geolocation\Geolocation;
use App\Services\Maps\Map;
use App\Services\Maps\Statelite;
use Illuminate\Support\ServiceProvider;

class GeolocationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Geolocation::class, function ($app) {
            return new Geolocation(new Map(), new Statelite());
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

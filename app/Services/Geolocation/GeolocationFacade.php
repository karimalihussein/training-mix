<?php

declare(strict_types=1);

namespace App\Services\Geolocation;

use Illuminate\Support\Facades\Facade;

class GeolocationFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Geolocation::class;
    }
}

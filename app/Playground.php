<?php

declare(strict_types=1);

namespace App;

use App\Services\Geolocation\Geolocation;
use App\Services\Geolocation\GeolocationFacade;

class Playground
{
    public function __construct(Geolocation $geolocation)
    {
        $result = GeolocationFacade::search('New York');
        dd($result);
    }
}

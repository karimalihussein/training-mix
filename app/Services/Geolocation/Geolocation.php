<?php

namespace App\Services\Geolocation;

use App\Services\Maps\Map;
use App\Services\Maps\Statelite;

class Geolocation
{
    public function __construct(private Map $map, private Statelite $statelite)
    {
        $this->map = $map;
        $this->statelite = $statelite;
    }

    public function search(string $name): array
    {
        $locationInfo = $this->map->findAddress($name);
        return $this->statelite->pinpoint($locationInfo);
    }
}
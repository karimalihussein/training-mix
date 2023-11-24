<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    public function __invoke()
    {
        $geoplugin = Http::get('http://www.geoplugin.net/json.gp?ip=156.220.150.14');
        $geoplugin = $geoplugin->json();
        $geoplugin = json_decode(json_encode($geoplugin), true);
        dd($geoplugin);
    }
}

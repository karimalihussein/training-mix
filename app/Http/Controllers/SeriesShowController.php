<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Models\Visit;
use Illuminate\Http\Request;

class SeriesShowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Series $series)
    {
        $series->visit()->withIp()->withUserAgent()->withUser();
        return $series->load(['visits']);
       
        // return view('series.show', [
        //     'series' => $series
        // ]);
    }
}

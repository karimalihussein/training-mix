<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SimpleController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $series)
    {
        $series->visit()->withIp()->withUserAgent()->withUser();
        return $series->load(['visits']);

        // return view('series.show', [
        //     'series' => $series
        // ]);
    }
}

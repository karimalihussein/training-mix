<?php

namespace App\Http\Controllers;

use App\Services\SimpleService;
use Illuminate\Http\Request;

class SimpleController extends Controller
{
    public function __construct(SimpleService $simpleService)
    {
        $this->simpleService = $simpleService;
    }



    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $series, SimpleService $simpleService)
    {
        $this->simpleService->log('SimpleController invoked');
    }

    private function check1()
    {
        $this->simpleService->log('SimpleController check1');
    }

    private function check2()
    {
        $this->simpleService->log('SimpleController check2');
    }
}

<?php

declare(strict_types=1);

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
        $simpleService->log('SimpleController invoked');
        // $this->check1($simpleService);
    }

    private function check1($simpleService)
    {
        $simpleService->log('SimpleController check1');
        $this->check2($simpleService);
    }

    private function check2($simpleService)
    {
        $simpleService->log('SimpleController check2');
    }
}

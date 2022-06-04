<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestContoller extends Controller
{
    public function __invoke()
    {
        // dd(env('APP_NAME'));

        // return config('app.test_url');
        // dd(config(('database.connections.mysql')));

        dd(config('hyperpay'));
    }
}

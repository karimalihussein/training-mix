<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        return view('tests.index');
    }

    public function store()
    {
        sleep(1);

        \Log::info('Form submitted');
    }
}

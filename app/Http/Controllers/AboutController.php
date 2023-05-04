<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\View\View $view
     */
    public function __invoke(Request $request): View
    {
        return view('about.index');
    }
}

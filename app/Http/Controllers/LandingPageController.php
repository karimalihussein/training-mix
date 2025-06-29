<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class LandingPageController extends Controller
{
    public function mrEgyptToken()
    {
        return Inertia::render('LandingPage/MREgyptToken', [
            'template' => 'mr-egypt-token'
        ]);
    }
}
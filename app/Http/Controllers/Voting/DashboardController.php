<?php

declare(strict_types=1);

namespace App\Http\Controllers\Voting;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('voting.dashboard');
    }
}

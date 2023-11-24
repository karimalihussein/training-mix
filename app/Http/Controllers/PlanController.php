<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Bpuig\Subby\Models\Plan;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();

        return $plans;
        // return view('plans.index');
    }
}

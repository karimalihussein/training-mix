<?php

namespace App\Http\Controllers;

use Bpuig\Subby\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return $plans;
        // return view('plans.index');
    }
}

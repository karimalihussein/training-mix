<?php

namespace App\Http\Controllers\Billing\Cashier;

use App\Models\Cashier\Plan;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    public function index() {
       return Plan::all();
    }    
}

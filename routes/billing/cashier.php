<?php

use App\Http\Controllers\Billing\Cashier\PlanController;
use Illuminate\Support\Facades\Route;




Route::get('plans', [PlanController::class, 'index']);
Route::get('plans/{id}', [PlanController::class, 'show']);
<?php

use App\Http\Controllers\Billing\Cashier\PlanController;
use App\Http\Controllers\Billing\Cashier\SubscriptionController;
use Illuminate\Support\Facades\Route;




Route::get('plans', [PlanController::class, 'index']);
Route::get('plans/{id}', [PlanController::class, 'show']);

Route::get('subscribe', [SubscriptionController::class, 'subscribe']);
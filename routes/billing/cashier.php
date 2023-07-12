<?php

use App\Http\Controllers\Billing\Cashier\PlanController;
use App\Http\Controllers\Billing\Cashier\SubscriptionController;
use Illuminate\Support\Facades\Route;




Route::get('plans', [PlanController::class, 'index']);
Route::get('plans/{id}', [PlanController::class, 'show']);

Route::post('free-trial', [SubscriptionController::class, 'useFreeTrial']);
Route::post('subscribe/{id}', [SubscriptionController::class, 'subscribe']);
Route::get('my-subscription', [SubscriptionController::class, 'mySubscription']);
Route::get('my-subscription-details', [SubscriptionController::class, 'mySubscriptionsDetails']);

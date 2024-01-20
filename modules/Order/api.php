<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\CheckoutController;

Route::post('checkout', CheckoutController::class)->name('checkout.store')->middleware('auth:sanctum');

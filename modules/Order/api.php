<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\CheckoutController;

Route::post('checkout', CheckoutController::class)->name('checkout.store')->middleware('auth:sanctum');
Route::get('orders/{order}', fn (Modules\Order\Models\Order $order) => $order->load('lines.product'))->name('orders.show')->middleware('auth:sanctum');
<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\HostReservationController;
use App\Http\Controllers\Integrations\Payments\HyperpayController;
use App\Http\Controllers\Integrations\TwilioPhoneCallController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\OfficeImageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\Tenant\Auth\RegisterTenantController;
use App\Http\Controllers\TestContoller;
use App\Http\Controllers\UserReservationController;
use App\Http\Controllers\V2\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\LocationController;




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





Route::get('tags', TagController::class);
Route::get('test', TestContoller::class);

Route::post('achievements', [AchievementController::class, 'store'])->name('achievements.store');
Route::post('invoices/{order}', [InvoiceController::class, 'store']);
Route::get('offices', [OfficeController::class, 'index']);

Route::get('offices/{office}', [OfficeController::class, 'show']);

Route::post('offices', [OfficeController::class, 'store'])->middleware(['auth:sanctum', 'verified']);
Route::put('offices/{office}', [OfficeController::class, 'update'])->middleware(['auth:sanctum', 'verified']);
Route::delete('offices/{office}', [OfficeController::class, 'delete'])->middleware(['auth:sanctum', 'verified']);
Route::post('/offices/{office}/images', [OfficeImageController::class, 'store'])->middleware(['auth:sanctum', 'verified']);
Route::delete('/offices/{office}/images/{image}', [OfficeImageController::class, 'delete'])->middleware(['auth:sanctum', 'verified']);

Route::get('reservations', [UserReservationController::class, 'index'])->middleware(['auth:sanctum', 'verified']);
Route::get('/host/reservations', [HostReservationController::class, 'index'])->middleware(['auth:sanctum', 'verified']);

Route::post('reservations', [UserReservationController::class, 'store'])->middleware(['auth:sanctum', 'verified']);




Route::post('posts', [PostController::class, 'store'])->middleware(['auth:sanctum', 'verified']);





Route::group(['prefix' => 'integrations'], function () {

    Route::group(['prefix' => 'payments'], function () {
        Route::group(['prefix' => 'hyperpay'], function () {
            Route::get('checkout', [HyperpayController::class, 'checkout']);
            Route::get('callback', [HyperpayController::class, 'callback'])->name('integrations/payments/hyperpay/callback');

        });

    });

    Route::group(['prefix' => 'twilio'], function () {
        Route::get('call', [TwilioPhoneCallController::class, 'index']);
    });

});



Route::post('register', RegisterTenantController::class);




Route::apiResource('users', UsersController::class);


Route::get('location', LocationController::class);

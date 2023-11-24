<?php

declare(strict_types=1);

use App\Helpers\Routes\RouteHelper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\SimpleController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WhatsappController;
use App\Http\Controllers\V2\InvoiceController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\OfficeImageController;
use App\Http\Controllers\HostReservationController;
use App\Http\Controllers\UserReservationController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Integrations\Calls\Agora\AgoraController;
use App\Http\Controllers\Integrations\Payments\PaypalController;
use App\Http\Controllers\Integrations\TwilioPhoneCallController;
use App\Http\Controllers\Integrations\Payments\HyperpayController;
use Illuminate\Http\Request;

Route::get('test', [TestController::class, 'index']);


Route::get('whatsapp', [WhatsappController::class, 'index']);
Route::get('tags', TagController::class);
Route::post('achievements', [AchievementController::class, 'store'])->name('achievements.store');
Route::post('invoices/{order}', [InvoiceController::class, 'store'])->name('invoices.store');
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
Route::post('posts', [PostController::class, 'store'])->middleware(['auth:sanctum', 'verified'])->name('posts.store');
/** test integrations endpoints  */
Route::group(['prefix' => 'integrations'], function () {
    Route::group(['prefix' => 'payments'], function () {
        Route::group(['prefix' => 'hyperpay'], function () {
            Route::get('checkout', [HyperpayController::class, 'checkout']);
            Route::get('callback', [HyperpayController::class, 'callback'])->name('integrations/payments/hyperpay/callback');
        });

        Route::group(['prefix' => 'paypal'], function () {
            Route::post('create', [PaypalController::class, 'create']);
            Route::post('orders/{orderId}/capture', [PaypalController::class, 'capture']);
        });
    });
    Route::group(['prefix' => 'twilio'], function () {
        Route::get('call', [TwilioPhoneCallController::class, 'index']);
    });

    Route::group(['prefix' => 'agora'], function () {
        Route::get('chat', [AgoraController::class, 'index']);
        Route::post('token', [AgoraController::class, 'token']);
        Route::post('call-user', [AgoraController::class, 'callUser']);
    });

});

Route::apiResource('users', UserController::class);



Route::get('steps', [StepController::class, 'index']);
Route::get('steps/create', [StepController::class, 'store']);
Route::get('steps/refresh', [StepController::class, 'refresh']);
Route::get('features', [FeatureController::class, 'index']);
Route::get('/payments/verify/{payment?}', function (Request $request) {
    // log the payment
    \Illuminate\Support\Facades\Log::info("$request->all()");
})->name('payment-verify');
Route::post('registration', RegistrationController::class);

Route::get('simple', SimpleController::class);

Route::post('folders', FolderController::class);

Route::prefix('v1')->group(function () {
    RouteHelper::includeRouteFiles(__DIR__.'/api/v1');
});

Route::prefix('v2')->group(function () {
    RouteHelper::includeRouteFiles(__DIR__.'/api/v2');
});

Route::post('pay/{id}', [PaymentController::class, 'pay'])->name('payment');
Route::get('success', [PaymentController::class, 'success']);
Route::get('error', [PaymentController::class, 'error']);



Route::prefix('billing')->group(function () {
    RouteHelper::includeRouteFiles(__DIR__.'/billing');
});

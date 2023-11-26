<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('users', function () {
    return response()->json([
        'message' => 'this is from v1 api',
    ]);
});


Route::get('messages', [\App\Http\Controllers\Api\V1\MessagesController::class, 'index'])->middleware('treblle');

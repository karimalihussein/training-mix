<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('test', function(){
    return "test";
});

Route::get('dd', function(){
    dd(\Exceptions\Handler::renderForConsole());
});


Route::apiResource('customers', CustomerController::class);
Route::apiResource('posts', PostController::class);

Route::post('achievements', [AchievementController::class, 'store'])->name('achievements.store');
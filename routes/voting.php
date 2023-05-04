<?php

use App\Http\Controllers\Voting\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Voting\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// voting routes start

Route::group(['prefix' => 'voting', 'as' => 'voting.'], function () {

    Route::get('/', function(){
        return redirect()->route('voting.dashboard.index');
    });


    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest')->name('login');

    Route::group(['middleware' => 'auth', 'prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
        Route::get('/', DashboardController::class)->name('index');
        Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });







});

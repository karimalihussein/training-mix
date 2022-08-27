<?php

use App\Http\Controllers\ProfileUpdatePassword;
use App\Http\Controllers\SeriesIndexController;
use App\Http\Controllers\SeriesShowController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


Route::get('/series', SeriesIndexController::class)->name('series.index');
Route::get('series/{series:slug}', SeriesShowController::class);

Route::get('profile', [ProfileUpdatePassword::class, 'index']);
Route::post('profile/update-password', [ProfileUpdatePassword::class, 'updatePassword'])->name('profile.update-password');
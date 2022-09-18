<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\Documentation\ReferencesController;
use App\Http\Controllers\GihtubController;
use App\Http\Controllers\ProfileUpdatePassword;
use App\Http\Controllers\SeriesIndexController;
use App\Http\Controllers\SeriesShowController;
use App\Http\Controllers\UserController;
use Bpuig\Subby\Models\Plan;
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
Route::get('auth/github/redirect', [GihtubController::class, 'redirectToProvider']);
Route::get('auth/github/callback', [GihtubController::class, 'handleProviderCallback']);


Route::get('/series', SeriesIndexController::class)->name('series.index');
Route::get('series/{series:slug}', SeriesShowController::class);

Route::get('profile', [ProfileUpdatePassword::class, 'index']);
Route::post('profile/update-password', [ProfileUpdatePassword::class, 'updatePassword'])->name('profile.update-password');


// Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
// Route::get('users', [UserController::class, 'index'])->name('users.index');

// auth middleware is applied to all routes in this group
Route::middleware(['auth'])->group(function () {
    Route::get('check-out', [CheckOutController::class, 'store'])->name('check-out.store');
});

Route::get('composer-packages', [ReferencesController::class, 'getComposerPackages']);
Route::get('npm-packages', [ReferencesController::class, 'getNpmPackages']);

// routes for subscriptions users
Route::get('articles', [ArticleController::class, 'index'])->name('articles.index')->middleware('subscribed:articles-management');

// Route::get('plans', [PlanController::class, 'index'])->name('plans');

Route::get('/chatbot', function () {
    return view('chatbot.chatbot');
});
Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle']);

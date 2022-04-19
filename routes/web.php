<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConcertsController;
use App\Models\Concert;
use Carbon\Carbon;

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



Route::get('/concerts/{id}', [ConcertsController::class, 'show']);


Route::get('dummydata', function(){
    //   \App\Models\Concert::factory()->count(30)->create(); 
    $concert =  Concert::factory()->create([
        'date' => Carbon::parse('2017-12-31 8:00pm'),
     ]);
     return $concert->formatted_date;
});



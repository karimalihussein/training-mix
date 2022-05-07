<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PayOrderController;
use App\Http\Controllers\PostController;
use App\Postcard;
use App\PostcardSendingService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;


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
    // return Response::errorJson('karim ali hussein');
    // dd(str::partNumber('123456789'));
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::group(['middleware' => ['auth','cache.response:5']], function () {
         Route::resource('pages', PageController::class);
});


Route::get('payment-gatway', [PayOrderController::class, 'store'])->name('payment-gatway');


Route::get('postcards', function(){
    $post = new PostcardSendingService('USA', 10, 10);
    $post->hello('Hello World', 'test@test.com');
  
});


Route::get('facades', function(){
  return  $post = Postcard::hello('Hello World', 'test@gmail.com');
  
});


// Route::resource('customers', CustomerController::class);

Route::get('lazy', function(){
        $collation = LazyCollection::times(100000)->map(function ($number){
                return pow(2,$number);
        })
        ->all();
        return "done";
       
});

Route::get('generator', function(){
            function happyFunction($string){
                yield $string;
            }
     return get_class(happyFunction('test'));
});

Route::get('about', function(){
    return "about page";
});
<?php

use Illuminate\Support\Facades\Route;






Route::get('users', function(){
    return response()->json([
        'message' => 'this is from v1 api'
    ]);
});
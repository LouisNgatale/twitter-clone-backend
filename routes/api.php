<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TweetController;
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

Route::namespace('Api')->group(function(){

    // Doesn't require authentication to access these routes
    Route::prefix('auth')->group(function(){

        Route::post('login',[LoginController::class,'login']);
        Route::post('register',[RegistrationController::class,'register']);

    });


    // Requires authentication to access these routes
    Route::group([
        'middleware'=>'auth:sanctum'
    ], function(){
        // Tweets
        Route::get('tweets',[TweetController::class,'get']);
        Route::post('logout',[LoginController::class,'logout']);

    });



});

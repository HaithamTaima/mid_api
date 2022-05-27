<?php

use App\Http\Controllers\APIs\LikeController;
use App\Http\Controllers\APIs\TweetController;
use App\Http\Controllers\APIs\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





Route::get('getall',[TweetController::class,'index']);



Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::resource('user', UserController::class);
    Route::resource('tweet', TweetController::class);
    Route::resource('like',LikeController::class);
//    Route::post('/tweet/{user_id}',[TweetController::class,'store']);

});
Route::get('user/{id}',[UserController::class,'profile']);


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

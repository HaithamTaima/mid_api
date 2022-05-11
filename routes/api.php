<?php

use App\Http\Controllers\APIs\TweetController;
use App\Http\Controllers\APIs\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// put all api protected routes here
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::resource('user', UserController::class);
    Route::resource('tweet', TweetController::class);
});

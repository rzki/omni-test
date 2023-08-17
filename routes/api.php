<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use Spatie\HttpLogger\Middlewares\HttpLogger;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(HttpLogger::class)->group(function () {
    Route::name('api.')->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::post('/login', 'login')->name('login');
            Route::post('/register', 'register')->name('register');
        });
    });

    Route::middleware('auth:api')->group( function () {
        Route::resource('users', UserController::class);
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});

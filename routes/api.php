<?php

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

Route::prefix('v1')->middleware('jwt.auth')->group(function () {
    Route::apiResource('brand', 'App\Http\Controllers\BrandController');
    Route::apiResource('car-model', 'App\Http\Controllers\CarModelController');
    Route::apiResource('car', 'App\Http\Controllers\CarController');
    Route::apiResource('client', 'App\Http\Controllers\ClientController');
    Route::apiResource('rental', 'App\Http\Controllers\RentalController');

    Route::prefix('auth')->middleware('api')->group(function ($router) {
        Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
        Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout']);
        Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh']);
        Route::post('me', [App\Http\Controllers\AuthController::class, 'me']);
    });
});

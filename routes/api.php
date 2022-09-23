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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('brand', 'App\Http\Controllers\BrandController');

Route::apiResource('car-model', 'App\Http\Controllers\CarModelController');

Route::apiResource('car', 'App\Http\Controllers\CarController');

Route::apiResource('client', 'App\Http\Controllers\ClientController');

Route::apiResource('rental', 'App\Http\Controllers\RentalController');

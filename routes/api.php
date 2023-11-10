<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\StationsController;
use App\Http\Controllers\Api\SlideController;
use App\Http\Controllers\Api\RouteController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    Route::post('login', [AuthenticationController::class, 'store']);
    Route::post('logout', [AuthenticationController::class, 'destroy'])->middleware('auth:api');
});

Route::middleware(['cors'])->prefix('v2')->group(function () {
    Route::controller(StationsController::class)->group(function() {
        Route::get('stations/get', 'getStations');
    });
    Route::controller(SlideController::class)->group(function() {
        Route::get('slide/get', 'getSlide');
    });
    Route::controller(RouteController::class)->group(function() {
        Route::get('route/search/{from}/{to}', 'searchRoute');
    });
});

Route::middleware(['seven'])->prefix('v3')->group(function() {
    Route::controller(RouteController::class)->group(function() {
        Route::get('route/all', 'getAllRoute');
        Route::get('route/{id}', 'getRouteById');
        Route::get('route/from/{id}', 'getRouteByStationFrom');
        Route::get('route/to/{id}', 'getRouteByStationTo');
    });

    Route::controller(StationsController::class)->group(function() {
        Route::get('stations', 'getAllStation');
    });
});
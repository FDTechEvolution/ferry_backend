<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\StationsController;
use App\Http\Controllers\Api\SlideController;
use App\Http\Controllers\Api\RouteController;
use App\Http\Controllers\Api\BookingController as OnlineBooking;
use App\Http\Controllers\Api\TimetableController;
use App\Http\Controllers\Api\RouteMapController;
use App\Http\Controllers\Api\PaymentController;

// 7 Controller
use App\Http\Controllers\Api\Seven\BookingController as SevenBooking;

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

Route::prefix('v1')->group(function() {
    Route::controller(PaymentController::class)->group(function() {
        Route::post('payment/get-response', 'paymentResponse');
    });
});

Route::middleware(['cors'])->prefix('v1')->group(function () {
    Route::controller(StationsController::class)->group(function() {
        Route::get('stations/get', 'getStations');
    });
    Route::controller(SlideController::class)->group(function() {
        Route::get('slide/get', 'getSlide');
    });
    Route::controller(RouteController::class)->group(function() {
        Route::get('route/search/{from}/{to}', 'searchRoute');
    });

    Route::prefix('online-booking')->group(function() {
        Route::controller(OnlineBooking::class)->group(function() {
            Route::post('create', 'store');
            Route::get('record/{id}', 'bookingRecord');
        });
    });

    Route::controller(TimeTableController::class)->group(function() {
        Route::get('time-table/get', 'getTimetable');
    });

    Route::controller(RouteMapController::class)->group(function() {
        Route::get('route-map/get', 'getRouteMap');
    });
});


// Route Api for 7seven
Route::middleware(['seven'])->prefix('v1')->group(function() {
    Route::controller(RouteController::class)->group(function() {
        // Route::get('route/all', 'getAllRoute');
        // Route::get('route/{id}', 'getRouteById');
        Route::get('route/from/{id}', 'getRouteByStationFrom');
        Route::get('route/to/{id}', 'getRouteByStationTo');
        Route::get('route/get/{from}/{to}', 'getRouteByStation');
    });

    Route::controller(StationsController::class)->group(function() {
        // Route::get('stations/all', 'getAllStation');
        Route::get('stations', 'getStationFromRoute');
    });

    // Booking
    Route::prefix('booking')->group(function() {
        Route::controller(SevenBooking::class)->group(function() {
            Route::post('create', 'store');
            Route::post('complete', 'complete');
            Route::post('cancel', 'destroy');
            Route::post('update', 'update');

            Route::get('get/{id}', 'getBookingById');
        });
    });
});
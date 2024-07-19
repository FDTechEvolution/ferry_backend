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
use App\Http\Controllers\Api\PromotionController;
use App\Http\Controllers\Api\InfomationController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\Api\BillboardController;
use App\Http\Controllers\Api\PremiumFlexController;
use App\Http\Controllers\Api\EmailController;

// 7 Controller
use App\Http\Controllers\Api\Seven\BookingController as SevenBooking;
use App\Http\Controllers\Api\Seven\StationController as SevenStation;
use App\Http\Controllers\Api\Seven\RouteController as SevenRoute;

// Agent Controller
use App\Http\Controllers\Api\Agent\RouteController as AgentRoute;
use App\Http\Controllers\Api\Agent\StationController as AgentStation;
use App\Http\Controllers\Api\Agent\BookingController as AgentBooking;

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
        Route::post('payment/ctsv-response', 'paymentCtsvResponse');
    });
});

Route::prefix('v2')->group(function() {
    Route::controller(EmailController::class)->group(function() {
        Route::get('email/send', 'sendEmail');
    });
});

Route::middleware(['cors'])->prefix('v1')->group(function () {
    Route::controller(StationsController::class)->group(function() {
        Route::get('stations/get', 'getStations');
        Route::get('stations/route', 'getStationFromRoute');
        Route::get('stations/get/to/{from_id}', 'getToStation');
        Route::get('stations/get/nickname/{nickname}', 'getStationByNickname');
        Route::get('stations/get/type', 'getStationType');
    });
    Route::controller(SlideController::class)->group(function() {
        Route::get('blog/get', 'getBlog');
        Route::get('blog/get-blog/{slug}', 'getBlogBySlug');
    });
    Route::controller(BillboardController::class)->group(function() {
        Route::get('billboard/get', 'getBillboard');
    });
    Route::controller(RouteController::class)->group(function() {
        Route::get('route/search/{from}/{to}/{date}', 'searchRoute');
    });

    Route::prefix('online-booking')->group(function() {
        Route::controller(OnlineBooking::class)->group(function() {
            Route::post('create', 'store');
            Route::post('create/multi', 'storeMultiTrip');
            Route::get('record/{bookingno}/{email}', 'bookingRecord');
            Route::get('check/person/{booking_current}/{booking_new}', 'bookingCheckRoute');
            Route::post('merge', 'bookingMerge');

            Route::post('add-new-route', 'addNewRoute');
        });
    });

    Route::controller(TimeTableController::class)->group(function() {
        Route::get('time-table/get', 'getTimetable');
    });

    Route::controller(RouteMapController::class)->group(function() {
        Route::get('route-map/get', 'getRouteMap');
    });

    Route::controller(PaymentController::class)->group(function () {
        Route::post('payment/create', 'paymentRequest');
        Route::post('payment/create-ctsv', 'paymentCounterService');
    });

    Route::controller(PromotionController::class)->group(function() {
        Route::get('promotion/get', 'getPromotion');
        Route::get('promotion/view/{promocode}', 'getPromotionByCode');
        Route::post('promotion/check', 'promotionCode');

        Route::get('promotion/check-v2/{promo_code}/{departdate}/{trip_type}', 'promotionCodeV2');
    });

    Route::controller(InfomationController::class)->group(function() {
        Route::get('infomation/get/{type}', 'getInfomation');
    });

    Route::controller(ReviewController::class)->group(function() {
        Route::get('review/get', 'index');
    });

    Route::controller(CustomerController::class)->group(function() {
        Route::post('customer/update', 'updateCustomer');
    });

    Route::controller(NewsController::class)->group(function() {
        Route::get('news', 'getNews');
        // Route::get('news/get/{id}', 'getNewsById');
        Route::get('news/view', 'getNewByView');
        Route::get('news/get/{slug}', 'getNewsBySlug');
    });

    Route::controller(PremiumFlexController::class)->group(function() {
        Route::get('premium-flex', 'index');
    });
});


// Route Api for 7seven
Route::middleware(['seven'])->prefix('v1')->group(function() {

    // Route
    Route::controller(SevenRoute::class)->group(function() {
        Route::get('route/get/{from}/{to}', 'getRouteByStation');
    });

    // Station
    Route::controller(SevenStation::class)->group(function() {
        Route::get('stations', 'getStationFromRoute');
        Route::get('stations/depart', 'stationDepart');
        Route::get('stations/arrive/{from_id}', 'stationArrive');
    });

    // Booking
    Route::prefix('booking')->group(function() {
        Route::controller(SevenBooking::class)->group(function() {
            Route::post('create', 'store');
            Route::post('complete', 'complete');
            Route::post('cancel', 'destroy');
            Route::post('update', 'update');
            Route::post('status', 'checkBookingStatus');

            Route::get('get/{id}', 'getBookingById');
        });
    });
});


// Route Api for agent
Route::middleware(['agent'])->prefix('agent')->group(function() {

    // Route
    Route::controller(AgentRoute::class)->group(function() {
        Route::get('routes', 'getRoutes');
        Route::get('route/get/{from}/{to}', 'getRouteByStation');
    });

    // Station
    Route::controller(AgentStation::class)->group(function() {
        Route::get('stations', 'getStationFromRoute');
        Route::get('stations/depart', 'stationDepart');
        Route::get('stations/arrive/{from_id}', 'stationArrive');
    });

    // Booking
    Route::controller(AgentBooking::class)->group(function() {
        Route::prefix('booking')->group(function() {
            Route::post('create', 'store');
            Route::post('complete', 'complete');
            Route::post('cancel', 'destroy');
            Route::post('update', 'update');

            Route::get('get/{id}', 'getBookingById');
        });
    });
});

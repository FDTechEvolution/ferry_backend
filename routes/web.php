<?php

use App\Http\Controllers\AjaxApiRouteController;
use App\Http\Controllers\ApiMerchants;
use App\Http\Controllers\ApiMerchantsController;
use App\Http\Controllers\ApiRoutes;
use App\Http\Controllers\ApiRoutesController;
use App\Http\Controllers\BookingRouteController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DevTestController;
use App\Http\Controllers\InformationsController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\RouteCalendarController;
use App\Http\Controllers\RouteSchedulesController;
use App\Http\Controllers\SectionsController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\StationsController;
use App\Http\Controllers\MealsController;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\StationInfomationsController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\TimeTableController;
use App\Http\Controllers\RouteMapController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\FareController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\BillboardController;
use App\Http\Controllers\PremiumFlexController;
use App\Http\Controllers\ReportsController;

use App\Http\Controllers\FileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::get('/', function () {
        return view('login');
    })->middleware('guest')->name('login');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('/dashboard', 'dashboard')->name('dashboard');

    Route::post('/login', 'authenticate')->name('authenticate');
});

Route::controller(DevTestController::class)->group(function () {
    Route::get('/test', 'index')->name('test.index');
});

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('/forgot-password', function () {
        return view('pages.auth.forgot_password');
    })->middleware('guest')->name('forgot-password');
    Route::get('/reset-password/{token}', function (string $token) {
        return view('pages.auth.reset-password', ['token' => $token]);
    })->middleware('guest')->name('reset-password');

    Route::post('/forgot-password', 'submitForgetPasswordForm')->name('password-email');
    Route::post('/reset-password', 'submitResetPasswordForm')->name('update-password');
});

Route::middleware('auth')->group(function () {
    Route::resources([
        'section' => SectionsController::class,
        'routeSchedules' => RouteSchedulesController::class,
        'customer'=>CustomerController::class,
        'bookingRoute'=>BookingRouteController::class,
        'routeCalendar'=>RouteCalendarController::class
    ]);

    Route::controller(RouteSchedulesController::class)->group(function() {
        Route::get('/booking-affected', 'bookingEffect')->name('routeSchedules.bookingAffected');
        Route::post('/booking-affected/void', 'sendVoidBooking')->name('routeSchedules.sendVoidBooking');
    });

    Route::controller(ApiMerchantsController::class)->group(function() {
        Route::get('/api', 'index')->name('api.index');
        Route::get('/api/create', 'create')->name('api.create');
        Route::get('/api/edit/{id}', 'edit')->name('api.edit');
        Route::get('/api/edit-merchant/{id}', 'editMerchant')->name('api.editMerchant');
        Route::get('/api/addroute/{id}', 'addRoute')->name('api.addRoute');

        Route::post('/api/update-merchant', 'updateMerchant')->name('api.updateMerchant');
        Route::post('/api/storeroute/{id}', 'storeRoute')->name('api.storeroute');
        Route::post('/api/store', 'store')->name('api.store');
        Route::post('/api/update/{id}', 'update')->name('api.update');

        Route::get('/api/delete/{id}', 'destroy')->name('api.destroy');
    });

    Route::controller(AjaxApiRouteController::class)->group(function() {
        Route::get('/apiagent/edit/{id}', 'edit')->name('apiagent.edit');

        Route::post('/apiagent/update/{id}', 'update')->name('apiagent.update');
    });

    Route::controller(ApiRoutesController::class)->group(function () {
        Route::get('/apiroute/get/{merchant_id}', 'index')->name('api-route-index');
        Route::get('/apiroute/calendar/{id}', 'calendar')->name('apiroute.calendar');
        Route::get('/apiroute/edit-seat/{id}', 'editSeat')->name('apiroute.edit-seat');
        Route::post('/apiroute/multiple-delete', 'multipleDelete')->name('apiroute.multiple_delete');

        Route::get('/apiroute/updateroute/{merchant_id}', 'updateroute')->name('api-route-updateroute');
        Route::get('/apiroute/update-commission', 'updateCommission')->name('api-route-updatecommission');

        // AJAX
        Route::post('/ajax/api-route/update', 'update');
        Route::get('/ajax/api-route/status/{id}', 'updateStatus');
    });

    Route::controller(UsersController::class)->group(function () {
        Route::get('/account', 'index')->name('users-index');
        Route::get('/delete-user/{id}', 'destroy')->name('user-delete');
        Route::get('/reset-password-user/{id}', 'resetUserPassword')->name('user-reset-password');
        Route::post('/create-user', 'store')->name('user-create');
        Route::post('/update-user', 'update')->name('user-update');
    });

    Route::controller(StationsController::class)->group(function () {
        Route::get('/stations', 'index')->name('stations-index');
        Route::get('/delete-station/{id}', 'destroy')->name('station-delete');
        Route::get('/create-station', 'create')->name('create-station');
        Route::get('/edit-station/{id}', 'edit')->name('edit-station');

        Route::post('/station-create', 'store')->name('station-create');
        Route::post('/update-station', 'update')->name('station-update');
        Route::get('/ajax/station/update-status/{id}', 'updateStatus')->name('ajax-station-update-status');
    });

    Route::controller(SectionsController::class)->group(function () {
        Route::get('/section/destroy/{id}', 'destroy')->name('section.destroy');
        Route::post('/section/update', 'update')->name('section.update');

        Route::get('/ajax/section/update-status/{id}', 'updateStatus')->name('ajax-update-status');
    });

    Route::controller(StationInfomationsController::class)->group(function () {
        Route::get('/stations-info', 'index')->name('stations-info-index');
        Route::get('/create-station-info', 'create')->name('create-station-info');
        Route::get('/edit-station-info/{id}', 'edit')->name('edit-station-info');
        Route::get('/delete-station-info/{id}', 'destroy')->name('station-info-delete');

        //$headers = array("Content-Type: text/html; charset=iso-8859-1");

        Route::post('/station-info-create', 'store')->name('station-info-create');
        Route::post('/update-station-info', 'update')->name('station-info-update');

        // AJAX
        Route::post('/ajax/create-station-info', 'createStationInfo')->name('ajax-create-station-info');
        Route::get('/ajax/get-station-info', 'getStationInfo')->name('ajax-get-station-info');
    });

    Route::controller(MealsController::class)->group(function () {
        Route::get('/meals', 'index')->name('meals-index');
        Route::get('/meals/edit/{id}', 'edit')->name('meal-edit');
        Route::get('/delete-meal/{id}', 'destroy')->name('meal-delete');

        Route::post('/create-meal', 'store')->name('meal-create');
        Route::post('/update-meal', 'update')->name('meal-update');

        // AJAX
        Route::post('/upload-icon-meal', 'uploadIcon')->name('meal-upload-icon');
        Route::post('/delete-icon-meal', 'destroyIcon')->name('meal-delete-icon');
    });

    Route::controller(ActivitiesController::class)->group(function () {
        Route::get('/activity', 'index')->name('activity-index');
        Route::get('/activity/create', 'create')->name('activity-create');
        Route::get('/activity/edit/{id}', 'edit')->name('activity-edit');
        Route::get('/activity/delete/{id}', 'destroy')->name('activity-delete');

        Route::post('/activity/store', 'store')->name('activity-store');
        Route::post('/activity/update', 'update')->name('activity-update');
    });

    Route::controller(RouteController::class)->group(function () {
        Route::get('/route-control', 'index')->name('route-index');
        Route::get('/route/create', 'create')->name('route-create');
        Route::get('/route/edit/{id}', 'edit')->name('route-edit');
        Route::get('/route/delete/{id}', 'destroy')->name('route-delete');

        Route::post('/route/store', 'store')->name('route-store');
        Route::post('/route/update', 'update')->name('route-update');
        Route::post('/route/seleted/delete', 'destroySelected')->name('route-selected-delete');
        Route::match(['get', 'post'], '/route/seleted/pdf', 'pdfSelected')->name('route-selected-pdf');

        // AJAX
        Route::get('/ajax/get-route-info/{route_id}/{station_id}/{type}', 'getRouteInfo')->name('get-route-info');
        Route::get('/ajax/route/update-status/{id}', 'updateStatus');
    });

    Route::controller(ReviewsController::class)->group(function () {
        Route::get('/review', 'index')->name('review-index');

        Route::get('/review/create', 'create')->name('review-create');
        Route::post('/review/store', 'store')->name('review-store');

        Route::get('/review/edit/{review}', 'edit')->name('review-edit');
        Route::post('/review/update/{review}', 'update')->name('review-update');

        Route::get('/review/delete/{id}', 'destroy')->name('review-delete');
    });

    Route::controller(InformationsController::class)->group(function () {
        Route::get('/information', 'index')->name('information-index');

        Route::get('/information/create', 'create')->name('information-create');
        Route::post('/information/store', 'store')->name('information-store');

        Route::get('/information/edit/{information}', 'edit')->name('information-edit');
        Route::post('/information/update/{information}', 'update')->name('information-update');

        Route::get('/information/delete/{id}', 'destroy')->name('information-delete');
    });

    Route::controller(PartnerController::class)->group(function () {
        Route::get('/partner', 'index')->name('partner-index');

        Route::get('/partner/create', 'create')->name('partner-create');
        Route::post('/partner/store', 'store')->name('partner-store');

        Route::get('/partner/edit/{partner}', 'edit')->name('partner-edit');
        Route::post('/partner/update/{partner}', 'update')->name('partner-update');

        Route::get('/partner/delete/{id}', 'destroy')->name('partner-delete');
    });

    Route::controller(TimeTableController::class)->group(function () {
        Route::get('/time-table', 'index')->name('time-table-index');
        Route::get('/time-table/edit/{id}', 'edit')->name('time-table-edit');
        Route::get('/time-table/delete/{id}', 'destroy')->name('time-table-delete');

        Route::post('/time-table/create', 'store')->name('time-table-create');
        Route::post('/time-table/update', 'update')->name('time-table-update');

        // AJAX
        Route::get('/ajax/time-table/show-in-homepage/{id}', 'updateShowInHomepage')->name('show-in-homepage');
    });

    Route::controller(RouteMapController::class)->group(function () {
        Route::get('/route-map', 'index')->name('route-map-index');
        Route::get('/route-map/delete/{id}', 'destroy')->name('route-map-delete');

        Route::post('/route-map/create', 'store')->name('route-map-create');
        Route::post('/route-map/update', 'update')->name('route-map-update');

        // AJAX
        Route::get('/ajax/route-map/show-in-homepage/{id}', 'updateShowInHomepage')->name('route-map-show');
    });

    Route::controller(SlideController::class)->group(function () {
        Route::get('/media/blog', 'index')->name('blog-index');
        Route::get('/media/blog/create', 'create')->name('blog-create');
        Route::get('/media/blog/edit/{id}', 'edit')->name('blog-edit');
        Route::get('/media/blog/delete/{id}', 'destroy')->name('blog-delete');

        Route::post('/media/blog/create', 'store')->name('blog-store');
        Route::post('/media/blog/update', 'update')->name('blog-update');

        // AJAX
        Route::get('/ajax/slide/show-in-homepage/{id}', 'updateShowInHomepage')->name('slide-show');
    });

    Route::controller(BillboardController::class)->group(function() {
        Route::get('/media/billboard', 'index')->name('billboard-index');
        Route::get('/media/billboard/create', 'create')->name('billboard-create');
        Route::get('/media/billboard/edit/{id}', 'edit')->name('billboard-edit');
        Route::get('/media/billboard/delete/{id}', 'destroy')->name('billboard-delete');

        Route::post('/media/billboard/store', 'store')->name('billboard-store');
        Route::post('/media/billboard/update', 'update')->name('billboard-update');

        // AJAX
        Route::get('/ajax/media/billboard/status/{id}', 'updateStatus')->name('billboard-update-status');
    });

    Route::controller(PromotionController::class)->group(function () {
        Route::get('/promotion', 'index')->name('promotion-index');
        Route::get('/promotion/create', 'create')->name('promotion-create');

        Route::get('/promotion/addstation/{id}', 'addStation')->name('promotion.addStation');
        Route::get('/promotion/addRoute/{id}', 'addRoute')->name('promotion.addRoute');
        Route::post('/promotion/storestation', 'storeStation')->name('promotion.storestation');
        Route::post('/promotion/storeroute', 'storeRoute')->name('promotion.storeroute');

        Route::post('/promotion/store', 'store')->name('promotion-store');
        Route::post('/promotion/update', 'update')->name('promotion-update');
        Route::get('/promotion/edit/{id}', 'edit')->name('promotion-edit');
        Route::get('/promotion/delete/{id}', 'destroy')->name('promotion-delete');
    });

    Route::controller(FareController::class)->group(function () {
        Route::get('/fare-manage', 'index')->name('fare-index');

        Route::post('/fare-manage/update', 'update')->name('fare-update');
    });


    Route::controller(BookingsController::class)->group(function () {
        Route::get('/booking', 'index')->name('booking-index');

        Route::get('/booking/route', 'route')->name('booking-route');
        Route::get('/booking/view/{id}', 'view')->name('booking-view');
        Route::get('/booking/create', 'create')->name('booking-create');
        Route::post('/booking/store', 'store')->name('booking-store');

        Route::get('/booking/change-status/{id}', 'changeStatus')->name('booking.changeStatus');
        Route::post('/booking/update-status/{booking}', 'updateStatus')->name('booking.updateStatus');

        Route::post('/booking/update/customer', 'updateCustomer')->name('booking-update-customer');
        Route::post('/booking/send-confirm-email', 'sendConfirmEmail')->name('booking.sendConfirmEmail');
    });


    Route::controller(NewsController::class)->group(function() {
        Route::get('/news', 'index')->name('news-index');
        Route::get('/news/create', 'create')->name('news-create');
        Route::get('/news/edit/{news}', 'edit')->name('news-edit');

        Route::post('/news/store', 'store')->name('news-store');
        Route::post('/news/update/{news}', 'update')->name('news-update');

        Route::get('/news/delete/{id}', 'destroy')->name('news-delete');

        // AJAX
        Route::get('/ajax/news/status/{id}', 'updateStatus')->name('news-update-status');
    });

    Route::controller(PremiumFlexController::class)->group(function() {
        Route::get('/premium-flex', 'index')->name('pmf-index');
        Route::post('/premium-flex/update', 'update')->name('pmf-update');
    });

    Route::controller(ReportsController::class)->group(function() {
        Route::get('/report', 'index')->name('report-index');

        Route::post('/report', 'getRoute')->name('report-get');
        Route::post('/report-pdf', 'reportPdfGenerate')->name('report-pdf');

        // AJAX
        Route::get('/ajax/report/depart-arrive-time/{from_id}/{to_id}', 'routeDepartArriveTime');
    });

});

Route::controller(PrintController::class)->group(function () {
    Route::get('/print/ticket/{bookingno}', 'ticket')->name('print-ticket');

    Route::post('/print/multiple-ticket', 'multipleTicket')->name('print.multipleticket');

});

Route::get('/email/ticket', function() {
    return view('email.ticket');
});

// Test Download pdf
Route::get('/download-pdf', function () {
    return 'hello...';
});

// Route::get('/{pathMatch}', function() {
//     return view('app');
// })->where('pathMatch', '.*');

<?php

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

Route::controller(AuthController::class)->group(function() {
    Route::get('/', function() {
        return view('login');
    })->middleware('guest')->name('login');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('/dashboard', 'dashboard')->name('dashboard');

    Route::post('/login', 'authenticate')->name('authenticate');
});

Route::controller(ForgotPasswordController::class)->group(function() {
    Route::get('/forgot-password', function () {
        return view('pages.auth.forgot_password');
    })->middleware('guest')->name('forgot-password');
    Route::get('/reset-password/{token}', function (string $token) {
        return view('pages.auth.reset-password', ['token' => $token]);
    })->middleware('guest')->name('reset-password');

    Route::post('/forgot-password', 'submitForgetPasswordForm')->name('password-email');
    Route::post('/reset-password', 'submitResetPasswordForm')->name('update-password');
});

Route::middleware('auth')->group(function() {
    Route::controller(UsersController::class)->group(function() {
        Route::get('/account', 'index')->name('users-index');
        Route::get('/delete-user/{id}', 'destroy')->name('user-delete');
        Route::get('/reset-password-user/{id}', 'resetUserPassword')->name('user-reset-password');
        Route::post('/create-user', 'store')->name('user-create');
        Route::post('/update-user', 'update')->name('user-update');
    });

    Route::controller(StationsController::class)->group(function() {
        Route::get('/stations', 'index')->name('stations-index');
        Route::get('/delete-station/{id}', 'destroy')->name('station-delete');
        Route::get('/create-station', 'create')->name('create-station');
        Route::get('/edit-station/{id}', 'edit')->name('edit-station');

        Route::post('/station-create', 'store')->name('station-create');
        Route::post('/update-station', 'update')->name('station-update');

        // section
        Route::get('/section-create', 'sectionCreate')->name('create-section');
        Route::get('/delete-section/{id}', 'destroySection')->name('section-delete');
        Route::get('/section-manage', 'sectionManage')->name('manage-section');

        Route::post('/create-section', 'storeSection')->name('section-create');
        Route::post('/update-section', 'updateSection')->name('section-update');
    });

    Route::controller(StationInfomationsController::class)->group(function() {
        Route::get('/stations-info', 'index')->name('stations-info-index');
        Route::get('/create-station-info', 'create')->name('create-station-info');
        Route::get('/edit-station-info/{id}', 'edit')->name('edit-station-info');
        Route::get('/delete-station-info/{id}', 'destroy')->name('station-info-delete');

        Route::post('/station-info-create', 'store')->name('station-info-create');
        Route::post('/update-station-info', 'update')->name('station-info-update');

        // AJAX
        Route::post('/ajax/create-station-info', 'createStationInfo')->name('ajax-create-station-info');
        Route::get('/ajax/get-station-info', 'getStationInfo')->name('ajax-get-station-info');
    });

    Route::controller(MealsController::class)->group(function() {
        Route::get('/meals', 'index')->name('meals-index');
        Route::get('/delete-meal/{id}', 'destroy')->name('meal-delete');

        Route::post('/create-meal', 'store')->name('meal-create');
        Route::post('/update-meal', 'update')->name('meal-update');

        // AJAX
        Route::post('/upload-icon-meal', 'uploadIcon')->name('meal-upload-icon');
        Route::post('/delete-icon-meal', 'destroyIcon')->name('meal-delete-icon');
    });

    Route::controller(ActivitiesController::class)->group(function() {
        Route::get('/activity', 'index')->name('activity-index');
        Route::get('/activity/create', 'create')->name('activity-create');
        Route::get('/activity/edit/{id}', 'edit')->name('activity-edit');
        Route::get('/activity/delete/{id}', 'destroy')->name('activity-delete');

        Route::post('/activity/store', 'store')->name('activity-store');
        Route::post('/activity/update', 'update')->name('activity-update');
    });

    Route::controller(RouteController::class)->group(function() {
        Route::get('/route-control', 'index')->name('route-index');
        Route::get('/route/create', 'create')->name('route-create');
        Route::get('/route/edit/{id}', 'edit')->name('route-edit');
        Route::get('/route/delete/{id}', 'destroy')->name('route-delete');

        Route::post('/route/store', 'store')->name('route-store');
        Route::post('/route/update', 'update')->name('route-update');
        Route::post('/route/seleted/delete', 'destroySelected')->name('route-selected-delete');

        // AJAX
        Route::get('/ajax/get-route-info/{route_id}/{station_id}/{type}', 'getRouteInfo')->name('get-route-info');
    });

    Route::controller(ReviewsController::class)->group(function(){
        Route::get('/review','index')->name('review-index');

        Route::get('/review/create','create')->name('review-create');
        Route::post('/review/store','store')->name('review-store');

        Route::get('/review/edit/{review}','edit')->name('review-edit');
        Route::post('/review/update/{review}','update')->name('review-update');

        Route::get('/review/delete/{id}','destroy')->name('review-delete');
    });
});



// Route::get('/{pathMatch}', function() {
//     return view('app');
// })->where('pathMatch', '.*');
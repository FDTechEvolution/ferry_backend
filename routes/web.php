<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\StationsController;
use App\Http\Controllers\MealsController;

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
    });

    Route::controller(MealsController::class)->group(function() {
        Route::get('/meals', 'index')->name('meals-index');
        Route::get('/delete-meal/{id}', 'destroy')->name('meal-delete');

        Route::post('/create-meal', 'store')->name('meal-create');
        Route::post('/update-meal', 'update')->name('meal-update');
    });
});



// Route::get('/{pathMatch}', function() {
//     return view('app');
// })->where('pathMatch', '.*');
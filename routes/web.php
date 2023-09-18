<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UsersController;

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
    Route::get('/', 'login')->name('login');
    Route::get('/forgot-password', 'forgotPassword')->name('forgot-password');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('/dashboard', 'dashboard')->name('dashboard');

    Route::post('/login', 'authenticate')->name('authenticate');
    Route::post('/reset-password', 'resetPassword')->name('reset-password');
});

Route::middleware('auth')->controller(UsersController::class)->group(function() {
    Route::get('/users', 'index')->name('users-index');

    Route::post('/create-user', 'store')->name('create-user');
    Route::post('/update-user', 'update')->name('update-user');
});



// Route::get('/{pathMatch}', function() {
//     return view('app');
// })->where('pathMatch', '.*');
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;

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
Route::get('/', function () { return view('index'); })->name('login');
Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
Route::get('/users', function () { return view('users'); })->name('users');

Route::controller(AuthController::class)->group(function() {
    Route::post('/login', 'authenticate')->name('authenticate');
});





// Route::get('/{pathMatch}', function() {
//     return view('app');
// })->where('pathMatch', '.*');
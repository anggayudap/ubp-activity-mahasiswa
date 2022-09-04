<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\RoleUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('layouts.master');
})->middleware('auth');

Route::prefix('master')->name('master.')->middleware('auth')->group(function () {
    /* routing for master data*/
    Route::resource('/prodi', ProdiController::class);
    Route::resource('/periode', PeriodeController::class);
    Route::resource('/user', UserController::class);
    Route::resource('/role', RoleUserController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', function () {return view('login');})->name('login');
    Route::post('/login', 'authenticate')->name('login_submit');
    Route::get('/logout', 'logout')->name('logout');
});

Route::get('/clear', function () {
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    \Artisan::call('config:clear');

    dd("Cache, View & Config is cleared");
});
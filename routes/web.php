<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\ProfileUserController;
use App\Http\Controllers\KlasifikasiKegiatanController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    /* routing for main menu */
    Route::get('/kegiatan/list', [KegiatanController::class, 'list'])->name('kegiatan.list')->middleware('role:dosen|kemahasiswaan');
    Route::get('/kegiatan/history', [KegiatanController::class, 'history'])->name('kegiatan.history')->middleware('role:mahasiswa');
    Route::get('/kegiatan/modal_detail/{id}', [KegiatanController::class, 'detail'])->name('kegiatan.detail');
    Route::post('/kegiatan/decision', [KegiatanController::class, 'decision'])->name('kegiatan.decision');
    
    Route::get('/proposal/list', [ProposalController::class, 'list'])->name('proposal.list')->middleware('role:dosen|kemahasiswaan');
    Route::get('/proposal/history', [ProposalController::class, 'history'])->name('proposal.history')->middleware('role:mahasiswa');
    Route::get('/proposal/modal_detail/{id}', [ProposalController::class, 'detail'])->name('proposal.detail');
    Route::get('/proposal/approval_fakultas', [ProposalController::class, 'approval_fakultas'])->name('proposal.approval_fakultas')->middleware('role:dosen|kemahasiswaan');
    Route::get('/proposal/approval_kemahasiswaan', [ProposalController::class, 'approval_kemahasiswaan'])->name('proposal.approval_kemahasiswaan')->middleware('role:dosen|kemahasiswaan');

    Route::resource('/kegiatan', KegiatanController::class);
    Route::resource('/proposal', ProposalController::class);
});

Route::prefix('master')->name('master.')->middleware('auth')->group(function () {
    /* routing for master data*/
    Route::resource('/prodi', ProdiController::class);
    Route::resource('/periode', PeriodeController::class);
    Route::resource('/user', UserController::class);
    Route::resource('/role', RoleUserController::class);
    Route::resource('/klasifikasi', KlasifikasiKegiatanController::class);
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', function () {return view('login');})->name('login');
    Route::post('/login', 'authenticate')->name('login_submit');
    Route::get('/logout', 'logout')->name('logout');
});

Route::get('profile/', [ProfileUserController::class, 'index'])->name('profile_user');

Route::get('/clear', function () {
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    \Artisan::call('config:clear');

    dd("Cache, View & Config is cleared");
});
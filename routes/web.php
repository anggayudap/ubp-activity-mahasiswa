<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\Master\ProdiController;
use App\Http\Controllers\Master\PeriodeController;
use App\Http\Controllers\ReportKegiatanController;
use App\Http\Controllers\ReportProposalController;
use App\Http\Controllers\Master\RoleUserController;
use App\Http\Controllers\Master\MahasiswaController;
use App\Http\Controllers\Master\KlasifikasiKegiatanController;

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
    Route::get('/kegiatan/history', [KegiatanController::class, 'history'])->name('kegiatan.history')->middleware('role:mahasiswa|kemahasiswaan');
    Route::get('/kegiatan/modal_detail/{id}', [KegiatanController::class, 'detail'])->name('kegiatan.detail');
    Route::post('/kegiatan/decision', [KegiatanController::class, 'decision'])->name('kegiatan.decision');
    Route::post('/kegiatan/update_dpm', [KegiatanController::class, 'update_dpm'])->name('kegiatan.update_dpm');

    Route::get('/proposal/list', [ProposalController::class, 'list'])->name('proposal.list')->middleware('role:dosen|kemahasiswaan');
    Route::get('/proposal/history', [ProposalController::class, 'history'])->name('proposal.history')->middleware('role:mahasiswa');
    Route::get('/proposal/modal_detail/{id}', [ProposalController::class, 'detail'])->name('proposal.detail');
    Route::get('/proposal/approval/{id}', [ProposalController::class, 'approval'])->name('proposal.approval');
    Route::get('/proposal/approval_fakultas', [ProposalController::class, 'approval_fakultas'])->name('proposal.approval_fakultas')->middleware('role:dosen|kemahasiswaan');
    Route::get('/proposal/approval_kemahasiswaan', [ProposalController::class, 'approval_kemahasiswaan'])->name('proposal.approval_kemahasiswaan')->middleware('role:dosen|kemahasiswaan');
    // Route::post('/proposal/approve', [ProposalController::class, 'approve'])->name('proposal.approve');
    // Route::post('/proposal/reject', [ProposalController::class, 'reject'])->name('proposal.reject');
    Route::post('/proposal/submit_approval', [ProposalController::class, 'submit_approval'])->name('proposal.submit_approval');

    Route::resource('/kegiatan', KegiatanController::class);
    Route::resource('/proposal', ProposalController::class);
});

Route::prefix('report')->name('report.')->middleware('auth', 'role:admin|kemahasiswaan')->group(function () {
    Route::get('/proposal', [ReportProposalController::class, 'index'])->name('proposal');
    Route::post('/proposal/submit', [ReportProposalController::class, 'submit'])->name('proposal.submit');

    Route::get('/kegiatan', [ReportKegiatanController::class, 'index'])->name('kegiatan');
    Route::post('/kegiatan/submit', [ReportKegiatanController::class, 'submit'])->name('kegiatan.submit');
});

Route::prefix('master')->name('master.')->middleware('auth')->group(function () {
    /* routing for master data*/
    Route::resource('/prodi', ProdiController::class);
    Route::resource('/periode', PeriodeController::class);
    Route::resource('/user', UserController::class);
    Route::resource('/role', RoleUserController::class);
    Route::get('/mahasiswa/update', [MahasiswaController::class, 'update_mahasiswa'])->name('mahasiswa.update_mahasiswa');
    Route::resource('/mahasiswa', MahasiswaController::class);
    Route::resource('/klasifikasi', KlasifikasiKegiatanController::class);
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', function () {return view('login');})->name('login');
    Route::post('/login', 'authenticate')->name('login_submit');
    Route::get('/logout', 'logout')->name('logout');
});

Route::get('/profile', function () {
    return view('profile');
})->middleware('auth')->name('profile_user');

Route::get('/clear', function () {
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    \Artisan::call('config:clear');

    dd("Cache, View & Config is cleared");
});
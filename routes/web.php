<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KompetisiApprovalController;
use App\Http\Controllers\KompetisiController;
use App\Http\Controllers\KompetisiRegisterController;
use App\Http\Controllers\KompetisiResultController;
use App\Http\Controllers\KompetisiReviewController;
use App\Http\Controllers\Master\DosenController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\Master\ProdiController;
use App\Http\Controllers\Master\SkemaController;
use App\Http\Controllers\Master\ReviewController;
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

Route::get('/', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// ROUTE KEGIATAN
Route::middleware('auth')->group(function () {
    /* routing for main menu */
    Route::get('/kegiatan/list', [KegiatanController::class, 'list'])
        ->name('kegiatan.list')
        ->middleware('role:dpm|kemahasiswaan');
    Route::get('/kegiatan/history', [KegiatanController::class, 'history'])
        ->name('kegiatan.history')
        ->middleware('role:mahasiswa|kemahasiswaan');
    Route::get('/kegiatan/modal_detail/{id}', [KegiatanController::class, 'detail'])->name('kegiatan.detail');
    Route::post('/kegiatan/decision', [KegiatanController::class, 'decision'])->name('kegiatan.decision');
    Route::post('/kegiatan/update_dpm', [KegiatanController::class, 'update_dpm'])->name('kegiatan.update_dpm');

    Route::resource('/kegiatan', KegiatanController::class);
});

// ROUTE PROPOSAL
Route::middleware('auth')->group(function () {
    Route::get('/proposal/list', [ProposalController::class, 'list'])
        ->name('proposal.list')
        ->middleware('role:dpm|kemahasiswaan');
    Route::get('/proposal/history', [ProposalController::class, 'history'])
        ->name('proposal.history')
        ->middleware('role:mahasiswa');
    Route::get('/proposal/modal_detail/{id}', [ProposalController::class, 'detail'])->name('proposal.detail');
    Route::get('/proposal/upload_laporan/{id}', [ProposalController::class, 'upload_laporan'])->name('proposal.upload_laporan');
    Route::post('/proposal/submit_laporan', [ProposalController::class, 'submit_laporan'])->name('proposal.submit_laporan');
    Route::get('/proposal/approval/{id}', [ProposalController::class, 'approval'])->name('proposal.approval');
    Route::get('/proposal/approval_fakultas', [ProposalController::class, 'approval_fakultas'])
        ->name('proposal.approval_fakultas')
        ->middleware('role:dpm|kemahasiswaan');
    Route::get('/proposal/approval_kemahasiswaan', [ProposalController::class, 'approval_kemahasiswaan'])
        ->name('proposal.approval_kemahasiswaan')
        ->middleware('role:dpm|kemahasiswaan');
    Route::get('/proposal/approval_laporan', [ProposalController::class, 'approval_laporan'])
        ->name('proposal.approval_laporan')
        ->middleware('role:dpm|kemahasiswaan');
    // Route::post('/proposal/approve', [ProposalController::class, 'approve'])->name('proposal.approve');
    // Route::post('/proposal/reject', [ProposalController::class, 'reject'])->name('proposal.reject');
    Route::post('/proposal/submit_approval', [ProposalController::class, 'submit_approval'])->name('proposal.submit_approval');

    Route::resource('/proposal', ProposalController::class);
});

// ROUTE KOMPETISI
Route::middleware('auth')->prefix('kompetisi')->name('kompetisi.')->group(function () {
    Route::get('/list', [KompetisiController::class, 'list'])
        ->name('list')
        ->middleware('role:kemahasiswaan');


    Route::get('/register', [KompetisiRegisterController::class, 'register'])
        ->name('register')
        ->middleware('role:mahasiswa|kemahasiswaan');

    Route::get('/register/preview/{id}', [KompetisiRegisterController::class, 'preview'])
        ->name('register.preview')
        ->middleware('role:mahasiswa|kemahasiswaan');

    Route::get('/register_form/{id}', [KompetisiRegisterController::class, 'register_form'])
        ->name('register_form')
        ->middleware('role:mahasiswa|kemahasiswaan');
    Route::post('/register_submit', [KompetisiRegisterController::class, 'register_submit'])
        ->name('register_submit');
    Route::get('/history', [KompetisiRegisterController::class, 'history'])
        ->name('history')
        ->middleware('role:mahasiswa|dosen|dpm|kemahasiswaan');
    Route::get('/participant/modal_detail/{id}', [KompetisiRegisterController::class, 'detail'])->name('participant.detail');
    Route::get('/participant/edit/{id}', [KompetisiRegisterController::class, 'edit'])->name('participant.edit');
    Route::delete('/participant/destroy/{id}', [KompetisiRegisterController::class, 'destroy'])->name('participant.destroy');


    Route::get('/approval/list', [KompetisiApprovalController::class, 'approval_list'])
        ->name('approval.list')
        ->middleware('role:kemahasiswaan');
    Route::get('/approval/{id}', [KompetisiApprovalController::class, 'approval'])->name('approval');
    Route::post('/submit_approval', [KompetisiApprovalController::class, 'submit_approval'])->name('submit_approval');

    Route::get('/review/list', [KompetisiReviewController::class, 'review_list'])
        ->name('review.list')
        ->middleware('role:dosen|dpm');
    Route::get('/review/{id}', [KompetisiReviewController::class, 'review'])->name('review');
    Route::post('/submit_review', [KompetisiReviewController::class, 'submit_review'])->name('submit_review');
    
    Route::get('/result/list', [KompetisiResultController::class, 'result_list'])
        ->name('result.list')
        ->middleware('role:dosen|dpm');
    Route::get('/result/{id}', [KompetisiResultController::class, 'result'])->name('result');
    Route::post('/submit_result', [KompetisiResultController::class, 'submit_result'])->name('submit_result');

    
    
    // Route::get('create/', [KompetisiController::class, 'create'])->name('create');
    Route::get('/{id}', [KompetisiController::class, 'show'])->name('show');
    Route::resource('/', KompetisiController::class);
});

Route::prefix('report')
    ->name('report.')
    ->middleware('auth', 'role:kemahasiswaan')
    ->group(function () {
        Route::get('/proposal', [ReportProposalController::class, 'index'])->name('proposal');
        Route::post('/proposal/submit', [ReportProposalController::class, 'submit'])->name('proposal.submit');

        Route::get('/kegiatan', [ReportKegiatanController::class, 'index'])->name('kegiatan');
        Route::post('/kegiatan/submit', [ReportKegiatanController::class, 'submit'])->name('kegiatan.submit');
    });

Route::prefix('master')
    ->name('master.')
    ->middleware('auth', 'role:kemahasiswaan')
    ->group(function () {
        /* routing for master data*/
        Route::resource('/prodi', ProdiController::class);
        Route::resource('/periode', PeriodeController::class);
        Route::resource('/user', UserController::class);
        Route::resource('/role', RoleUserController::class);
        Route::get('/dosen/update', [DosenController::class, 'update_dosen'])->name('dosen.update_dosen');
        Route::resource('/dosen', DosenController::class);
        Route::get('/mahasiswa/update', [MahasiswaController::class, 'update_mahasiswa'])->name('mahasiswa.update_mahasiswa');
        Route::resource('/mahasiswa', MahasiswaController::class);
        Route::resource('/klasifikasi', KlasifikasiKegiatanController::class);
        Route::resource('/review', ReviewController::class);
        Route::resource('/skema', SkemaController::class);
    });

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');
    Route::post('/login', 'authenticate')->name('login_submit');
    Route::get('/logout', 'logout')->name('logout');
});

Route::get('/profile', function () {
    return view('profile');
})
    ->middleware('auth')
    ->name('profile_user');

Route::get('/not_authorized', function () {
    return view('error.not_authorized');
})->name('error_notauthorized');

Route::get('/clear', function () {
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    \Artisan::call('config:clear');

    dd('Cache, View & Config is cleared');
});

//Route::get('/migrate', function () {
//    \Artisan::call('migrate:fresh --seed');

//    dd("success: database has migrated");
//});

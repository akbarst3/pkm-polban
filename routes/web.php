<?php

use App\Http\Controllers\Dospem\DospemController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Operator\AuthController as AuthOperator;
use App\Http\Controllers\Operator\DashboardController as DashboardOperator;
use App\Http\Controllers\Operator\UreviewerController;
use App\Http\Controllers\Operator\UsulanController;
use App\Http\Controllers\Operator\UsulanBaruController;

use App\Http\Controllers\Pengusul\IdentitasUsulanController;
use App\Http\Controllers\Pengusul\PengesahanController;
use App\Http\Controllers\Pengusul\ProposalController;
use App\Http\Controllers\Pengusul\AuthController as AuthPengusul;
use App\Http\Controllers\Pengusul\PengusulController as Pengusul;

Route::get('/', function () {
    return view('welcome');
});

// Route untuk Operator
Route::prefix('operator')->name('operator.')->group(function () {

    Route::middleware(['auth:operator', 'session.timeout'])->group(function () {
        Route::get('/dashboard', [DashboardOperator::class, 'index'])->name('dashboard');
        Route::post('/dashboard', [DashboardOperator::class, 'storeFile'])->name('file');

        Route::middleware(['cek.surat'])->group(function () {
            Route::get('/usulan-baru', [UsulanController::class, 'index'])->name('usulan.baru');
            Route::get('/usulan-baru/{nim}', [UsulanController::class, 'viewData'])->name('usulan.baru.nim');
            Route::delete('/usulan-baru/{id}', [UsulanController::class, 'deleteData'])->name('usulan.baru.delete');
            Route::get('/identitas-usulan', [UsulanBaruController::class, 'index'])->name('identitas.usulan');
            Route::post('/identitas-usulan/store', [UsulanBaruController::class, 'storeData'])->name('identitas-usulan.store');
            Route::post('/identitas-usulan/find', [UsulanBaruController::class, 'findDosen'])->name('identitas.usulan.find');
            Route::view('/usulan-didanai', 'operator.usulan-didanai')->name('usulan.didanai');
            Route::view('/usulan-reviewer', 'operator.usulanReviewer')->name('usulan.reviewer');
            Route::get('/identitas-reviewer', [UreviewerController::class, 'index'])->name('identitas.reviewer');
            Route::post('/logout', [AuthOperator::class, 'logout'])->name('logout');
        });
    });

    Route::middleware(['guest:operator'])->group(function () {
        Route::get('/login', [AuthOperator::class, 'create'])->name('login');
        Route::post('/login', [AuthOperator::class, 'login']);
    });
});

// Route untuk Pengusul 
Route::prefix('pengusul')->name('pengusul.')->group(function () {
    Route::middleware('guest:pengusul')->group(function () {
        Route::get('/login', [AuthPengusul::class, 'create'])->name('login');
        Route::post('/login', [AuthPengusul::class, 'login']);
    });

    Route::middleware(['auth:pengusul', 'session.timeout'])->group(function () {
        Route::get('/dashboard', [Pengusul::class, 'createDashboard'])->name('dashboard');
        Route::get('/identitas-usulan', [Pengusul::class, 'showData'])->name('identitas-usulan');
        Route::get('/edit-usulan', [Pengusul::class, 'showDetail'])->name('edit-usulan');
        Route::patch('/edit-usulan/edit-mhs/{id}', [Pengusul::class, 'editMhs'])->name('edit-usulan.edit-mhs');
        Route::get('/identitas-usulan/pengesahan', [Pengusul::class, 'createPengesahan'])->name('identitas-usulan.pengesahan');
        Route::post('/identitas-usulan/pengesahan', [Pengusul::class, 'storePengesahan']);
        Route::patch('/edit-usulan/edit-pkm/{id}', [Pengusul::class, 'editPkm'])->name('edit-usulan.edit-pkm');
        Route::get('/edit-usulan/tambah-anggota', [Pengusul::class, 'tambahAnggota'])->name('edit-usulan.tambah-anggota');
        Route::post('/edit-usulan/tambah-anggota', [Pengusul::class, 'storeAnggota']);
        Route::get('/edit-usulan/edit-anggota/{id}', [Pengusul::class, 'createEditAnggota'])->name('edit-usulan.edit-anggota');
        Route::put('/edit-usulan/edit-anggota/{id}', [Pengusul::class, 'editAnggota']);
        Route::delete('/edit-usulan/hapus-anggota/{id}', [Pengusul::class, 'destroyAnggota'])->name('edit-usulan.hapus-anggota');
        Route::get('/identitas-usulan/proposal', [Pengusul::class, 'createProposal'])->name("identitas-usulan.proposal");
        Route::patch('/identitas-usulan/proposal', [Pengusul::class, "storeProposal"]);
        Route::get('/pengusul/identitas-usulan/download-proposal', [Pengusul::class, 'downloadProposal'])->name('identitas-usulan.download-proposal');
        Route::post('/logout', [AuthPengusul::class, 'logout'])->name('logout');
    });
});

Route::get('/dospem/dashboard', [DospemController::class, 'index'])->name('dospem.dashboard');
Route::get('/dospem/proposal', [DospemController::class, 'showData'])->name('dospem.proposal');
Route::post('/dospem/validate', [DospemController::class, 'validate'])->name('dospem.validate');
Route::get('/validasi-usulan-disetujui/{pkm}', [DospemController::class, 'validasiUsulanDisetujui'])->name('validasi-usulan-disetujui');

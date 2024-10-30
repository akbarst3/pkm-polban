<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Operator\UsulanController;
use App\Http\Controllers\Operator\DashboardController;
use App\Http\Controllers\Operator\UreviewerController;
use App\Http\Controllers\Operator\UsulanBaruController;
use App\Http\Controllers\Pengusul\DashboardPengusulController;
use App\Http\Controllers\Pengusul\IdentitasUsulanController;
use App\Http\Controllers\Pengusul\PengesahanController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:operator', 'session.timeout'])->group(function () {
    Route::get('/operator/dashboard', [DashboardController::class, 'index'])->name('operator.dashboard');
    Route::post('/operator/dashboard', [DashboardController::class, 'storeFile'])->name('operator.file');

    Route::middleware(['cek.surat'])->group(function () {
        Route::get('/operator/usulan-baru', [UsulanController::class, 'index'])->name('operator.usulan.baru');
        Route::get('/operator/usulan-baru/{nim}', [UsulanController::class, 'viewData'])->name('operator.usulan.baru.nim');
        Route::delete('/operator/usulan-baru/{id}', [UsulanController::class, 'deleteData'])->name('delete.pengusul');
        Route::get('/operator/identitas-usulan', [UsulanBaruController::class, 'index'])->name('operator.identitas.usulan');
        Route::post('/operator/identitas-usulan/store', [UsulanBaruController::class, 'storeData'])->name('operator.usulan.baru.store');
        Route::post('/operator/identitas-usulan/find', [UsulanBaruController::class, 'findDosen'])->name('operator.identitas.usulan.find');
        Route::view('/operator/usulan-didanai', 'operator.usulan-didanai')->name('operator.usulan-didanai');
        Route::view('/operator/usulan-reviewer', 'operator.usulanReviewer');
        Route::get('/operator/identitas-reviewer', [UreviewerController::class, 'index']);
    });
});



Route::get('/pengusul/dashboard', [DashboardPengusulController::class,'index'])->name('pengusul.dashboard');
Route::get('pengusul/identitas-usulan', [IdentitasUsulanController::class, 'showIdentitasUsulan'])->name('pengusul.identitas.usulan');
Route::post('pengusul/identitas-usulan', [IdentitasUsulanController::class, 'submitIdentitasUsulan'])->name('pengusul.identitas.submit');

Route::post('/pengusul/pengesahan/post', [PengesahanController::class, 'store'])->name('pengusul.pengesahan.store');
Route::get('/pengusul/pengesahan', [PengesahanController::class, 'index'])->name('pengusul.pengesahan');

require __DIR__.'/auth.php';



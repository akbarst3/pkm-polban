<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Operator\DashboardController;
use App\Http\Controllers\Operator\UsulanController;
use App\Http\Controllers\Operator\UreviewerController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:operator', 'session.timeout'])->group(function () {
    Route::get('/operator/dashboard', [DashboardController::class, 'index'])->name('operator.dashboard');
    Route::get('/operator/identitasusulan', [UsulanController::class, 'index'])->name('operator.identitasusulan');
    Route::view('/operator/usulandidanai', 'operator.usulandidanai');
    Route::post('/operator/dashboard', [DashboardController::class, 'storeFile'])->name('operator.file');
    Route::post('/operator/identitasusulan/find', [UsulanController::class, 'findDosen'])->name('operator.dosen');
    Route::post('/operator/identitasusulan/store', [UsulanController::class, 'storeData'])->name('operator.identitasusulan');
    Route::view('/operator/usulanBaru', 'operator.usulanBaru');
    Route::view('/operator/usulanReviewer', 'operator.usulanReviewer');
    Route::get('/operator/identitasReviewer', [UreviewerController::class, 'index']);
});

require __DIR__.'/auth.php';
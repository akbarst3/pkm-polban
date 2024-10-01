<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Operator\DashboardController;
use App\Http\Controllers\Operator\UsulanController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth:operator')->group(function () {
    Route::get('/operator/dashboard', [DashboardController::class, 'index'])->name('operator.dashboard');
    Route::get('/operator/identitasusulan', [UsulanController::class, 'index'])->name('operator.identitasusulan');
    // Route::view('/operator/identitasusulan', 'operator.identitasusulan');
    Route::view('/operator/usulandidanai', 'operator.usulandidanai');
    Route::post('/operator/dashboard', [DashboardController::class, 'storeFile'])->name('operator.file');
    Route::post('/operator/identitasusulan/find', [UsulanController::class, 'findDosen'])->name('operator.dosen');
    Route::post('/operator/identitasusulan/store', [UsulanController::class, 'storeData'])->name('operator.identitasusulan');
    Route::view('/operator/usulanBaru', 'operator.usulanBaru');
    Route::view('/operator/usulanReviewer', 'operator.usulanReviewer');
    Route::view('/operator/identitasReviewer', 'operator.identitasReviewer');
});

require __DIR__.'/auth.php';
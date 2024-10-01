<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Operator\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth:operator')->group(function () {
    Route::get('/operator/dashboard', [DashboardController::class, 'index'])->name('operator.dashboard');
    Route::view('/operator/identitasusulan', 'operator.identitasusulan');
    Route::view('/operator/usulandidanai', 'operator.usulandidanai');
    Route::post('/operator/dashboard', [DashboardController::class, 'storeFile'])->name('operator.file');
});

require __DIR__.'/auth.php';
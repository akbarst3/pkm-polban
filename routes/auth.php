<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Operator\AuthController;

Route::middleware('guest:operator')->group(function () {
    Route::get('/operator/login', [AuthController::class, 'create'])->name('operator.login');
    Route::post('/operator/login', [AuthController::class, 'login'])->name('operator.login');
});

Route::middleware('auth:operator')->group(function () {
    Route::get('/operator/dashboard', function () {
        return view('operator.dashboard');
    })->name('operator.dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('operator.logout');
});
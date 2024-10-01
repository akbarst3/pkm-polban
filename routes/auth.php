<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Operator\AuthController;
use App\Http\Controllers\Operator\DashboardController;

Route::middleware('guest:operator')->group(function () {
    Route::get('/operator/login', [AuthController::class, 'create'])->name('operator.login');
    Route::post('/operator/login', [AuthController::class, 'login'])->name('operator.login');
});

Route::middleware('auth:operator')->group(function () {
    Route::post('/operator/logout', [AuthController::class, 'logout'])->name('operator.logout');
});
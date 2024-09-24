<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Operator\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest:operator')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::middleware('auth:operator')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

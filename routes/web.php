<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Operator\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth:operator')->group(function () {
    Route::view('/operator/dashboard', 'operator.dashboard');

    // Rute untuk menampilkan form input
    Route::get('/input-mahasiswa', function () {
        return view('input_mahasiswa');
    });

    // Rute untuk menyimpan data
    Route::post('/simpan-mahasiswa', [MahasiswaController::class, 'store'])->name('simpan.mahasiswa');
    });

require __DIR__.'/auth.php';
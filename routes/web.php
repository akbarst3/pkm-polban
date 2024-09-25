<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Operator\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth:operator')->group(function () {
    Route::view('/operator/dashboard', 'operator.dashboard');
});

require __DIR__.'/auth.php';
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Operator\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth:operator')->group(function () {
    Route::view('/operator/dashboard', 'operator.dashboard');
    Route::view('/operator/identitasusulan', 'operator.identitasusulan');
    Route::view('/operator/usulandidanai', 'operator.usulandidanai');

});

require __DIR__.'/auth.php';
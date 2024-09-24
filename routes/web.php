<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/operator/dashboard', function () {
    return view('operator.dashboard');
})->name('home');

require __DIR__.'/auth.php';
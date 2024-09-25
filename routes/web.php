<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Operator\AuthController;

Route::get('/', function () {
    return view('welcome');
});


require __DIR__.'/auth.php';
<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValidasiPimpinanController extends Controller
{
    public function index()
    {
        return view('pimpinan/validasipimpinan');
    }
}
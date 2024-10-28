<?php

namespace App\Http\Controllers\Dospem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogbookKeuanganDospemController extends Controller
{
    public function index()
    {
        return view('dospem/logbookkeuangan');
    }
}

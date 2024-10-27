<?php

namespace App\Http\Controllers\Dospem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardDospemController extends Controller
{
    public function index()
    {
        return view('dospem/dashboard');
    }
}

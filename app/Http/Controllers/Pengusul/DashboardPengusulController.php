<?php

namespace App\Http\Controllers\Pengusul;

use App\Http\Controllers\Controller;
use App\Models\DetailPkm;
use Illuminate\Http\Request; 
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;

class DashboardPengusulController extends Controller
{
    public function getNimMahasiswa()
    {
        $nim = Auth::user()->nim;
        $Mahasiswa = Mahasiswa::where('nim', $nim)->get();
        //dd($Mahasiswa);
        return $Mahasiswa;
    }

    public function index()
    {
        $nim = '231511065';
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        // dd($mahasiswa);           //                                                          
        return view('pengusul.dashboard', compact('mahasiswa'));
    }
}

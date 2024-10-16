<?php

namespace App\Http\Controllers\Operator;

use App\Models\SkemaPkm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UreviewerController extends Controller
{
    public function index()
    {
        $kodePt = Auth::user()->kode_pt;
        //dd($kodePt);
        $skema = SkemaPkm::all();
        // dd($skema);

        return view('operator.identitasReviewer', compact('kodePt', 'skema'));
    }

    public function findDosen(Request $request)
    {
        $request->validate([
            'skemaPkm' => ['required', 'exists:id_skema']
        ]);
        
    }
}

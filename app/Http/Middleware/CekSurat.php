<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\SuratPt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekSurat
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next)
    {

        $kodePt = Auth::guard('operator')->user()->kode_pt;
        $dataDoesNotExist = SuratPt::where('kode_pt', $kodePt)->doesntExist();

        if ($dataDoesNotExist) {
            session()->flash('error', 'Anda tidak bisa mengakses halaman tersebut selama belum mengupload surat yang diperlukan');
            return back();
        }

        return $next($request);
    }
}

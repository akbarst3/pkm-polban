<?php

namespace App\Http\Middleware;

use App\Models\DetailPkm;
use App\Models\Mahasiswa;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Pendanaan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $pengusul = Mahasiswa::where('nim', auth::guard('pengusul')->user()->nim)->first();
        $pkm = DetailPkm::where('id', $pengusul->id_pkm)->first();
        if (!$pkm || !$pkm->val_pt || $pkm->id_skema == 9 || $pkm->id_skema == 10) {
            return back()->with('error', 'Anda tidak bisa mengakses halaman tersebut');
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Controllers\Operator;

use App\Models\DetailPkm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function getCountJudul()
    {
        return DetailPkm::groupBy('id_skema')
            ->select('id_skema', DetailPkm::raw('count(judul) as total'))
            ->orderBy('id_skema', 'asc')
            ->get()
            ->pluck('total', 'id_skema');
    }

    public function getCountIdentitas()
    {
        return DetailPkm::with('mahasiswas.pengusul')
            ->orderBy('id_skema', 'asc')
            ->get()
            ->groupBy('id_skema')
            ->map(function ($group) {
                $count = $group->sum(function ($detail) {
                    return $detail->mahasiswas ? ($detail->mahasiswas->pengusul ? 1 : 0) : 0;
                });
                return [
                    'id_skema' => $group->first()->id_skema,
                    'count' => $count,
                ];
            });
    }

    public function getCountProposal()
    {
        return DetailPkm::groupBy('id_skema')
            ->select('id_skema', DetailPkm::raw('count(proposal) as total'))
            ->orderBy('id_skema', 'asc')
            ->get()
            ->pluck('total', 'id_skema');
    }

    public function getCountValidasi()
    {
        $val_dospem = DetailPkm::select('id_skema', DetailPkm::raw('SUM(CASE WHEN val_dospem = TRUE THEN 1 ELSE 0 END) as total'))
            ->groupBy('id_skema')
            ->orderBy('id_skema', 'asc')
            ->get()
            ->pluck('total', 'id_skema');

        $val_pt = DetailPkm::select('id_skema', DetailPkm::raw('SUM(CASE WHEN val_pt = TRUE THEN 1 ELSE 0 END) as total'))
            ->groupBy('id_skema')
            ->orderBy('id_skema', 'asc')
            ->get()
            ->pluck('total', 'id_skema');

        return [
            'val_dospem' => $val_dospem,
            'val_pt' => $val_pt,
        ];
    }

    public function getAllCounts()
    {
        $judulCounts = $this->getCountJudul();
        $proposalCounts = $this->getCountProposal();
        $pengisianCounts = $this->getCountIdentitas();
        $validasiCounts = $this->getCountValidasi();

        return view('operator.index', compact('judulCounts', 'proposalCounts', 'pengisianCounts', 'validasiCounts'));
    }  
}

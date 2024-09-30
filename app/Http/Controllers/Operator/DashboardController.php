<?php

namespace App\Http\Controllers\Operator;

use App\Models\DetailPkm;
use App\Models\OperatorPt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    private function getKodePtOperator()
    {
        $op = OperatorPt::all();
        $kodePtOp = [];
        foreach ($op as $operator) {
            $kodePtOp[] = $operator->kode_pt;
        }
        return $kodePtOp;
    }

    public function getCountJudul()
    {
        $kodePtOp = $this->getKodePtOperator();
        $result = DetailPkm::whereIn('kode_pt', $kodePtOp)
            ->groupBy('id_skema')
            ->select('id_skema', DetailPkm::raw('count(judul) as total'))
            ->orderBy('id_skema', 'asc')
            ->get()
            ->pluck('total', 'id_skema');
    
        return $result->count() ? $result : collect([0 => ['id_skema' => 0, 'total' => 0]]);
    }
    
    public function getCountIdentitas()
    {
        $kodePtOp = $this->getKodePtOperator();
        $result = DetailPkm::with('mahasiswas.pengusul')
            ->whereIn('kode_pt', $kodePtOp)
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
    
        return $result->count() ? $result : collect([0 => ['id_skema' => 0, 'count' => 0]]);
    }
    
    public function getCountProposal()
    {
        $kodePtOp = $this->getKodePtOperator();
        $result = DetailPkm::whereIn('kode_pt', $kodePtOp)
            ->groupBy('id_skema')
            ->select('id_skema', DetailPkm::raw('count(proposal) as total'))
            ->orderBy('id_skema', 'asc')
            ->get()
            ->pluck('total', 'id_skema');
    
        return $result->count() ? $result : collect([0 => ['id_skema' => 0, 'total' => 0]]);
    }
    
    public function getCountValidasi()
    {
        $kodePtOp = $this->getKodePtOperator();
        $val_dospem = DetailPkm::whereIn('kode_pt', $kodePtOp)
            ->select('id_skema', DetailPkm::raw('SUM(CASE WHEN val_dospem = TRUE THEN 1 ELSE 0 END) as total'))
            ->groupBy('id_skema')
            ->orderBy('id_skema', 'asc')
            ->get()
            ->pluck('total', 'id_skema');
    
        $val_pt = DetailPkm::whereIn('kode_pt', $kodePtOp)
            ->select('id_skema', DetailPkm::raw('SUM(CASE WHEN val_pt = TRUE THEN 1 ELSE 0 END) as total'))
            ->groupBy('id_skema')
            ->orderBy('id_skema', 'asc')
            ->get()
            ->pluck('total', 'id_skema');
    
        return [
            'val_dospem' => $val_dospem->count() ? $val_dospem : collect([0 => ['id_skema' => 0, 'total' => 0]]),
            'val_pt' => $val_pt->count() ? $val_pt : collect([0 => ['id_skema' => 0, 'total' => 0]]),
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

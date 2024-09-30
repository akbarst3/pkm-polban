<?php

namespace App\Http\Controllers\Operator;

use App\Models\DetailPkm;
use App\Models\OperatorPt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PerguruanTinggi;
use App\Models\SkemaPkm;
use App\Models\SuratPt;
use Illuminate\Support\Facades\Auth;

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
<<<<<<< HEAD
<<<<<<< HEAD

        return $result->count() ? $result : collect([0 => ['id_skema' => 0, 'count' => 0]]);
=======
>>>>>>> e07f314 (add: file DashboardController.php)
=======
    
        return $result->count() ? $result : collect([0 => ['id_skema' => 0, 'count' => 0]]);
>>>>>>> ac45e7b (add: add file DashboardController)
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
<<<<<<< HEAD
<<<<<<< HEAD

        return $result->count() ? $result : collect([0 => ['id_skema' => 0, 'total' => 0]]);
=======
>>>>>>> e07f314 (add: file DashboardController.php)
=======
    
        return $result->count() ? $result : collect([0 => ['id_skema' => 0, 'total' => 0]]);
>>>>>>> ac45e7b (add: add file DashboardController)
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
<<<<<<< HEAD

<<<<<<< HEAD
        $val_pt = DetailPkm::whereIn('kode_pt', $kodePtOp)
            ->select('id_skema', DetailPkm::raw('SUM(CASE WHEN val_pt = TRUE THEN 1 ELSE 0 END) as total'))
=======
        $val_pt = DetailPkm::select('id_skema', DetailPkm::raw('SUM(CASE WHEN val_pt = TRUE THEN 1 ELSE 0 END) as total'))
>>>>>>> e07f314 (add: file DashboardController.php)
=======
    
        $val_pt = DetailPkm::whereIn('kode_pt', $kodePtOp)
            ->select('id_skema', DetailPkm::raw('SUM(CASE WHEN val_pt = TRUE THEN 1 ELSE 0 END) as total'))
>>>>>>> ac45e7b (add: add file DashboardController)
            ->groupBy('id_skema')
            ->orderBy('id_skema', 'asc')
            ->get()
            ->pluck('total', 'id_skema');
    
        return [
            'val_dospem' => $val_dospem->count() ? $val_dospem : collect([0 => ['id_skema' => 0, 'total' => 0]]),
            'val_pt' => $val_pt->count() ? $val_pt : collect([0 => ['id_skema' => 0, 'total' => 0]]),
        ];
    }

    public function storeFile(Request $request)
    {
        $request->validate([
            'beritaAcaraPendanaan' => 'required|mimes:pdf|max:5120',
            'suratKomitmen' => 'required|mimes:pdf|max:5120',
            'beritaAcaraInsentif' => 'required|mimes:pdf|max:5120',
        ], [
            'beritaAcaraPendanaan.required' => 'File Berita Acara PKM Skema Pendanaan wajib diunggah.',
            'beritaAcaraPendanaan.mimes' => 'File Berita Acara PKM Skema Pendanaan harus berformat PDF.',
            'beritaAcaraPendanaan.max' => 'File Berita Acara PKM Skema Pendanaan tidak boleh lebih dari 5 MB.',

<<<<<<< HEAD
            'suratKomitmen.required' => 'File Surat Komitmen Dana Tambahan wajib diunggah.',
            'suratKomitmen.mimes' => 'File Surat Komitmen Dana Tambahan harus berformat PDF.',
            'suratKomitmen.max' => 'File Surat Komitmen Dana Tambahan tidak boleh lebih dari 5 MB.',

            'beritaAcaraInsentif.required' => 'File Berita Acara PKM Skema Insentif wajib diunggah.',
            'beritaAcaraInsentif.mimes' => 'File Berita Acara PKM Skema Insentif harus berformat PDF.',
            'beritaAcaraInsentif.max' => 'File Berita Acara PKM Skema Insentif tidak boleh lebih dari 5 MB.',
        ]);
        $kodePt = Auth::user()->kode_pt;
        $idSurat = 1;
        foreach (['beritaAcaraPendanaan', 'suratKomitmen', 'beritaAcaraInsentif'] as $fileInput) {
            if ($request->hasFile($fileInput)) {
                $filePath = $request->file($fileInput)->store('private/surat_pt');

                SuratPt::create([
                    'kode_pt' => $kodePt,
                    'file_surat' => $filePath,
                    'id_tipe' => $idSurat,
                ]);
                $idSurat++;
            }
        };
        return redirect()->back()->with('success', 'File berhasil diupload!');
    }

    public function getDataFile()
    {
        $Pt = $this->getPt();
        $Pt = $Pt->kode_pt;
        $statusFiles = [
            'beritaAcaraPendanaan' => false,
            'suratKomitmen' => false,
            'beritaAcaraInsentif' => false,
        ];
        $suratRecords = SuratPt::where('kode_pt', $Pt)->get();
        foreach ($suratRecords as $surat) {
            switch ($surat->id_tipe) {
                case 1:
                    $statusFiles['beritaAcaraPendanaan'] = true;
                    break;
                case 2:
                    $statusFiles['suratKomitmen'] = true;
                    break;
                case 3:
                    $statusFiles['beritaAcaraInsentif'] = true;
                    break;
            }
        }

        return $statusFiles;
    }

    public function getPt()
    {
        $kodePt = Auth::user()->kode_pt;
        $perguruanTinggi = PerguruanTinggi::where('kode_pt', $kodePt)->first();
        return $perguruanTinggi;
    }

    public function index()
    {
        $perguruanTinggi = $this->getPt();
        $statusFiles = $this->getDataFile();
        $dataPkms = [
            ['judulCounts' => $this->getCountJudul()],
            ['proposalCounts' => $this->getCountProposal()],
            ['pengisianCounts' => $this->getCountIdentitas()],
            ['validasiCounts' => $this->getCountValidasi()],
        ];

        $namaSkema = SkemaPkm::pluck('nama_skema', 'id');
        return view('operator.dashboard', compact('dataPkms', 'perguruanTinggi', 'statusFiles', 'namaSkema'));
    }
=======
        return view('operator.index', compact('judulCounts', 'proposalCounts', 'pengisianCounts', 'validasiCounts'));
<<<<<<< HEAD
    }  
>>>>>>> e07f314 (add: file DashboardController.php)
=======
    }
>>>>>>> ac45e7b (add: add file DashboardController)
}

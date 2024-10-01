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

    public function storeFile(Request $request)
    {
        // Validasi input file
        $request->validate([
            'beritaAcaraPendanaan' => 'required|mimes:pdf|max:2048',
            'suratKomitmen' => 'required|mimes:pdf|max:2048',
            'beritaAcaraInsentif' => 'required|mimes:pdf|max:2048',
        ]);

        // Ambil kode_pt dari user yang sedang login
        $kodePt = Auth::user()->kode_pt;

        // Set id_tipe awal
        $idSurat = 1;

        // Loop untuk menyimpan file
        foreach (['beritaAcaraPendanaan', 'suratKomitmen', 'beritaAcaraInsentif'] as $fileInput) {
            if ($request->hasFile($fileInput)) {
                // Simpan file dan ambil path
                $filePath = $request->file($fileInput)->store('private/surat_pt');

                // Simpan data ke dalam tabel SuratPt
                SuratPt::create([
                    'kode_pt' => $kodePt,
                    'file_surat' => $filePath,
                    'id_tipe' => $idSurat,
                ]);

                // Increment id_tipe
                $idSurat++;
            }
        }

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'File berhasil diupload');
    }

    public function getDataFile()
    {
        $kodePt = Auth::user()->kode_pt;

        $statusFiles = [
            'beritaAcaraPendanaan' => false,
            'suratKomitmen' => false,
            'beritaAcaraInsentif' => false,
        ];

        $suratRecords = SuratPt::where('kode_pt', $kodePt)->get();

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

    public function index()
    {
        $statusFiles = $this->getDataFile();
        $dataPkms = [
            ['judulCounts' => $this->getCountJudul()],
            ['proposalCounts' => $this->getCountProposal()],
            ['pengisianCounts' => $this->getCountIdentitas()],
            ['validasiCounts' => $this->getCountValidasi()],
        ];

        // dd($dataPkms); 
        $namaSkema = SkemaPkm::pluck('nama_skema', 'id'); // ambil id_skema juga untuk mapping
        $kode_pt = $this->getKodePtOperator();
        $perguruanTinggi = PerguruanTinggi::where('kode_pt', $kode_pt)->first()->nama_pt;

        return view('operator.dashboard', compact('dataPkms', 'perguruanTinggi', 'statusFiles', 'namaSkema'));
    }
}

<?php

namespace App\Http\Controllers\Dospem;

use Exception;
use App\Models\Dosen;
use App\Models\SkemaPkm;
use App\Models\DetailPkm;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\LogbookKegiatan;
use App\Models\LogbookKeuangan;
use App\Models\PerguruanTinggi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DospemController extends Controller
{
    protected function getData()
    {
        $dosen = Dosen::findOrFail(Auth::guard('dospem')->user()->kode_dosen);
        $prodi = ProgramStudi::findOrFail($dosen->kode_prodi);
        $perguruanTinggi = PerguruanTinggi::findOrFail($prodi->kode_pt);
        return [
            'dosen' => $dosen,
            'perguruanTinggi' => $perguruanTinggi
        ];
    }

    public function index()
    {
        $data = $this->getData();
        return view('dospem.dashboard', ['data' => $data, 'title' => 'Dashboard Dosen Pendamping']);
    }

    public function showData()
    {
        $data = $this->getData();
        ['perguruanTinggi' => $pt] = $this->getData();
        $pkms = DetailPkm::where('kode_pt', $pt->kode_pt)
            ->whereHas('pengesahan')
            ->get();

        $pengusuls = [];
        $skemas = [];
        $nameDospems = [];
        $kodeDospems = [];
        $valDospems = [];
        $valPts = [];

        foreach ($pkms as $pkm) {
            $skema = SkemaPkm::where('id', $pkm->id_skema)->first();
            $pengusul = Mahasiswa::where('id_pkm', $pkm->id)->first();
            $dospem = Dosen::where('kode_dosen', $pkm->kode_dosen)->first();

            if ($pengusul) {
                $pengusuls[] = $pengusul;
                $skemas[] = $skema->nama_skema;
                $nameDospems[] = $dospem->nama;
                $kodeDospems[] = $dospem->kode_dosen;
                $valDospems[] = $pkm->val_dospem;
                $valPts[] = $pkm->val_pt;
            }
        }

        $viewData = [
            'perguruanTinggi' => $pt,
            'pkms' => $pkms,
            'pengusuls' => $pengusuls,
            'skemas' => $skemas,
            'nameDospems' => $nameDospems,
            'kodeDospems' => $kodeDospems,
            'valDospems' => $valDospems,
            'valPts' => $valPts
        ];

        return view('dospem/validasi-proposal', [
            'data' => array_merge($data, ['viewData' => $viewData]),
            'title' => 'Dashboard Pimpinan'
        ]);
    }


    public function showProposal($filename)
    {
        try {
            $decodedFilename = base64_decode($filename);
            
            if (!Storage::exists($decodedFilename)) {
                return abort(404, 'File not found');
            }

            $extension = pathinfo($decodedFilename, PATHINFO_EXTENSION);
            if (strtolower($extension) !== 'pdf') {
                return abort(404, 'Invalid file type');
            }

            return response()->stream(
                function () use ($decodedFilename) {
                    $fileStream = Storage::readStream($decodedFilename);
                    fpassthru($fileStream);
                    if (is_resource($fileStream)) {
                        fclose($fileStream);
                    }
                },
                200,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . basename($decodedFilename) . '"',
                ]
            );
        } catch (\Exception $e) {
            return abort(500, 'Error accessing file');
        }
    }

    public function validate(Request $request)
    {
        $request->validate([
            'pkm_id' => 'required|exists:detail_pkms,id',
            'val_dospem' => 'nullable'
        ]);
        
        $pkm = DetailPkm::findOrFail($request->pkm_id);
        
        if ($request->val_dospem === 'null') {
            $pkm->update([
                'val_dospem' => null,
            ]);
            $message = 'Status dibatalkan.';
        } else {
            $pkm->update([
                'val_dospem' => $request->val_dospem,
            ]);
            $message = $request->val_dospem ? 'Usulan disetujui.' : 'Usulan ditolak.';
        }
        
        session()->flash('success', $message);
        return redirect()->intended(route('dosen-pendamping.proposal'));    }

    public function validasiUsulanDisetujui($id_pkm)
    {
        $data = $this->getData();
        $data['pkm'] = DetailPkm::findOrFail($id_pkm);
        $data['skema'] = SkemaPkm::where('id', $data['pkm']->id_skema)->first();
        $data['pengusul'] = Mahasiswa::where('id_pkm', $data['pkm']->id)->first();
        $data['prodi'] = ProgramStudi::where('kode_prodi', $data['pengusul']->kode_prodi)->first();
        $data['dospem'] = Dosen::where('kode_dosen', $data['pkm']->kode_dosen)->first();

        return view('dospem/validasi-usulan', [
            'data' => $data,
            'title' => 'Dashboard Dosen Pendamping',
        ]);
    }

    public function validasiLogbook()
    {
        $data = $this->getData();
        $data['pkms'] = DetailPkm::where('kode_dosen', $data['dosen']->kode_dosen)
            ->whereHas('pengesahan')
            ->where('val_pt', true)
            ->whereHas('mahasiswas.pengusul')
            ->with(['mahasiswas' => function ($query) {
                $query->whereHas('pengusul')->limit(1);
            }, 'skema'])
            ->get()
            ->map(function ($detailPkm) {
                $detailPkm->mahasiswa = $detailPkm->mahasiswas->first();
                unset($detailPkm->mahasiswas);
                return $detailPkm;
            });
        return view('dospem.validasi-logbook', ['data' => $data, 'title' => 'Validasi Logbook']);
    }

    public function validasiLogbookKegiatan($pkm)
    {
        $data = $this->getData();
        $data['logbooks'] = LogbookKegiatan::where('id_pkm', $pkm)->get();
        return view('dospem.logbook-kegiatan', ['data' => $data, 'title' => 'Validasi Logbook Kegiatan']);
    }

    public function validasiLogbookKeuangan($pkm)
    {
        $data = $this->getData();
        $data['logbooks'] = LogbookKeuangan::where('id_pkm', $pkm)->get();
        return view('dospem.logbook-keuangan', ['data' => $data, 'title' => 'Validasi Logbook Keuangan']);
    }

    public function approveLogbookKegiatan($logbook)
{
    try {
        $logbookKegiatan = LogbookKegiatan::findOrFail($logbook);
        $logbookKegiatan->update([
            'validasi' => 1
        ]);
        return back()->with('success', 'Logbook berhasil diapprove');
    } catch (ModelNotFoundException $e) {
        return back()->with('error', 'Logbook tidak ditemukan');
    } catch (Exception $e) {
        return back()->with('error', 'Terjadi kesalahan saat mengapprove logbook: ' . $e->getMessage());
    }
}

public function rejectLogbookKegiatan($logbook)
{
    try {
        $logbookKegiatan = LogbookKegiatan::findOrFail($logbook);
        $logbookKegiatan->update([
            'validasi' => 0
        ]);
        return back()->with('error', 'Logbook ditolak');
    } catch (ModelNotFoundException $e) {
        return back()->with('error', 'Logbook tidak ditemukan');
    } catch (Exception $e) {
        return back()->with('error', 'Terjadi kesalahan saat menolak logbook: ' . $e->getMessage());
    }
}
    public function approveLogbookKeuangan($logbook)
{
    try {
        $logbookKeuangan = LogbookKeuangan::findOrFail($logbook);
        $logbookKeuangan->update([
            'val_dospem' => 1
        ]); 
                    return back()->with('success', 'Logbook berhasil diapprove');
    } catch (ModelNotFoundException $e) {
        return back()->with('error', 'Logbook tidak ditemukan');
    } catch (Exception $e) {
        return back()->with('error', 'Terjadi kesalahan saat mengapprove logbook: ' . $e->getMessage());
    }
}

public function rejectLogbookKeuangan($logbook)
{
    try {
        $logbookKeuangan = LogbookKeuangan::findOrFail($logbook);
        $logbookKeuangan->update([
            'val_dospem' => 0
        ]);
        return back()->with('error', 'Logbook ditolak');
    } catch (ModelNotFoundException $e) {
        return back()->with('error', 'Logbook tidak ditemukan');
    } catch (Exception $e) {
        return back()->with('error', 'Terjadi kesalahan saat menolak logbook: ' . $e->getMessage());
    }
}
}

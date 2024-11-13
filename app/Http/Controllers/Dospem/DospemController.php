<?php

namespace App\Http\Controllers\Dospem;

use App\Models\Dosen;
use App\Models\SkemaPkm;
use App\Models\DetailPkm;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\PerguruanTinggi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $pkms = DetailPkm::where('kode_pt', $pt->kode_pt)->get();

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

        return view('dospem/validasi-usulan', [
            'data' => $data,
            'pkms' => $pkms,
            'title' => 'Dashboard Pimpinan',
            'pengusuls' => $pengusuls,
            'skemas' => $skemas,
            'nameDospems' => $nameDospems,
            'kodeDospems' => $kodeDospems,
            'valDospems' => $valDospems,
            'valPts' => $valPts
        ]);
    }

    public function validate(Request $request)
    {
        $request->validate([
            'val_dospem' => 'required|boolean',
            'pkm_id' => 'required|exists:detail_pkms,id'
        ]);

        $pkm = DetailPkm::findOrFail($request->pkm_id);

        $pkm->update([
            'val_dospem' => $request->val_dospem,
        ]);
        $message = $request->val_dospem ? 'Usulan disetujui.' : 'Usulan ditolak.';
        session()->flash('success', $message);
        return redirect()->intended(route('dosen-pendamping.proposal'));
    }

    public function validasiUsulanDisetujui(DetailPkm $pkm)
    {
        $data = $this->getData();
        $skema = SkemaPkm::where('id', $pkm->id_skema)->first();
        $pengusul = Mahasiswa::where('id_pkm', $pkm->id)->first();
        $prodi = ProgramStudi::where('kode_prodi', $pengusul->kode_prodi)->first();
        $dospem = Dosen::where('kode_dosen', $pkm->kode_dosen)->first();

        return view('dospem/validasi-usulan-disetujui', [
            'data' => $data,
            'title' => 'Dashboard Dosen Pendamping',
            'judul' => $pkm->judul,
            'nama' => $pengusul->nama,
            'nim' => $pengusul->nim,
            'namaProdi' => $prodi->nama_prodi,
            'namaDospem' => $dospem->nama,
            'nidn' => $dospem->kode_dosen,
            'skema' => $skema->nama_skema,
            'status' => $pkm->val_dospem,
            'pkm_id' => $pkm->id
        ]);
    }
}

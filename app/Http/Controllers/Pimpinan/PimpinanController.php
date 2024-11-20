<?php

namespace App\Http\Controllers\Pimpinan;

use App\Models\Dosen;
use App\Models\SkemaPkm;
use App\Models\DetailPkm;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\PerguruanTinggi;
use App\Http\Controllers\Controller;

class PimpinanController extends Controller
{
    protected function getData()
    {
        $allProdi = ProgramStudi::all();
        $first = $allProdi->first();
        $perguruanTinggi = PerguruanTinggi::where('kode_pt', $first->kode_pt)->first();
        return [
            'prodi' => $first,
            'perguruanTinggi' => $perguruanTinggi
        ];
    }

    public function index()
    {
        $data = $this->getData();
        return view('pimpinan/dashboard', ['data' => $data, 'title' => 'Dashboard Pimpinan']);
    }

    public function showData()
    {
        $data = $this->getData();
        ['perguruanTinggi' => $pt] = $this->getData();

        $pkms = DetailPkm::where('kode_pt', $pt->kode_pt)
            ->where('val_dospem', true)
            ->get();

        $data['pkms'] = $pkms;
        $data['pengusuls'] = [];
        $data['skemas'] = [];
        $data['dospems'] = [];
        $data['valDospems'] = [];
        $data['valPts'] = [];

        foreach ($pkms as $pkm) {
            $skema = SkemaPkm::where('id', $pkm->id_skema)->first();
            $pengusul = Mahasiswa::where('id_pkm', $pkm->id)->first();
            $dospem = Dosen::where('kode_dosen', $pkm->kode_dosen)->first();

            if ($pengusul) {
                $data['pengusuls'][] = $pengusul;
                $data['skemas'][] = $skema->nama_skema;
                $data['dospems'][] = $dospem->nama;
                $data['valDospems'][] = $pkm->val_dospem;
                $data['valPts'][] = $pkm->val_pt;
            }
        }
        return view('pimpinan/validasi-pimpinan', ['data' => $data, 'title' => 'Validasi Usulan PKM']);
    }


    public function validasi(Request $request)
    {
        $request->validate([
            'val_pt' => 'required|boolean',
            'pkm_id' => 'required|exists:detail_pkms,id'
        ]);

        $pkm = DetailPkm::findOrFail($request->pkm_id);

        if ($pkm->val_dospem == true) {
            $pkm->update([
                'val_pt' => $request->val_pt,
            ]);
            $message = $request->val_pt ? 'Proposal disetujui.' : 'Proposal ditolak.';
            session()->flash('success', $message);
        } else {
            session()->flash('error', 'Validasi Dosen pembimbing diperlukan sebelum validasi pimpinan.');
        }

        return redirect()->back();
    }

    public function validasiAll(Request $request)
    {
        $request->validate(['val_pt' => 'required|boolean']);
        $data = $this->getData();

        $updatedCount = DetailPkm::where('kode_pt', $data['perguruanTinggi']->kode_pt)
            ->where('val_dospem', true)
            ->whereNull('val_pt')
            ->update(['val_pt' => $request->val_pt]);

        $action = $request->val_pt ? 'disetujui' : 'ditolak';

        if ($updatedCount > 0) {
            session()->flash('success', "$updatedCount proposal telah $action.");
        } else {
            session()->flash('error', 'Tidak ada proposal yang dapat diperbarui.');
        }

        return redirect()->back();
    }

    public function resetValidasi()
    {
        ['perguruanTinggi' => $pt] = $this->getData();
        $resetCount = DetailPkm::where('kode_pt', $pt->kode_pt)->where('val_dospem', true)->update(['val_pt' => NULL]);

        session()->flash('success', "$resetCount usulan telah direset.");

        return redirect()->back();
    }
}

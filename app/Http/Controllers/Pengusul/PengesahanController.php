<?php

namespace App\Http\Controllers\Pengusul;

use App\Models\Pengusul;
use App\Models\DetailPkm;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pengesahan;

class PengesahanController extends Controller
{
    private function getPengusulData($nim)
    {
        $pengusul = Pengusul::where('nim', $nim)->firstOrFail();
        $mahasiswa = Mahasiswa::where('nim', $pengusul->nim)->firstOrFail();
        $detailPkm = DetailPkm::where('id', $mahasiswa->id_pkm)->firstOrFail();
        $pengesahan = Pengesahan::where('id_pkm', $detailPkm->id)->first();

        return [
            'pengusul' => $pengusul,
            'mahasiswa' => $mahasiswa,
            'detailPkm' => $detailPkm,
            'pengesahan' => $pengesahan
        ];
    }

    public function index()
    {
        try {
            // $nim = Auth::user()->nim;
            $nim = '231511065';

            $data = $this->getPengusulData($nim);

            $viewData = [
                'judulPkm' => $data['pengusul']->mahasiswa->detailPkm->judul,
                'skemaPkm' => $data['pengusul']->mahasiswa->detailPkm->skema->nama_skema,
                'namaPengusul' => $data['pengusul']->mahasiswa->nama,
                'nimPengusul' => $data['pengusul']->nim,
                'namaProdi' => $data['pengusul']->mahasiswa->prodi->nama_prodi,
                'namaPt' => $data['pengusul']->mahasiswa->prodi->pt->nama_pt,
                'alamatPengusul' => $data['pengusul']->alamat,
                'telpRumahPengusul' => $data['pengusul']->telp_rumah,
                'noHpPengusul' => $data['pengusul']->no_hp,
                'emailPengusul' => $data['pengusul']->email,
                'anggota' => Mahasiswa::where('id_pkm', $data['pengusul']->mahasiswa->id_pkm)->count(),
                'namaDospem' => $data['pengusul']->mahasiswa->detailPkm->dosen->nama,
                'nidn' => $data['pengusul']->mahasiswa->detailPkm->dosen->kode_dosen,
                'noHpDospem' => $data['pengusul']->mahasiswa->detailPkm->dosen->no_hp,
                'danaKemdikbud' => $data['pengusul']->mahasiswa->detailPkm->dana_kemdikbud,
                'danaPt' => $data['pengusul']->mahasiswa->detailPkm->dana_pt,
                'danaLain' => $data['pengusul']->mahasiswa->detailPkm->dana_lain,
                'pengesahan' => $data['pengesahan']
            ];

            return view('pengusul.identitas-usulan', compact('viewData'));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            // $nim = Auth::user()->nim;
            $nim = '231511065';

            $data = $this->getPengusulData($nim);
            $request->validate([
                'kota_pengesahan' => 'required',
                'waktu_pelaksanaan' => 'required',
                'nama_pengesahan' => 'required',
                'jabatan' => 'required',
                'NIP' => 'required',
            ]);

            if ($data['pengesahan'] != null) {
                $data['pengesahan']->update([
                    'kota_pengesahan' => $request->kota_pengesahan,
                    'waktu_pelaksanaan' => $request->waktu_pelaksanaan,
                    'nama' => $request->nama_pengesahan,
                    'jabatan' => $request->jabatan,
                    'NIP' => $request->NIP,
                ]);
            } else {
                Pengesahan::create([
                    'id_pkm' => $data['detailPkm']->id,
                    'kota_pengesahan' => $request->kota_pengesahan,
                    'waktu_pelaksanaan' => $request->waktu_pelaksanaan,
                    'nama' => $request->nama_pengesahan,
                    'jabatan' => $request->jabatan,
                    'NIP' => $request->NIP,
                ]);
            }

            return redirect()->route('pengusul.pengesahan')->with('success', 'Data Pengesahan berhasil disimpan');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

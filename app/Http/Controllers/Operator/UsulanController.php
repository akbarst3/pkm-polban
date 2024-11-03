<?php

namespace App\Http\Controllers\Operator;

use App\Models\Dosen;
use App\Models\Pengusul;
use App\Models\SkemaPkm;
use App\Models\DetailPkm;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\DosenPendamping;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Operator\DashboardController;

class UsulanController extends Controller
{
    protected $dashboard;

    public function __construct()
    {
        $this->dashboard = new DashboardController();
    }
    public function index()
    {
        $perguruanTinggi = $this->dashboard->getPt();
        $statusFiles = $this->dashboard->getDataFile();
        $pengusuls = $this->showPengusul();
        $skema = SkemaPkm::all();
        return view('operator.usulan-baru', compact('perguruanTinggi', 'skema', 'statusFiles', 'pengusuls'));
    }

    public function viewData($nim)
    {
        $perguruanTinggi = $this->dashboard->getPt();
        $statusFiles = $this->dashboard->getDataFile();
        $mahasiswa = Mahasiswa::find($nim);
        $pengusul = Pengusul::where('nim', $nim)->first();
        $pengusul->password_plain = decrypt($pengusul->password_plain);
        $prodi = ProgramStudi::where('kode_prodi', $mahasiswa->kode_prodi)->first();
        $pkm = DetailPkm::join('mahasiswas', 'detail_pkms.id', '=', 'mahasiswas.id_pkm')->where('mahasiswas.nim', $nim)->first();
        $dosen = Dosen::where('kode_dosen', $pkm->kode_dosen)->first();
        $dospem = DosenPendamping::where('kode_dosen', $dosen->kode_dosen)->first();
        $dosen->username = $dospem->username;
        $dosen->password_plain = decrypt($dospem->password_plain);
        $skema = SkemaPkm::where('id', $pkm->id_skema)->first();
        $judulSkema = $skema->nama_skema;

        $data = [
            'mahasiswa' => $mahasiswa,
            'pengusul' => $pengusul,
            'namaProdi' => $prodi->nama_prodi,
            'judulPkm' => $pkm->judul,
            'judulSkema' => $judulSkema,
            'dosen' => $dosen,
            'namaProdiDosen' => ProgramStudi::where('kode_prodi', $dosen->kode_prodi)->first()->nama_prodi,
        ];
        return view('operator.show-data-pengusul', compact('data', 'perguruanTinggi', 'statusFiles'));
    }

    public function showPengusul()
    {
        $kodePt = $this->dashboard->getPt();
        $kodePt = $kodePt->kode_pt;
        $detailPkms = DetailPkm::where('kode_pt', $kodePt)->get();

        $pengusuls = Pengusul::whereIn('nim', function ($query) use ($detailPkms) {
            $query->select('nim')->from('mahasiswas')->whereIn('id_pkm', $detailPkms->pluck('id'));
        })->get();

        foreach ($pengusuls as $pengusul) {
            $mahasiswa = Mahasiswa::where('nim', $pengusul->nim)->first();
            $pengusul->nama_mahasiswa = $mahasiswa->nama;
            $pengusul->angkatan = $mahasiswa->angkatan;
            $pengusul->kode_prodi = $mahasiswa->kode_prodi;

            $prodi = ProgramStudi::where('kode_prodi', $mahasiswa->kode_prodi)->first();
            $pengusul->nama_prodi = $prodi->nama_prodi;

            $pkm = DetailPkm::where('id', $mahasiswa->id_pkm)->first();
            $pengusul->judul_pkm = $pkm->judul;
            $pengusul->val_dospem = $pkm->val_dospem; // Tambahkan ini
            $pengusul->val_pt = $pkm->val_pt; // Tambahkan ini

            $skema = SkemaPkm::where('id', $pkm->id_skema)->first();
            $pengusul->nama_skema = $skema->nama_skema;

            $pengusul->jumlah_mahasiswa = Mahasiswa::where('id_pkm', $mahasiswa->id_pkm)->count();
        }

        return $pengusuls;
    }

    public function deleteData($nim)
    {
        Pengusul::where('nim', $nim)->delete();
        $pengusul = Mahasiswa::where('nim', $nim)->first();
        $pkm = DetailPkm::where('id', $pengusul->id_pkm)->first();
        $count = DetailPkm::where('kode_dosen', $pkm->kode_dosen)->count();
        if ($count == 1) {
            DosenPendamping::where('kode_dosen', $pkm->kode_dosen)->delete();
        }
        $dosen = Dosen::where('kode_dosen', $pkm->kode_dosen)->first();
        $pengusul->delete();
        $pkm->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }
}

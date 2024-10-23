<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Operator\DashboardController;
use Illuminate\Http\Request;

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
        return view('operator.usulan-baru', compact('perguruanTinggi', 'statusFiles'));
    }

    public function viewData($nim)
    {
        $mahasiswa = Mahasiswa::find($nim);
        $pengusul = Pengusul::where('nim', $nim)->first();
        $pengusul->password = decrypt($pengusul->password);
        $prodi = ProgramStudi::where('kode_prodi', $mahasiswa->kode_prodi)->first();
        $pkm = DetailPkm::join('mahasiswas', 'detail_pkms.id', '=', 'mahasiswas.id_pkm')->where('mahasiswas.nim', $nim)->first();
        $dosen = Dosen::where('kode_dosen', $pkm->kode_dosen)->first();
        $dospem = DosenPendamping::where('kode_dosen', $dosen->kode_dosen)->first();
        $dosen->username = $dospem->username;
        $dosen->password = decrypt($dospem->password);
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
    
        return view('operator.show-data-pengusul', $data);
    }

    public function showPengusul()
    {
        $kodePt = Auth::user()->kode_pt;
        $detailPkms = DetailPkm::where('kode_pt', $kodePt)->get(); 
        $pengusuls = Pengusul::whereIn('nim', function($query) use ($detailPkms) {$query->select('nim')->from('mahasiswas')->whereIn('id_pkm', $detailPkms->pluck('id'));})->get();
        foreach ($pengusuls as $pengusul) {
            $mahasiswa = Mahasiswa::where('nim', $pengusul->nim)->first();
            $pengusul->nama_mahasiswa = $mahasiswa->nama;
            $pengusul->angkatan = $mahasiswa->angkatan;
            $prodi = ProgramStudi::where('kode_prodi', $pengusul->mahasiswa->kode_prodi)->first();
            $pengusul->nama_prodi = $prodi->nama_prodi;
            $pkm = DetailPkm::where('id', $pengusul->mahasiswa->id_pkm)->first();
            $pengusul->judul_pkm = $pkm->judul;
            $skema = SkemaPkm::where('id', $pkm->id_skema)->first();
            $pengusul->nama_skema = $skema->nama_skema;
            $pengusul->jumlah_mahasiswa = Mahasiswa::where('id_pkm', $pengusul->mahasiswa->id_pkm)->count();
        }
        return view('operator.usulanBaru', compact('pengusuls'));
    }

    public function deleteData($nim)
    {
        Pengusul::where('nim', $nim)->delete();
        $pengusul = Mahasiswa::where('nim', $nim)->first();
        $pkm = DetailPkm::where('id', $pengusul->id_pkm)->first();
        $dosen = Dosen::where('kode_dosen', $pkm->kode_dosen)->first();
        DosenPendamping::where('kode_dosen', $dosen->kode_dosen)->delete();
        $pengusul->delete();
        $pkm->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }
}
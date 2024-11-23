<?php

namespace App\Http\Controllers\Pengusul;

use Exception;
use Throwable;
use App\Models\Dosen;
use App\Models\SkemaPkm;
use App\Models\DetailPkm;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\PerguruanTinggi;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

class PelaksanaanController extends Controller
{
    public function getData()
    {
        $nim = Auth::guard('pengusul')->user()->nim;
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $pkm = DetailPkm::where('id', $mahasiswa->id_pkm)->first();
        $prodi = ProgramStudi::where('kode_prodi', sprintf('%05d', $mahasiswa->kode_prodi))->first();
        $perguruanTinggi = PerguruanTinggi::where('kode_pt', $pkm->kode_pt)->first();
        $dosen = Dosen::where('kode_dosen', $pkm->kode_dosen)->first();
        $skema = SkemaPkm::where('id', $pkm->id_skema)->first();
        $anggota = Mahasiswa::where('id_pkm', $pkm->id)->where('nim', '!=', $nim)->get();
        $valDospem = $pkm->val_dospem;
        $statusUpload = !empty($pkm->lapkem) ? 'Sudah diupload' : 'Belum diupload';
        $fileUrl = !empty($pkm->lapkem) ? asset('storage/lapkem/' . $pkm->lapkem) : null;
        $totalDana = $pkm->dana_kemdikbud + $pkm->dana_pt + $pkm->dana_lain;
        return [
            'mahasiswa' => $mahasiswa,
            'pkm' => $pkm,
            'prodi' => $prodi,
            'perguruanTinggi' => $perguruanTinggi,
            'dosen' => $dosen,
            'skema' => $skema,
            'anggota' => $anggota,
            'valDospem' => $valDospem,
            'statusUpload' => $statusUpload,
            'fileUrl' => $fileUrl,
            'totalDana' => $totalDana,
        ];
    }

    public function createDashboard()
    {
        $data = $this->getData();
        return view('pengusul.pelaksanaan.dashboard-pelaksanaan', ['data' => $data, 'title' => 'Dashboard Pengusul']);
    }

    public function kemajuan()
    {
        $data = $this->getData();
        return view('pengusul.pelaksanaan.lap-kemajuan', ['data' => $data, 'title' => 'Laporan Kemajuan']);
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'lapkem' => 'required|file|mimes:pdf|max:2048',
        ]);

        $nim = Auth::guard('pengusul')->user()->nim;
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $pkm = DetailPkm::where('id', $mahasiswa->id_pkm)->first();

        if ($request->hasFile('lapkem')) {
            $file = $request->file('lapkem');
            //$fileName = time() . '_' . $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = 'lapkem_' . uniqid() . '.' . $extension;
            $filePath = 'private/lapkem/' . $fileName;  
            $file->storeAs('private/lapkem', $fileName);

            $pkm->lapkem = $filePath;
            $pkm->save();
        }

        return redirect()->back()->with('success', 'File berhasil diunggah!');
    }

    public function downloadFile($id)
    {
        $pkm = DetailPkm::findOrFail($id);

        if (!$pkm->lapkem) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }

        $filePath = storage_path('app/' . $pkm->lapkem);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }

        return response()->download($filePath, basename($pkm->lapkem));
    }
}

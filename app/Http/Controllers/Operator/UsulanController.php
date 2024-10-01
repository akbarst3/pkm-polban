<?php

namespace App\Http\Controllers\Operator;

use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DetailPkm;
use App\Models\Dosen;
use App\Models\DosenPendamping;
use App\Models\Mahasiswa;
use App\Models\Pengusul;
use App\Models\SkemaPkm;
use Illuminate\Support\Facades\Auth;

class UsulanController extends Controller
{
    public function index()
    {
        $pt_operator = Auth::user()->kode_pt;
        $pt_prodi = ProgramStudi::where('kode_pt', $pt_operator)->get();
        $skema = SkemaPkm::all();

        // dd($skema);
        return view('operator.identitasusulan', compact('pt_prodi', 'skema'));
    }

    public function findDosen(Request $request)
    {
        $nidn = $request->input('nidn');
        $dosen = Dosen::where('kode_dosen', $nidn)->first();
        $prodiDosen = ProgramStudi::where('kode_prodi', $dosen->kode_prodi)->first();
        // dd($prodiDosen);
        if ($dosen) {
            return response()->json([
                'nama' => $dosen->nama,
                'program_studi' => $prodiDosen->nama_prodi,
                'no_hp' => $dosen->no_hp,
                'email' => $dosen->email,
            ]);
        } else {
            return response()->json(['message' => 'NIDN not found!'], 404);
        }
    }

    public function storeData(Request $request){
        $pt_operator = Auth::user()->kode_pt;
        // dd($pt_operator);
        $request->validate([
            'nim' => ['required'],
            'namaMahasiswa' => ['required'],
            'tahunMasuk' => ['required'],
            'judulProposal' => ['required'],
        ]);

        $detailPkm = DetailPkm::create([
            'judul' => $request->input('judulProposal'),
            'id_skema' => $request->input('skemaPKM'),
            'kode_pt' => $pt_operator,
        ]);

        Mahasiswa::create([
            'nim' => $request->input('nim'),
            'nama' => $request->input('namaMahasiswa'),
            'angkatan' => $request->input('tahunMasuk'),
            'kode_prodi' => $request->input('programStudi'),
            'id_pkm' => $detailPkm->id
        ]);
        
        Pengusul::create([
            'nim' => $request->input('nim')
        ]);

        DosenPendamping::create([
            'kode_dosen' => $request->input('nidn')
        ]);


        return back()->with('success', 'Data berhasil disimpan');
    }
}

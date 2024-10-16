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

        $mahasiswa = Mahasiswa::create([
            'nim' => $request->input('nim'),
            'nama' => $request->input('namaMahasiswa'),
            'angkatan' => $request->input('tahunMasuk'),
            'kode_prodi' => $request->input('programStudi'),
            'id_pkm' => $detailPkm->id
        ]);
        
        $username_mahasiswa = $detailPkm->kode_pt . '-' . $mahasiswa->nim;
        $password_mahasiswa = encrypt(mt_rand(1000000, 9999999));
        
        // $password_mahasiswa1 = decrypt($password_mahasiswa);
        // $uspas_mahasiswa = [$username_mahasiswa, $password_mahasiswa, $password_mahasiswa1];
        
        Pengusul::create([
            'nim' => $request->input('nim'),
            'username' => $username_mahasiswa,
            'password' => $password_mahasiswa
        ]);
        
        $response = $this->findDosen($request);
        $dosen_data = json_decode($response->getContent(), true);
        
        $username_dosen = $detailPkm->kode_pt . '-' . $dosen_data['nama'];
        $password_dosen = encrypt(mt_rand(1000000, 9999999));
        // $password_dosen1 = decrypt($password_dosen);
        // $uspas_dosen = [$username_dosen, $password_dosen, $password_dosen1];

        DosenPendamping::create([
            'kode_dosen' => $request->input('nidn'),
            'username' => $username_dosen,
            'password' => $password_dosen
        ]);
        
        // dd($uspas_dosen);

        return back()->with('success', 'Data berhasil disimpan');
    }
}

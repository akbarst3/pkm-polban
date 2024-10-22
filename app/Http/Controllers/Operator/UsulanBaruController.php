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

class UsulanBaruController extends Controller
{
    protected $dashboard;
    public function __construct()
    {
        $this->dashboard = new DashboardController();
    }
    public function index()
    {
        $perguruanTinggi = $this->dashboard->getPt();
        $prodi = ProgramStudi::where('kode_pt', $perguruanTinggi->kode_pt)->get();
        $skema = SkemaPkm::all();
        $statusFiles = $this->dashboard->getDataFile();
        return view('operator.identitas-usulan', compact('prodi', 'skema', 'perguruanTinggi', 'statusFiles'));
    }

    public function findDosen(Request $request)
    {
        $nidn = $request->input('nidn');
        $dosen = Dosen::where('kode_dosen', $nidn)->first();
        if ($dosen) {
            $prodiDosen = ProgramStudi::where('kode_prodi', $dosen->kode_prodi)->first();
            return response()->json([
                'nama' => $dosen->nama,
                'program_studi' => $prodiDosen->nama_prodi,
                'no_hp' => $dosen->no_hp,
                'email' => $dosen->email,
            ]);
        } else {
            return response()->json(['message' => 'NIDN Dosen tidak ditemukan!'], 404);
        }
    }

    public function storeData(Request $request)
    {
        $kodePtOp = Auth::user()->kode_pt;
        $request->validate([
            'programStudi' => ['required', 'not_in:0'],
            'nim' => ['required', 'min:9', 'max:13'],
            'namaMahasiswa' => ['required'],
            'tahunMasuk' => ['required', 'not_in:0,'],
            'judulProposal' => ['required', function ($attribute, $value, $fail) {
                if (str_word_count($value) > 20) {
                    $fail('Judul proposal tidak boleh lebih dari 20 kata.');
                }
            }],
        ], [
            'programStudi.required' => 'Pilih Program Studi',
            'programStudi.not_in' => 'Pilih salah satu Program Studi',
            'nim.required' => 'NIM wajib diisi',
            'nim.min' => 'NIM harus terdiri dari minimal 9 karakter',
            'nim.max' => 'NIM tidak boleh lebih dari 9 karakter',
            'namaMahasiswa.required' => 'Nama mahasiswa wajib diisi',
            'tahunMasuk.required' => 'Tahun masuk wajib diisi',
            'judulProposal.required' => 'Judul proposal wajib diisi',
        ]);

        $detailPkm = DetailPkm::create([
            'judul' => $request->input('judulProposal'),
            'id_skema' => $request->input('skemaPKM'),
            'kode_pt' => $kodePtOp,
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

        // $nim = '3143524';
        // $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        // dd($uspas_dosen);
        session()->flash('success', 'Data berhasil disimpan');
        return redirect()->intended(route('operator.usulan.baru'));
    }
}

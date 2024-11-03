<?php

namespace App\Http\Controllers\Operator;

use Throwable;
use App\Models\Dosen;
use App\Models\Pengusul;
use App\Models\SkemaPkm;
use App\Models\DetailPkm;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\DosenPendamping;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Operator\DashboardController;
use Illuminate\Support\Facades\Hash;

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
        $kodePtOp = Auth::guard('operator')->user()->kode_pt;
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
            'nidn' => ['required'],
        ], [
            'programStudi.required' => 'Pilih Program Studi',
            'programStudi.not_in' => 'Pilih salah satu Program Studi',
            'nim.required' => 'NIM wajib diisi',
            'nim.min' => 'NIM harus terdiri dari minimal 9 karakter',
            'nim.max' => 'NIM tidak boleh lebih dari 9 karakter',
            'namaMahasiswa.required' => 'Nama mahasiswa wajib diisi',
            'tahunMasuk.required' => 'Tahun masuk wajib diisi',
            'judulProposal.required' => 'Judul proposal wajib diisi',
            'nidn.required' => 'NIDN perlu diisi',
        ]);
        
        try {
            DB::beginTransaction();

            if (Mahasiswa::where('nim', $request->input('nim'))->exists()) {
                throw new \Exception('Pengusul dengan NIM tersebut sudah terdaftar');
            }

            if (DetailPkm::where('kode_dosen', $request->input('nidn'))->count() == 10) {
                throw new \Exception('Dosen sudah mendampingi 10 judul PKM');
            }

            $detailPkm = DetailPkm::create([
                'judul' => $request->input('judulProposal'),
                'id_skema' => $request->input('skemaPKM'),
                'kode_pt' => $kodePtOp,
                'kode_dosen' => $request->input('nidn'),
            ]);

            $mahasiswa = Mahasiswa::create([
                'nim' => $request->input('nim'),
                'nama' => $request->input('namaMahasiswa'),
                'angkatan' => $request->input('tahunMasuk'),
                'kode_prodi' => $request->input('programStudi'),
                'id_pkm' => $detailPkm->id
            ]);

            $usnMhs = strval($kodePtOp) . '-' . $mahasiswa->nim;
            $pwMhs = mt_rand(1000000, 9999999);
            $pwMhsPlain = encrypt($pwMhs);
            $pwMhsHash = Hash::make($pwMhs);

            Pengusul::create([
                'nim' => $request->input('nim'),
                'username' => $usnMhs,
                'password' => $pwMhsHash,
                'password_plain' => $pwMhsPlain
            ]);
            $usnDosen = $detailPkm->kode_pt . '-' . $request->input('nidn');
            $pwDosen = mt_rand(1000000, 9999999);
            $pwDosenPlain = encrypt($pwDosen);
            $pwDosenHash = Hash::make($pwDosen);

            $dosenExists = DosenPendamping::where('kode_dosen', $request->input('nidn'))->exists();

            if (!$dosenExists) {
                DosenPendamping::create([
                    'kode_dosen' => $request->input('nidn'),
                    'username' => $usnDosen,
                    'password' => $pwDosenHash,
                    'password_plain' => $pwDosenPlain
                ]);
            }

            DB::commit();
            session()->flash('success', 'Data berhasil disimpan');
            return redirect()->intended(route('operator.usulan.baru'));
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
            return redirect()->back()->withInput();
        } catch (\Throwable) {
            session()->flash('error', 'Something went wrong');
            return redirect()->back()->withInput();
        }
    }
}

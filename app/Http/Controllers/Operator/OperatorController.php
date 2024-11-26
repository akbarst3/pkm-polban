<?php

namespace App\Http\Controllers\Operator;

use App\Models\Dosen;
use App\Models\SuratPt;
use App\Models\Pengusul;
use App\Models\SkemaPkm;
use App\Models\DetailPkm;
use App\Models\Mahasiswa;
use App\Models\OperatorPt;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\DosenPendamping;
use App\Models\PerguruanTinggi;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OperatorController extends Controller
{
    protected $dashboard;
    function getKodePtOperator()
    {
        $op = OperatorPt::all();
        $kodePtOp = [];
        foreach ($op as $operator) {
            $kodePtOp[] = $operator->kode_pt;
        }
        return $kodePtOp;
    }

    public function getCountJudul()
    {
        $kodePtOp = $this->getKodePtOperator();
        $result = DetailPkm::whereIn('kode_pt', $kodePtOp)->groupBy('id_skema')->select('id_skema', DetailPkm::raw('count(judul) as total'))->orderBy('id_skema', 'asc')->get()->pluck('total', 'id_skema');
        return $result->count() ? $result : collect([0 => ['id_skema' => 0, 'total' => 0]]);
    }

    public function getCountIdentitas()
    {
        $kodePtOp = $this->getKodePtOperator();
        $result = DetailPkm::selectRaw('detail_pkms.id_skema, COUNT(DISTINCT mahasiswas.nim) as total')->whereIn('detail_pkms.kode_pt', $kodePtOp)->join('mahasiswas', 'mahasiswas.id_pkm', '=', 'detail_pkms.id')->join('pengusuls', 'pengusuls.nim', '=', 'mahasiswas.nim')->whereNotNull('pengusuls.alamat')->groupBy('detail_pkms.id_skema')->get()->pluck('total', 'id_skema');

        return $result->count() ? $result : collect([0 => 0]);
    }

    public function getCountProposal()
    {
        $kodePtOp = $this->getKodePtOperator();
        $result = DetailPkm::whereIn('kode_pt', $kodePtOp)->whereNotNull('proposal')->groupBy('id_skema')->select('id_skema', DetailPkm::raw('count(proposal) as total'))->orderBy('id_skema', 'asc')->get()->pluck('total', 'id_skema');

        return $result->count() ? $result : collect([0 => 0]);
    }

    public function getCountValidasi()
    {
        $kodePtOp = $this->getKodePtOperator();
        $val_dospem = DetailPkm::whereIn('kode_pt', $kodePtOp)->select('id_skema', DetailPkm::raw('SUM(CASE WHEN val_dospem = TRUE THEN 1 ELSE 0 END) as total'))->groupBy('id_skema')->orderBy('id_skema', 'asc')->get()->pluck('total', 'id_skema');
        $val_pt = DetailPkm::whereIn('kode_pt', $kodePtOp)->select('id_skema', DetailPkm::raw('SUM(CASE WHEN val_pt = TRUE THEN 1 ELSE 0 END) as total'))->groupBy('id_skema')->orderBy('id_skema', 'asc')->get()->pluck('total', 'id_skema');

        return [
            'val_dospem' => $val_dospem->count() ? $val_dospem : collect([0 => ['id_skema' => 0, 'total' => 0]]),
            'val_pt' => $val_pt->count() ? $val_pt : collect([0 => ['id_skema' => 0, 'total' => 0]]),
        ];
    }

    public function storeFile(Request $request)
    {
        $request->validate([
            'beritaAcaraPendanaan' => 'required|mimes:pdf|max:5120',
            'suratKomitmen' => 'required|mimes:pdf|max:5120',
            'beritaAcaraInsentif' => 'required|mimes:pdf|max:5120',
        ], [
            'beritaAcaraPendanaan.required' => 'File Berita Acara PKM Skema Pendanaan wajib diunggah.',
            'beritaAcaraPendanaan.mimes' => 'File Berita Acara PKM Skema Pendanaan harus berformat PDF.',
            'beritaAcaraPendanaan.max' => 'File Berita Acara PKM Skema Pendanaan tidak boleh lebih dari 5 MB.',

            'suratKomitmen.required' => 'File Surat Komitmen Dana Tambahan wajib diunggah.',
            'suratKomitmen.mimes' => 'File Surat Komitmen Dana Tambahan harus berformat PDF.',
            'suratKomitmen.max' => 'File Surat Komitmen Dana Tambahan tidak boleh lebih dari 5 MB.',

            'beritaAcaraInsentif.required' => 'File Berita Acara PKM Skema Insentif wajib diunggah.',
            'beritaAcaraInsentif.mimes' => 'File Berita Acara PKM Skema Insentif harus berformat PDF.',
            'beritaAcaraInsentif.max' => 'File Berita Acara PKM Skema Insentif tidak boleh lebih dari 5 MB.',
        ]);
        $kodePt = Auth::guard('operator')->user()->kode_pt;
        $idSurat = 1;
        foreach (['beritaAcaraPendanaan', 'suratKomitmen', 'beritaAcaraInsentif'] as $fileInput) {
            if ($request->hasFile($fileInput)) {
                $filePath = $request->file($fileInput)->store('private/surat_pt');

                SuratPt::create([
                    'kode_pt' => $kodePt,
                    'file_surat' => $filePath,
                    'id_tipe' => $idSurat,
                ]);
                $idSurat++;
            }
        };
        return redirect()->back()->with('success', 'File berhasil diupload!');
    }

    public function getDataFile()
    {
        $Pt = $this->getPt();
        $Pt = $Pt->kode_pt;
        $statusFiles = [
            'beritaAcaraPendanaan' => false,
            'suratKomitmen' => false,
            'beritaAcaraInsentif' => false,
        ];
        $suratRecords = SuratPt::where('kode_pt', $Pt)->get();
        foreach ($suratRecords as $surat) {
            switch ($surat->id_tipe) {
                case 1:
                    $statusFiles['beritaAcaraPendanaan'] = true;
                    break;
                case 2:
                    $statusFiles['suratKomitmen'] = true;
                    break;
                case 3:
                    $statusFiles['beritaAcaraInsentif'] = true;
                    break;
            }
        }
        return $statusFiles;
    }

    public function getPt()
    {
        $kodePt = Auth::guard('operator')->user()->kode_pt;
        $perguruanTinggi = PerguruanTinggi::where('kode_pt', $kodePt)->first();
        return $perguruanTinggi;
    }

    public function index()
    {
        $perguruanTinggi = $this->getPt();
        $statusFiles = $this->getDataFile();
        $dataPkms = $dataPkms = [
            'judulCounts' => $this->getCountJudul(),
            'proposalCounts' => $this->getCountProposal(),
            'pengisianCounts' => $this->getCountIdentitas(),
            'validasiCounts' => $this->getCountValidasi(),
        ];

        $namaSkema = SkemaPkm::pluck('nama_skema', 'id');
        return view('operator.dashboard', compact('dataPkms', 'perguruanTinggi', 'statusFiles', 'namaSkema'));
    }

    public function index1()
    {
        $perguruanTinggi = $this->getPt();
        $prodi = ProgramStudi::where('kode_pt', $perguruanTinggi->kode_pt)->get();
        $skema = SkemaPkm::all();
        $statusFiles = $this->getDataFile();
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

    public function index2()
    {
        $perguruanTinggi = $this->getPt();
        $statusFiles = $this->getDataFile();
        $pengusuls = $this->showPengusul();
        $skema = SkemaPkm::all();
        return view('operator.usulan-baru', compact('perguruanTinggi', 'skema', 'statusFiles', 'pengusuls'));
    }

    public function viewData($nim)
    {
        $perguruanTinggi = $this->getPt();
        $statusFiles = $this->getDataFile();
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
        $kodePt = $this->getPt();
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

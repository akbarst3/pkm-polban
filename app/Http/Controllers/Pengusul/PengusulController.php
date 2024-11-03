<?php

namespace App\Http\Controllers\Pengusul;

use App\Models\Dosen;
use App\Models\Pengusul;
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

class PengusulController extends Controller
{
    public function getData()
    {
        $nim = Auth::guard('pengusul')->user()->nim;
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $pkm = DetailPkm::where('id', $mahasiswa->id_pkm)->first();
        $prodi = ProgramStudi::where('kode_prodi', sprintf('%05d', $mahasiswa->kode_prodi))->first();
        $perguruanTinggi = PerguruanTinggi::where('kode_pt', $pkm->kode_pt)->first();
        return [
            'mahasiswa' => $mahasiswa,
            'pkm' => $pkm,
            'prodi' => $prodi,
            'perguruanTinggi' => $perguruanTinggi
        ];
    }

    public function index()
    {
        $data = $this->getData();
        return view('pengusul.dashboard', ['data' => $data, 'title' => 'Dashboard Pengusul']);
    }

    public function showData()
    {
        $data = $this->getData();
        $data['skema'] = SkemaPkm::where('id', $data['pkm']->id_skema)->first();
        return view('pengusul.identitas-usulan', ['data' => $data, 'title' => 'Identitas Usulan']);
    }
    public function showDetail()
    {
        $data = $this->getData();
        $data['skema'] = SkemaPkm::where('id', $data['pkm']->id_skema)->first();
        $data['dospem'] = Dosen::where('kode_dosen', $data['pkm']->kode_dosen)->first();
        $data['anggota'] = Mahasiswa::where('id_pkm', $data['pkm']->id)->get();
        $kodeProdiAnggota = $data['anggota']->pluck('kode_prodi')->toArray();
        $kodeProdiAnggota = array_map('strval', $kodeProdiAnggota);
        $data['prodi'] = DB::table('program_studis')
            ->whereIn('kode_prodi', $kodeProdiAnggota)
            ->get();
        $data['anggota'] = Mahasiswa::where('id_pkm', $data['pkm']->id)
            ->with(['prodi' => function ($query) {
                $query->withCasts(['kode_prodi' => 'string']);
            }])
            ->get();
        $data['luarans'] = SkemaPkm::with('skemaluaran')->find($data['pkm']->id_skema)->toArray();
        $data['pengusul'] = Pengusul::where('nim', $data['mahasiswa']->nim)->first();
        return view('pengusul.edit-usulan', ['data' => $data, 'title' => 'Edit Usulan']);
    }

    public function editMhs(Request $request, $id)
    {
        $request->validate([
            'alamatMhs' => 'required',
            'noHpMhs' => ['required', 'min:11'],
            'noTelpRumahMhs' => 'required',
            'emailMhs' => ['required', 'email'],
        ], [
            'alamatMhs.required' => 'Alamat perlu diisi',
            'noHpMhs.required' => 'No HP perlu diisi',
            'noHpMhs.min' => 'No HP minimal 11 karakter',
            'noTelpRumahMhs.required' => 'No telepon rumah perlu diisi',
            'emailMhs.required' => 'Email perlu diisi',
            'emailMhs.email' => 'Harus diisi dengan format email',
        ]);


        $pengusul = Pengusul::where('nim', $id);
        $pengusul->update([
            'alamat' => $request->alamatMhs,
            'no_hp' => $request->noHpMhs,
            'telp_rumah' => $request->noTelpRumahMhs,
            'email' => $request->emailMhs,
        ]);

        session()->flash('success', 'Data berhasil diupdate');
        return redirect()->back()->withInput();
    }

    public function editPkm(Request $request, $id)
    {
        $request->validate([
            'dana_kemdikbud' => 'required',
            'dana_pt' => 'required',
        ], [
            'dana_kemdikbud.required' => 'Dana Kemdikbud perlu diisi',
            'dana_pt.required' => 'Dana Perguruan Tinggi perlu diisi',
        ]);

        $dana_kemdikbud = (int) str_replace(['Rp', '.', ' '], '', $request->dana_kemdikbud);
        $dana_pt = (int) str_replace(['Rp', '.', ' '], '', $request->dana_pt);

        $pkm = DetailPkm::where('id', $id);
        $pkm->update([
            'dana_kemdikbud' => $dana_kemdikbud,
            'dana_pt' => $dana_pt,
            'dana_lain' => $request->dana_lain,
            'instansi_lain' => $request->instansi_lain,
        ]);

        session()->flash('success', 'Data berhasil diupdate');
        return redirect()->back()->withInput();
    }


    public function tambahAnggota()
    {
        try {
            $baseData = $this->getData();
            $data = [
                'perguruanTinggi' => $baseData['perguruanTinggi'],
                'mahasiswa' => $baseData['mahasiswa'],
                'pkm' => $baseData['pkm'],
                'prodi' => ProgramStudi::where('kode_pt', $baseData['perguruanTinggi']->kode_pt)
                    ->orderBy('nama_prodi')
                    ->get(),
                'anggota' => null,
                'prodiAnggota' => null
            ];

            return view('pengusul.tambah-anggota', [
                'data' => $data,
                'isEdit' => false,
                'title' => 'Tambah Anggota Baru'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memuat form tambah anggota.');
        }
    }


    public function storeAnggota(Request $request)
    {
        $request->validate([
            'programStudi' => ['required', 'not_in:0'],
            'nim' => ['required', 'min:9', 'max:13'],
            'nama' => ['required'],
            'tahunMasuk' => ['required', 'not_in:0,'],
        ], [
            'programStudi.required' => 'Pilih Program Studi',
            'programStudi.not_in' => 'Pilih salah satu Program Studi',
            'nim.required' => 'NIM wajib diisi',
            'nim.min' => 'NIM harus terdiri dari minimal 9 karakter',
            'nim.max' => 'NIM tidak boleh lebih dari 9 karakter',
            'nama.required' => 'Nama mahasiswa wajib diisi',
            'tahunMasuk.required' => 'Tahun masuk wajib diisi',
        ]);

        $idPkm = Mahasiswa::where('nim', Auth::guard('pengusul')->user()->nim)->first()->id_pkm;
        try {
            DB::beginTransaction();

            if (Mahasiswa::where('nim', $request->input('nim'))->exists()) {
                throw new \Exception('Mahasiswa dengan NIM tersebut sudah terdaftar');
            }
            Mahasiswa::create([
                'nim' => $request->input('nim'),
                'nama' => $request->input('nama'),
                'angkatan' => $request->input('tahunMasuk'),
                'kode_prodi' => $request->input('programStudi'),
                'id_pkm' => $idPkm
            ]);
            DB::commit();
            session()->flash('success', 'Data berhasil disimpan');
            return redirect()->intended(route('pengusul.edit-usulan'));
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
            return redirect()->back()->withInput();
        } catch (\Throwable) {
            session()->flash('error', 'Something went wrong');
            return redirect()->back()->withInput();
        }
    }

    public function indexAnggota($id)
    {
        try {
            if (!$id) {
                return redirect()->back()
                    ->with('error', 'NIM Anggota tidak valid.');
            }

            $baseData = $this->getData();

            $anggota = Mahasiswa::findOrFail($id);
            $prodiAnggota = ProgramStudi::findOrFail($anggota->kode_prodi);

            $data = [
                'perguruanTinggi' => $baseData['perguruanTinggi'],
                'mahasiswa' => $baseData['mahasiswa'],
                'pkm' => $baseData['pkm'],
                'prodi' => ProgramStudi::where('kode_pt', $baseData['perguruanTinggi']->kode_pt)
                    ->orderBy('nama_prodi')
                    ->get(),
                'anggota' => $anggota,
                'prodiAnggota' => $prodiAnggota
            ];

            return view('pengusul.tambah-anggota', [
                'data' => $data,
                'isEdit' => true,
                'title' => 'Edit Anggota'
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()
                ->with('error', 'Data anggota tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memuat data anggota.');
        }
    }
    public function editAnggota(Request $request, $id)
    {
        $request->validate([
            'programStudi' => ['required', 'not_in:0'],
            'nim' => ['required', 'min:9', 'max:13'],
            'nama' => ['required'],
            'tahunMasuk' => ['required', 'not_in:0,'],
        ], [
            'programStudi.required' => 'Pilih Program Studi',
            'programStudi.not_in' => 'Pilih salah satu Program Studi',
            'nim.required' => 'NIM wajib diisi',
            'nim.min' => 'NIM harus terdiri dari minimal 9 karakter',
            'nim.max' => 'NIM tidak boleh lebih dari 9 karakter',
            'nama.required' => 'Nama mahasiswa wajib diisi',
            'tahunMasuk.required' => 'Tahun masuk wajib diisi',
        ]);
        $idPkm = Mahasiswa::where('nim', Auth::guard('pengusul')->user()->nim)->first()->id_pkm;
        try {
            DB::beginTransaction();
            if (Mahasiswa::where('nim', $request->input('nim'))->exists()) {
                throw new \Exception('Mahasiswa dengan NIM tersebut sudah terdaftar');
            }
            $anggota = Mahasiswa::findOrFail($id);
            $anggota->update([
                'nim' => $request->input('nim'),
                'nama' => $request->input('nama'),
                'angkatan' => $request->input('tahunMasuk'),
                'kode_prodi' => $request->input('programStudi'),
                'id_pkm' => $idPkm
            ]);
            DB::commit();
            session()->flash('success', 'Data berhasil disimpan');
            return redirect()->intended(route('pengusul.edit-usulan'));
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
            return redirect()->back()->withInput();
        } catch (\Throwable) {
            session()->flash('error', 'Something went wrong');
            return redirect()->back()->withInput();
        }
    }

    public function hapusAnggota($id)
    {
        try {
            DB::beginTransaction();
            $anggota = Mahasiswa::findOrFail($id);
            $anggota->delete();
            DB::commit();
            session()->flash('success', 'Data berhasil dihapus');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        } catch (\Throwable) {
            session()->flash('error', 'Something went wrong');
            return redirect()->back();
        }
    }
}

<?php

namespace App\Http\Controllers\Pengusul;

use Exception;
use App\Models\Dosen;
use App\Models\Pengusul;
use App\Models\SkemaPkm;
use App\Models\DetailPkm;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\LogbookKeuangan;
use App\Models\PerguruanTinggi;
use App\Http\Controllers\Controller;
use App\Models\LuaranPkm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
    public function createLaporanAkhir()
    {
        $data = $this->getData();

        return view('pengusul.pelaksanaan.laporan-akhir', ['data' => $data, 'title' => 'Laporan Akhir']);
    }

    public function storeFile(Request $request)
    {
        $request->validate([
            'laporanAkhir' => 'required|mimes:pdf|max:5120',

        ], [
            'laporanAkhir.required' => 'File Laporan Akhir wajib diunggah.',
            'laporanAkhir.mimes' => 'File Laporan Akhir harus berformat PDF.',
            'laporanAkhir.max' => 'File Laporan Akhir tidak boleh lebih dari 5 MB.',

        ]);
        $mahasiswa = Mahasiswa::where('nim', Auth::guard('pengusul')->user()->nim)->first();
        $pkm = DetailPkm::where('id', $mahasiswa->id_pkm)->first();
        if ($request->hasFile('laporanAkhir')) {
            // Simpan file di folder yang tepat
            $filePath = $request->file('laporanAkhir')->store('private/laporan-akhir');
            $pkm->update([
                'lapkhir' => $filePath,
            ]);
        }
        return redirect()->back()->with('success', 'File berhasil diupload!');
    }
    public function downloadLapkhir($id)
    {
        $pkm = DetailPkm::findOrFail($id);
        if (!$pkm->lapkhir) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }
        $filePath = storage_path('app/' . $pkm->lapkhir);
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }
        return response()->download($filePath, basename($pkm->lapkhir));
    }
    
    public function dashboardLogbookKeuangan()
    {
        $baseData = $this->getData();
        $pkm = $baseData['pkm'];

        $logbook_keuangan = LogbookKeuangan::where('id_pkm', $pkm->id)->get();

        $total_penggunaan = $logbook_keuangan->sum(function ($logbook) {
            return $logbook->harga * $logbook->jumlah;
        });

        $dana_total = $pkm->dana_kemdikbud + $pkm->dana_pt + $pkm->dana_lain;
        $sisa_dana = $dana_total - $total_penggunaan;

        $total_logbook = $logbook_keuangan->count();
        $validated_logbook = $logbook_keuangan->where('val_dospem', true)->count();

        $data = [
            'mahasiswa' => $baseData['mahasiswa'],
            'perguruanTinggi' => $baseData['perguruanTinggi'],
            'mahasiswas' => Mahasiswa::where('id_pkm', $pkm->id)->get(),
            'pkm' => $pkm,
            'prodi' => $baseData['prodi'],
            'skema' => SkemaPkm::where('id', $pkm->id_skema)->first(),
            'dospem' => Dosen::where('kode_dosen', $pkm->kode_dosen)->first(),
            'dana_total' => $dana_total,
            'total_penggunaan' => $total_penggunaan,
            'sisa_dana' => $sisa_dana,
            'logbook_keuangan' => $logbook_keuangan,
            'persentase_penggunaan' => ($total_penggunaan / $dana_total) * 100,
            'total_logbook' => $total_logbook,
            'validated_logbook' => $validated_logbook
        ];

        return view('pengusul.pelaksanaan.dashboard-logbook-keuangan', [
            'data' => $data,
            'title' => 'Dashboard Logbook Keuangan'
        ]);
    }

    public function formTambahLogbookKeuangan()
    {
        $baseData = $this->getData();
        $pkm = $baseData['pkm'];

        $logbook_keuangan = LogbookKeuangan::where('id_pkm', $pkm->id)->get();
        $total_penggunaan = $logbook_keuangan->sum(function ($logbook) {
            return $logbook->harga * $logbook->jumlah;
        });

        $dana_total = $pkm->dana_kemdikbud + $pkm->dana_pt + $pkm->dana_lain;
        $sisa_dana = $dana_total - $total_penggunaan;

        $data = [
            'pkm' => $pkm,
            'mahasiswa' => $baseData['mahasiswa'],
            'perguruanTinggi' => $baseData['perguruanTinggi'],
            'dana_total' => $dana_total,
            'total_penggunaan' => $total_penggunaan,
            'sisa_dana' => $sisa_dana
        ];

        return view('pengusul.pelaksanaan.form-logbook-keuangan', [
            'data' => $data,
            'title' => 'Tambah Logbook Keuangan'
        ]);
    }

    public function storeLogbookKeuangan(Request $request)
    {
        $baseData = $this->getData();
        $pkm = $baseData['pkm'];
        $dana_total = $pkm->dana_kemdikbud + $pkm->dana_pt + $pkm->dana_lain;
        
        $logbook_keuangan = LogbookKeuangan::where('id_pkm', $pkm->id)->get();
        $total_penggunaan = $logbook_keuangan->sum(function ($logbook) {
            return $logbook->harga * $logbook->jumlah;
        });
        $sisa_dana = $dana_total - $total_penggunaan;
        
        $jumlah = (int)str_replace(['Rp', '.', ' '], '', $request->jumlah);
        $harga = (int)str_replace(['Rp', '.', ' '], '', $request->harga);

        $request->validate([
            'tanggal' => [
                'required',
                'date_format:d-m-Y',
                function ($attribute, $value, $fail) {
                    $inputDate = \DateTime::createFromFormat('d-m-Y', $value);
                    $today = new \DateTime();

                    if ($inputDate > $today) {
                        $fail('Tanggal tidak boleh di masa depan');
                    }
                }
            ],
            'ket_item' => 'required|string',
            'harga' => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) use ($request, $jumlah, $sisa_dana) {
                    $harga = (int)str_replace(['Rp', '.', ' '], '', $request->harga);
                    $total = $harga * $jumlah;

                    if ($total > $sisa_dana) {
                        $fail('Total penggunaan dana (Rp. ' . number_format($total) . ') tidak boleh melebihi sisa dana Rp. ' . number_format($sisa_dana));
                    }
                }
            ],
            'jumlah' => [
                'required',
                'numeric',
                'min:1',
            ],
            'bukti' => [
                'required',
                'file',
                'max:2048',
                'mimes:pdf'
            ],
        ], [
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
            'jumlah.min' => 'Jumlah harus lebih dari 0',
            'harga.min' => 'Harga harus lebih dari 0',
            'bukti.mimes' => 'File bukti harus berupa PDF',
            'tanggal.date_format' => 'Format tanggal harus dalam format DD-MM-YYYY',
        ]);

        $tanggal_database = \DateTime::createFromFormat('d-m-Y', $request->tanggal)->format('Y-m-d');

        $extension = $request->file('bukti')->getClientOriginalExtension();
        $hashedFileName = hash('sha256', $request->file('bukti')->getClientOriginalName() . uniqid()) . '.' . $extension;

        $filePath = $request->file('bukti')->storeAs(
            'private/logbook_keuangan',
            $hashedFileName,
            'local'
        );

        LogbookKeuangan::create([
            'id_pkm' => $pkm->id,
            'tanggal' => $tanggal_database,
            'ket_item' => $request->ket_item,
            'harga' => $harga,
            'bukti' => $filePath,
            'val_dospem' => null,
            'jumlah' => $jumlah,
        ]);
        return redirect()->route('pengusul.dashboard-logbook-keuangan')->with('success', 'Logbook Keuangan berhasil disimpan');
    }

    public function hapusLogbookKeuangan($id)
    {
        $logbook = LogbookKeuangan::findOrFail($id);

        if ($logbook->val_dospem) {
            return back()->with('error', 'Logbook yang sudah divalidasi tidak dapat dihapus');
        }

        if (Storage::exists($logbook->bukti)) {
            Storage::delete($logbook->bukti);
        }

        $logbook->delete();

        return back()->with('success', 'Logbook keuangan berhasil dihapus');
    }

    public function editLogbookKeuangan($id)
    {
        $baseData = $this->getData();
        $pkm = $baseData['pkm'];

        $logbook = LogbookKeuangan::findOrFail($id);

        if ($logbook->val_dospem !== null) {
            return redirect()->route('pengusul.dashboard-logbook-keuangan')->with('error', 'Logbook tidak dapat diedit.');
        }

        $logbook->tanggal = \Carbon\Carbon::parse($logbook->tanggal)->format('d-m-Y');

        $logbook_keuangan = LogbookKeuangan::where('id_pkm', $pkm->id)->where('id', '!=', $id)->get();

        $total_penggunaan = $logbook_keuangan->sum(function ($item) {
            return $item->harga * $item->jumlah;
        });

        $dana_total = $pkm->dana_kemdikbud + $pkm->dana_pt + $pkm->dana_lain;

        $data = [
            'pkm' => $pkm,
            'mahasiswa' => $baseData['mahasiswa'],
            'perguruanTinggi' => $baseData['perguruanTinggi'],
            'dana_total' => $dana_total,
            'total_penggunaan' => $total_penggunaan,
            'sisa_dana' => $dana_total - $total_penggunaan,
            'logbook' => $logbook,
            'edit_mode' => true
        ];

        return view('pengusul.pelaksanaan.form-logbook-keuangan', [
            'data' => $data,
            'title' => 'Edit Logbook Keuangan'
        ]);
    }

    public function updateLogbookKeuangan(Request $request, $id)
    {
        $baseData = $this->getData();
        $pkm = $baseData['pkm'];
        $dana_total = $pkm->dana_kemdikbud + $pkm->dana_pt + $pkm->dana_lain;

        $logbook = LogbookKeuangan::findOrFail($id);

        if ($logbook->val_dospem !== null) {
            return redirect()->route('pengusul.dashboard-logbook-keuangan')->with('error', 'Logbook tidak dapat diedit.');
        }

        $total_penggunaan_sebelumnya = LogbookKeuangan::where('id_pkm', $pkm->id)->where('id', '!=', $id)->get()->sum(function ($item) {
            return $item->harga * $item->jumlah;
        });

        $jumlah = (int)str_replace(['Rp', '.', ' '], '', $request->jumlah);
        $harga = (int)str_replace(['Rp', '.', ' '], '', $request->harga);

        $request->validate([
            'tanggal' => [
                'required',
                'date_format:d-m-Y',
                function ($attribute, $value, $fail) {
                    $inputDate = \Carbon\Carbon::createFromFormat('d-m-Y', $value);
                    $today = \Carbon\Carbon::now();

                    if ($inputDate > $today) {
                        $fail('H');
                    }
                }
            ],
            'ket_item' => 'required|string',
            'harga' => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) use ($request, $jumlah, $dana_total, $total_penggunaan_sebelumnya) {
                    $harga = (int)str_replace(['Rp', '.', ' '], '', $request->harga);
                    $total = $harga * $jumlah;

                    $total_penggunaan_baru = $total_penggunaan_sebelumnya + $total;

                    if ($total_penggunaan_baru > $dana_total) {
                        $fail('Total penggunaan dana (Rp. ' . number_format($total_penggunaan_baru) . ') tidak boleh melebihi dana total Rp. ' . number_format($dana_total));
                    }
                }
            ],
            'jumlah' => [
                'required',
                'numeric',
                'min:1',
            ],
            'bukti' => [
                'required',
                'nullable',
                'file',
                'max:2048',
                'mimes:pdf'
            ],
        ], [
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'bukti.required' => 'Bukti harus diupdate',
            'jumlah.numeric' => 'Jumlah harus berupa angka',
            'jumlah.min' => 'Jumlah harus lebih dari 0',
            'harga.min' => 'Harga harus lebih dari 0',
            'bukti.mimes' => 'File bukti harus berupa PDF',
            'tanggal.date_format' => 'Format tanggal harus dalam format DD-MM-YYYY',
        ]);

        $tanggal_database = \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal)->format('Y-m-d');

        $logbook->tanggal = $tanggal_database;
        $logbook->ket_item = $request->ket_item;
        $logbook->harga = $harga;
        $logbook->jumlah = $jumlah;

        if ($request->hasFile('bukti')) {
            if ($logbook->bukti && Storage::exists($logbook->bukti)) {
                Storage::delete($logbook->bukti);
            }

            $extension = $request->file('bukti')->getClientOriginalExtension();
            $hashedFileName = hash('sha256', $request->file('bukti')->getClientOriginalName() . uniqid()) . '.' . $extension;

            $filePath = $request->file('bukti')->storeAs(
                'private/logbook_keuangan',
                $hashedFileName,
                'local'
            );

            $logbook->bukti = $filePath;
        }

        $logbook->save();

        return redirect()->route('pengusul.dashboard-logbook-keuangan')->with('success', 'Logbook Keuangan berhasil diperbarui');
    }

    public function downloadBukti($id)
    {
        try {
            $logbook = LogbookKeuangan::findOrFail($id);

            if (!Storage::exists($logbook->bukti)) {
                return back()->with('error', 'File bukti tidak ditemukan');
            }

            $filePath = storage_path('app/' . $logbook->bukti);

            $nim = Auth::guard('pengusul')->user()->nim;
            $mahasiswa = Mahasiswa::where('nim', $nim)->firstOrFail();

            if ($logbook->id_pkm !== $mahasiswa->id_pkm) {
                return back()->with('error', 'Anda tidak memiliki akses');
            }
            $safeFileName = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $logbook->original_filename);

            return response()->download(
                $filePath,
                $safeFileName,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . $safeFileName . '"'
                ]
            );
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Data tidak ditemukan');
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengunduh file');
        }
    }
}

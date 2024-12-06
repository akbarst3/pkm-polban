<?php

namespace App\Http\Controllers\Pengusul;

use Exception;
use App\Models\Dosen;
use App\Models\Pengusul;
use App\Models\SkemaPkm;
use App\Models\DetailPkm;
use App\Models\LuaranPkm;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\LogbookKegiatan;
use App\Models\LogbookKeuangan;
use App\Models\PerguruanTinggi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PelaksanaanController extends Controller
{
    public function getData()
    {
        $nim = Auth::guard('pengusul')->user()->nim;
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $pkm = DetailPkm::where('id', $mahasiswa->id_pkm)->with('skema')->first();
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
        return view('pengusul.pelaksanaan.dashboard-pelaksanaan', ['data' => $data, 'title' => 'Dashboard Pelaksanaan']);
    }

    public function createLbkeg() {
        $baseData = $this->getData();
        $capaian = LogbookKegiatan::where('id_pkm', $baseData['pkm']->id)->avg('capaian') ?? 0;
        $totalWaktu = LogbookKegiatan::where('id_pkm', $baseData['pkm']->id)->sum('waktu_pelaksanaan');;

        $data = [
            'pkm' => $baseData['pkm'],
            'capaian' => $capaian,
            'totalWaktu' => $totalWaktu,
            'perguruanTinggi' => $baseData['perguruanTinggi'],
            'mahasiswa' => $baseData['mahasiswa'],
            'mahasiswas' => Mahasiswa::where('id_pkm', $baseData['pkm']->id)->get(),
            'prodi' => $baseData['prodi'],
            'dospem' => Dosen::where('kode_dosen', $baseData['pkm']->kode_dosen)->first(),
            'logbook_kegiatan' => LogbookKegiatan::where('id_pkm', $baseData['pkm']->id)->get(),
        ];

        return view('pengusul.pelaksanaan.lb-kegiatan', ['data' => $data, 'title' => 'Logbook Kegiatan']);
    }

    public function formLbKeg() {
        return view('pengusul.pelaksanaan.form-lb-kegiatan');
    }

    public function storeLbKeg(Request $request){
        $request->validate([
            'tanggal' => 'required|date',
            'uraian' => 'required|string',
            'capaian' => 'required|numeric|between:0,100',
            'waktu' => 'required|numeric',
            'bukti' => 'required|file|mimes:pdf,jpg,jpeg,doc,docx|max:1024',
        ], [
            'tanggal.required' => 'Tanggal tidak boleh kosong',
            'tanggal.date' => 'Tanggal harus sesuai format',
            'uraian.required' => 'Uraian harus diisi',
            'uraian.string' => 'Uraian kegiatan harus berupa narasi',
            'capaian.required' => 'Capaian kegiatan harus diisi',
            'capaian.numeric' => 'Capaian kegiatan harus berupa angka (dalam %)',
            'capaian.between' => 'Capaian kegiatan harus berada dalam rentang 0-100%',
            'waktu.required' => 'Waktu kegiatan harus diisi',
            'waktu.numeric' => 'Waktu kegiatan harus berupa angka (dalam menit)',
            'bukti.required' => 'Bukti kegiatan harus diisi',
            'bukti.mimes' => 'Bukti kegiatan harus berupa pdf, jpg, jpeg, doc, atau docx',
            'bukti.max' => 'Bukti kegiatan tidak boleh lebih dari 1 MB',
        ]);
    
        ['pkm' => $pkm] = $this->getData();
    
        if ($request->hasFile('bukti')) {
            try {
                $file = $request->file('bukti');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('private/lb-kegiatan', $fileName);
    
                LogbookKegiatan::create([
                    'id_pkm' => $pkm->id,
                    'tanggal' => $request->tanggal,
                    'uraian' => $request->uraian,
                    'capaian' => $request->capaian,
                    'waktu_pelaksanaan' => $request->waktu,
                    'bukti' => 'private/lb-kegiatan/' . $fileName,
                ]);
    
                return redirect(route('pengusul.pelaksanaan.logbook-kegiatan.index'))->with('success', 'Logbook kegiatan berhasil disimpan');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal menyimpan logbook kegiatan' . $e->getMessage());
            }
        }
    }    

    public function editLbKeg($id) {
        $data['logbook'] = LogbookKegiatan::findOrFail($id);
        $data['edit_mode'] = true;
        return view('pengusul.pelaksanaan.form-lb-kegiatan', ['data' => $data]);
    }

    public function showFile($path)
    {
        if (!Storage::exists($path)) {
            return abort(404, 'File not found');
        }

        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg'
        ];

        $fileExtension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $contentType = $mimeTypes[$fileExtension] ?? 'application/octet-stream';

        return response()->stream(
            function () use ($path) {
                $fileStream = Storage::readStream($path);
                fpassthru($fileStream);
                if (is_resource($fileStream)) {
                    fclose($fileStream);
                }
            },
            200,
            [
                'Content-Type' => $contentType,
                'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
            ]
        );
    }

    public function updateLbKeg(Request $request, $id) {
        $request->validate([
            'tanggal' => 'required|date',
            'uraian' => 'required|string',
            'capaian' => 'required|numeric|between:0,100',
            'waktu' => 'required|numeric',
            'bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,doc,docx|max:1024',
        ], [
            'tanggal.required' => 'Tanggal tidak boleh kosong',
            'tanggal.date' => 'Tanggal harus sesuai format',
            'uraian.required' => 'Uraian harus diisi',
            'uraian.string' => 'Uraian kegiatan harus berupa narasi',
            'capaian.required' => 'Capaian kegiatan harus diisi',
            'capaian.numeric' => 'Capaian kegiatan harus berupa angka (dalam %)',
            'capaian.between' => 'Capaian kegiatan harus berada dalam rentang 0-100%',
            'waktu.required' => 'Waktu kegiatan harus diisi',
            'waktu.numeric' => 'Waktu kegiatan harus berupa angka (dalam menit)',
            'bukti.file' => 'Bukti kegiatan harus berupa file',
            'bukti.mimes' => 'Bukti kegiatan harus berupa pdf, jpg, jpeg, doc, atau docx',
            'bukti.max' => 'Bukti kegiatan tidak boleh lebih dari 1 MB',
        ]);

        try {
            $logbook = LogbookKegiatan::findOrFail($id);

            $dataToUpdate = [
                'tanggal' => $request->tanggal,
                'uraian' => $request->uraian,
                'capaian' => $request->capaian,
                'waktu_pelaksanaan' => $request->waktu,
            ];

            if ($request->hasFile('bukti')) {
                if ($logbook->bukti) {
                    Storage::delete($logbook->bukti);
                }

                $file = $request->file('bukti');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('private/lb-kegiatan', $fileName);
                $dataToUpdate['bukti'] = 'private/lb-kegiatan/' . $fileName;
            }
            $logbook->update($dataToUpdate);
            return redirect()->route('pengusul.pelaksanaan.logbook-kegiatan.index')->with('success', 'Logbook kegiatan berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal memperbarui logbook kegiatan: ' . $th->getMessage());
        }
    }

    public function downloadLbKeg($id) {
        $logbook = LogbookKegiatan::findOrFail($id);

        if (!$logbook->bukti) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }

        $filePath = storage_path('app/' . $logbook->bukti);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }

        return response()->download($filePath, basename($logbook->bukti));

    }

    public function deleteLbKeg($id) {
        $logbook = LogbookKegiatan::findOrFail($id);

        if (Storage::exists($logbook->bukti)) {
            Storage::delete($logbook->bukti);
        }

        $logbook->delete();

        return back()->with('success', 'Logbook keuangan berhasil dihapus');
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

    public function storeFile(Request $request, $id)
    {
        $request->validate([
            'laporanAkhir' => 'required|mimes:pdf|max:5120',

        ], [
            'laporanAkhir.required' => 'File Laporan Akhir wajib diunggah.',
            'laporanAkhir.mimes' => 'File Laporan Akhir harus berformat PDF.',
            'laporanAkhir.max' => 'File Laporan Akhir tidak boleh lebih dari 5 MB.',

        ]);
        $pkm = DetailPkm::findOrFail($id);
        if ($request->hasFile('laporanAkhir')) {
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
        return redirect()->route('pengusul.pelaksanaan.logbook-keuangan')->with('success', 'Logbook Keuangan berhasil disimpan');
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
            return redirect()->route('pengusul.pelaksanaan.logbook-keuangan')->with('error', 'Logbook tidak dapat diedit.');
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
            return redirect()->route('pengusul.pelaksanaan.logbook-keuangan')->with('error', 'Logbook tidak dapat diedit.');
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

        return redirect()->route('pengusul.pelaksanaan.logbook-keuangan')->with('success', 'Logbook Keuangan berhasil diperbarui');
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

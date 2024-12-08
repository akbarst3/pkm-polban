<?php

namespace App\Http\Controllers\Pengusul;

use Exception;
use App\Models\Dosen;
use App\Models\Pengusul;
use App\Models\SkemaPkm;
use App\Models\DetailPkm;
use App\Models\Mahasiswa;
use App\Models\TipeSosmed;
use App\Models\SosialMedia;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\LogbookKegiatan;
use App\Models\LogbookKeuangan;
use App\Models\PerguruanTinggi;
use Illuminate\Support\Facades\Log;
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

    public function createLbkeg()
    {
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

    public function formLbKeg()
    {
        return view('pengusul.pelaksanaan.form-lb-kegiatan');
    }

    public function storeLbKeg(Request $request)
    {
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

    public function editLbKeg($id)
    {
        $data['logbook'] = LogbookKegiatan::findOrFail($id);
        $data['edit_mode'] = true;
        return view('pengusul.pelaksanaan.form-lb-kegiatan', ['data' => $data]);
    }

    public function showFile($path)
    {
        if (!Storage::exists($path)) {
            return abort(404, 'File not found');
        }

        Log::info('File found: ' . $path);


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

    public function updateLbKeg(Request $request, $id)
    {
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

    public function downloadLbKeg($id)
    {
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

    public function deleteLbKeg($id)
    {
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

    public function createLuaranKemajuan()
    {
        $data = $this->getData();
        $data['pkm'] = DetailPkm::where('id', $data['pkm']->id)->with('sosmed.tipe')->first();

        $socialMediaData = [
            'Youtube' => ['icon' => 'bi-youtube', 'link' => null, 'followers' => null, 'posts' => null],
            'Instagram' => ['icon' => 'bi-instagram', 'link' => null, 'followers' => null, 'posts' => null],
            'Tiktok' => ['icon' => 'bi-tiktok', 'link' => null, 'followers' => null, 'posts' => null],
            'Facebook' => ['icon' => 'bi-facebook', 'link' => null, 'followers' => null, 'posts' => null]
        ];

        $sosmed = SosialMedia::where('id_pkm', $data['pkm']['id'])->with('tipe')->get();

        foreach ($sosmed as $item) {
            $name = $item->tipe->nama_sosmed;
            if (isset($socialMediaData[$name])) {
                $socialMediaData[$name] = [
                    'icon' => $socialMediaData[$name]['icon'],
                    'link' => $item->link_sosmed,
                    'followers' => $item->follower,
                    'posts' => $item->postingan
                ];
            }
        }

        $data['sosmed'] = $socialMediaData;

        return view('pengusul.pelaksanaan.luaran-kemajuan', ['data' => $data, 'title' => 'Luaran Kemajuan']);
    }

    public function createLuaranAkhir()
    {
        $data = $this->getData();
        $data['pkm'] = DetailPkm::where('id', $data['pkm']->id)->with('sosmed.tipe')->first();

        $socialMediaData = [
            'Youtube' => ['icon' => 'bi-youtube', 'link' => null, 'followers' => null, 'posts' => null],
            'Instagram' => ['icon' => 'bi-instagram', 'link' => null, 'followers' => null, 'posts' => null],
            'Tiktok' => ['icon' => 'bi-tiktok', 'link' => null, 'followers' => null, 'posts' => null],
            'Facebook' => ['icon' => 'bi-facebook', 'link' => null, 'followers' => null, 'posts' => null]
        ];

        $sosmed = SosialMedia::where('id_pkm', $data['pkm']['id'])->with('tipe')->get();

        foreach ($sosmed as $item) {
            $name = $item->tipe->nama_sosmed;
            if (isset($socialMediaData[$name])) {
                $socialMediaData[$name] = [
                    'icon' => $socialMediaData[$name]['icon'],
                    'link' => $item->link_sosmed,
                    'followers' => $item->follower,
                    'posts' => $item->postingan
                ];
            }
        }

        $data['sosmed'] = $socialMediaData;

        return view('pengusul.pelaksanaan.luaran-akhir', ['data' => $data, 'title' => 'Luaran Akhir']);
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

    public function createProfile()
    {
        ['mahasiswa' => $mahasiswa] = $this->getdata();
        $data = Mahasiswa::where('nim', $mahasiswa->nim)->with('pengusul')->first();
        return view('pengusul.pelaksanaan.profile', ['data' => $data, 'title' => 'Profile Pengusul']);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'no_ktp' => 'required|numeric',
            'email' => 'required|email',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string',
            'alamat' => 'required|string',
            'kota' => 'required|string',
            'kode_pos' => 'required|numeric',
            'no_hp' => 'required|numeric',
        ], [
            'foto_profil.image' => 'File harus berupa gambar.',
            'foto_profil.mimes' => 'Format gambar yang diizinkan hanya JPEG, PNG, dan JPG.',
            'foto_profil.max' => 'Ukuran gambar maksimal 2MB.',
            'no_ktp.required' => 'Nomor KTP harus diisi.',
            'no_ktp.numeric' => 'Nomor KTP harus berupa angka.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin harus berupa L atau P.',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi.',
            'tanggal_lahir.date' => 'Tanggal lahir harus berupa tanggal yang valid.',
            'tempat_lahir.required' => 'Tempat lahir harus diisi.',
            'alamat.required' => 'Alamat harus diisi.',
            'kota.required' => 'Kota harus diisi.',
            'kode_pos.required' => 'Kode pos harus diisi.',
            'kode_pos.numeric' => 'Kode pos harus berupa angka.',
            'no_hp.required' => 'Nomor ponsel harus diisi.',
            'no_hp.numeric' => 'Nomor ponsel harus berupa angka.',
        ]);


        $pengusul = Pengusul::where('nim', Auth::guard('pengusul')->user()->nim)->first();

        try {
            if ($request->hasFile('foto_profil')) {
                if ($pengusul->foto_profil) {
                    log::info('Foto Profil');
                    Storage::delete($pengusul->foto_profil);
                }
                $file = $request->file('foto_profil');
                $fileName = time() . '.' . $file->extension();
                $file->storeAs('private/foto-profil', $fileName);
                $pengusul->foto_profil = 'private/foto-profil/' . $fileName;
            }

            $pengusul->update([
                'no_ktp' => $request->no_ktp ?? $pengusul->no_ktp,
                'email' => $request->email ?? $pengusul->email,
                'jenis_kelamin' => $request->jenis_kelamin ?? $pengusul->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir ?? $pengusul->tanggal_lahir,
                'tempat_lahir' => $request->tempat_lahir ?? $pengusul->tempat_lahir,
                'alamat' => $request->alamat ?? $pengusul->alamat,
                'kota' => $request->kota ?? $pengusul->kota,
                'kode_pos' => $request->kode_pos ?? $pengusul->kode_pos,
                'no_hp' => $request->no_hp ?? $pengusul->no_hp,
                'telp_rumah' => $request->telp_rumah ?? $pengusul->telp_rumah,
            ]);

            return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function openPhoto($path)
    {
        Log::info('Requested photo path: ' . $path);

        if (empty($path)) {
            Log::error('Empty photo path');
            return abort(404, 'Path is empty');
        }

        if (!Storage::exists($path)) {
            Log::error('File not found: ' . $path);
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

    public function storeSocialMedia(Request $request)
    {
        try {
            $request->validate([
                'youtube' => [
                    'nullable',
                    'url',
                    'required_with:youtube_followers,youtube_posts'
                ],
                'youtube_followers' => 'nullable|numeric|min:0',
                'youtube_posts' => 'nullable|numeric|min:0',

                'instagram' => [
                    'nullable',
                    'url',
                    'required_with:instagram_followers,instagram_posts'
                ],
                'instagram_followers' => 'nullable|numeric|min:0',
                'instagram_posts' => 'nullable|numeric|min:0',

                'facebook' => [
                    'nullable',
                    'url',
                    'required_with:facebook_followers,facebook_posts'
                ],
                'facebook_followers' => 'nullable|numeric|min:0',
                'facebook_posts' => 'nullable|numeric|min:0',

                'tiktok' => [
                    'nullable',
                    'url',
                    'required_with:tiktok_followers,tiktok_posts'
                ],
                'tiktok_followers' => 'nullable|numeric|min:0',
                'tiktok_posts' => 'nullable|numeric|min:0'
            ], [
                'youtube.required_with' => 'URL YouTube harus diisi jika followers atau posts diisi',
                'instagram.required_with' => 'URL Instagram harus diisi jika followers atau posts diisi',
                'facebook.required_with' => 'URL Facebook harus diisi jika followers atau posts diisi',
                'tiktok.required_with' => 'URL TikTok harus diisi jika followers atau posts diisi'
            ]);

            ['pkm' => $pkm] = $this->getData();
            $id_pkm = $pkm->id;

            $socialMediaTypes = TipeSosmed::pluck('id', 'nama_sosmed')->toArray();

            $fieldMapping = [
                'youtube' => 'YouTube',
                'instagram' => 'Instagram',
                'facebook' => 'Facebook',
                'tiktok' => 'TikTok'
            ];

            foreach ($fieldMapping as $field => $sosmedName) {
                $sosmedTypeId = null;
                foreach ($socialMediaTypes as $key => $value) {
                    if (strtolower($key) === strtolower($sosmedName)) {
                        $sosmedTypeId = $value;
                        break;
                    }
                }

                if ($sosmedTypeId === null) {
                    continue;
                }

                if ($request->filled($field)) {
                    $socialMediaData = [
                        'id_pkm' => $id_pkm,
                        'id_sosmed' => $sosmedTypeId,
                        'link_sosmed' => $request->input($field),
                        'follower' => $request->filled($field . '_followers') ? $request->input($field . '_followers') : null,
                        'postingan' => $request->filled($field . '_posts') ? $request->input($field . '_posts') : null
                    ];

                    $existingSocialMedia = SosialMedia::where('id_pkm', $id_pkm)->where('id_sosmed', $sosmedTypeId)->first();

                    if ($existingSocialMedia) {
                        $existingSocialMedia->update($socialMediaData);
                    } else {
                        SosialMedia::create($socialMediaData);
                    }
                }
            }
            return redirect()->back()->with('success', 'Data sosial media berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateSocialMedia(Request $request)
    {
        try {
            $request->validate([
                'youtube' => [
                    'nullable',
                    'url',
                    'required_with:youtube_followers,youtube_posts'
                ],
                'youtube_followers' => 'nullable|numeric|min:0',
                'youtube_posts' => 'nullable|numeric|min:0',

                'instagram' => [
                    'nullable',
                    'url',
                    'required_with:instagram_followers,instagram_posts'
                ],
                'instagram_followers' => 'nullable|numeric|min:0',
                'instagram_posts' => 'nullable|numeric|min:0',

                'facebook' => [
                    'nullable',
                    'url',
                    'required_with:facebook_followers,facebook_posts'
                ],
                'facebook_followers' => 'nullable|numeric|min:0',
                'facebook_posts' => 'nullable|numeric|min:0',

                'tiktok' => [
                    'nullable',
                    'url',
                    'required_with:tiktok_followers,tiktok_posts'
                ],
                'tiktok_followers' => 'nullable|numeric|min:0',
                'tiktok_posts' => 'nullable|numeric|min:0'
            ], [
                'youtube.required_with' => 'URL YouTube harus diisi jika followers atau posts diisi',
                'instagram.required_with' => 'URL Instagram harus diisi jika followers atau posts diisi',
                'facebook.required_with' => 'URL Facebook harus diisi jika followers atau posts diisi',
                'tiktok.required_with' => 'URL TikTok harus diisi jika followers atau posts diisi'
            ]);

            ['pkm' => $pkm] = $this->getData();
            $id_pkm = $pkm->id;

            $socialMediaTypes = TipeSosmed::pluck('id', 'nama_sosmed')->toArray();

            $fieldMapping = [
                'youtube' => 'YouTube',
                'instagram' => 'Instagram',
                'facebook' => 'Facebook',
                'tiktok' => 'TikTok'
            ];

            foreach ($fieldMapping as $field => $sosmedName) {
                $sosmedTypeId = null;
                foreach ($socialMediaTypes as $key => $value) {
                    if (strtolower($key) === strtolower($sosmedName)) {
                        $sosmedTypeId = $value;
                        break;
                    }
                }

                if ($sosmedTypeId === null) {
                    continue;
                }

                $existingSocialMedia = SosialMedia::where('id_pkm', $id_pkm)->where('id_sosmed', $sosmedTypeId)->first();

                if ($request->filled($field)) {
                    $socialMediaData = [
                        'link_sosmed' => $request->input($field),
                        'follower' => $request->filled($field . '_followers') ? $request->input($field . '_followers') : null,
                        'postingan' => $request->filled($field . '_posts') ? $request->input($field . '_posts') : null
                    ];

                    if ($existingSocialMedia) {
                        $existingSocialMedia->update($socialMediaData);
                    }
                }
            }

            return redirect()->back()->with('success', 'Data sosial media berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

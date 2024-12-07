@extends('pengusul/pelaksanaan/master')

@section('konten')
    <div class="container mt-4">
        <!-- Header Section -->
        <div class="card shadow rounded ps-4 pt-3 pb-0 mb-3 fw-bold">
            <p>Laporan Akhir</p>
        </div>

        <!-- Title Section -->
        <div class="card shadow rounded ps-4 pt-2 fw-bold pe-4 pb-1">
            <p class="card-title">{{ $data['pkm']->judul }}</p>
        </div>

        <!-- Form Section -->
        <div class="card shadow rounded p-4">
            <div class="row ps-4 pb-1 pt-3 pe-4">
                <!-- Kolom Skema dan Tahun -->
                <div class="col-md-4 mb-0 ps-4">
                    <div class="col-md-6">
                        <strong>Skema:</strong> <br>{{ $data['skema']->nama_skema }}
                    </div>
                    <div class="col-md-6 pt-3">
                        <strong>Tahun:</strong> <br>{{ $data['pkm']->created_at->year }}
                    </div>
                </div>

                <!-- Kolom Dana Disetujui dan Status Upload -->
                <div class="col-md-4 mb-0 ps-4">
                    <div class="col-md-6">
                        <strong>Dana Disetujui (Rp):</strong> <br>
                        @if ($data['totalDana'] > 0)
                            <span>Rp {{ number_format($data['totalDana']) }}</span>
                        @else
                            <span>-</span>
                        @endif
                    </div>
                    <div class="col-md-10 pt-3">
                        <strong>Status Upload:</strong> <br>
                        <div class="d-flex align-items-center">
                            @if (!is_null($data['pkm']->lapkhir))
                                <span
                                    class="text-success text-nowrap me-1"><strong>Sudah Upload</strong></span>
                                <a href="{{ route('pengusul.pelaksanaan.lap-kemajuan.downloadFile', ['id' => $data['pkm']->id]) }}"
                                    class="btn btn-success btn-sm">Download</a>
                            @else
                                <span class="text-danger text-nowrap"><strong>Belum Upload</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Kolom Status Validasi Dosen -->
                <div class="col-md-4 mb-0 ps-4">
                    <div class="col-md-6">
                        <strong>Status Validasi Dosen:</strong> <br>
                        @if ($data['valDospem'] == 1)
                            <span class="text-success"><strong>Disetujui</strong></span>
                        @else
                            <span class="text-danger"><strong>Belum disetujui</strong></span>
                        @endif
                    </div>

                    <!-- Input File -->
                    <div class="col-md-10 pt-3">
                        @if (is_null($data['pkm']->lapkhir))
                            <form action="{{ route('pengusul.pelaksanaan.upload-lapkhir', $data['pkm']->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="input-group ps-1">
                                    <input type="file" name="laporanAkhir" class="form-control form-control-sm w-50" required>
                                    <button type="submit" class="btn btn-primary btn-sm">Upload</button>
                                </div>
                                @if ($errors->has('lapkem'))
                                    <div class="alert alert-danger mt-2">
                                        <ul>
                                            @foreach ($errors->get('lapkem') as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Detailed Information Section -->
            <div class="mt-4">
                <div class="row g-3">
                    <!-- Perguruan Tinggi -->
                    <div class="col-md-4">
                        <div class="bg-warning p-3 rounded text-white shadow h-100">
                            <strong style=>Perguruan Tinggi</strong>
                            <span
                                style="line-height: 2; margin: 0; padding: 0; display: block;">{{ $data['perguruanTinggi']->nama_pt }}</span>
                        </div>
                    </div>

                    <!-- Ketua -->
                    <div class="col-md-4">
                        <div class="bg-success p-3 rounded text-white shadow h-100">
                            <strong style=>Ketua</strong>
                            <span
                                style="line-height: 2; margin: 0; padding: 0; display: block;">{{ $data['mahasiswa']->nama }}
                                - {{ $data['mahasiswa']->nim }}</span>
                            <p>{{ $data['prodi']->nama_prodi }} - {{ $data['prodi']->kode_prodi }}</p>
                            <p><strong>Kelompok:</strong></p>
                            <ul>
                                @foreach ($data['anggota'] as $anggota)
                                    <li>{{ $anggota->nama }} - {{ $anggota->nim }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Dosen -->
                    <div class="col-md-4">
                        <div class="bg-primary p-3 rounded text-white shadow h-100">
                            <strong style=>Dosen</strong>
                            <span
                                style="line-height: 2; margin: 0; padding: 0; display: block;">{{ $data['dosen']->nama }}</span>
                            <p>{{ $data['dosen']->kode_dosen }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

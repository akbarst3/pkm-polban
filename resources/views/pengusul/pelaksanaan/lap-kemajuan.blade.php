@extends('pengusul/pelaksanaan/master')
@section('konten')
    <div class="container mt-2 ">
        <div class="card shadow-sm ps-3 pt-3 pb-0 mb-3 mt-0 fw-bold">
            <p class="">Laporan Kemajuan</p>
        </div>
        {{-- <div class="alert alert-danger">
            Upload Laporan Kemajuan dimulai pada tanggal <strong>19 Juli 2024</strong>, berakhir pada <strong>04 Agustus 2024</strong>
        </div> --}}
        <div class="card shadow-sm ps-3 pt-1 pb-1 fw-bold pe-3">
            <p class="card-title ">{{ $data['pkm']->judul }}</p>
        </div>
        <div class="card shadow rounded">
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
                            @if ($data['statusUpload'] === 'Sudah diupload')
                                <span
                                    class="text-success text-nowrap me-1"><strong>{{ $data['statusUpload'] }}</strong></span>
                                <a href="{{ route('pengusul.pelaksanaan.lap-kemajuan.downloadFile', ['id' => $data['pkm']->id]) }}"
                                    class="btn btn-success btn-sm">Download</a>
                            @else
                                <span class="text-danger text-nowrap"><strong>{{ $data['statusUpload'] }}</strong></span>
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
                        @if ($data['statusUpload'] != 'Sudah diupload')

                            <form action="{{ route('pengusul.pelaksanaan.lap-kemajuan.uploadFile') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="input-group ps-1">
                                    <input type="file" name="lapkem" class="form-control form-control-sm w-50" required>
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

            <div class="row ps-4 pe-4 pb-2 pt-1">
                <div class="col-md-4">
                    <div class="bg-warning p-3 rounded text-white shadow h-100">
                        <strong style=>Perguruan Tinggi</strong>
                        <span
                            style="line-height: 2; margin: 0; padding: 0; display: block;">{{ $data['perguruanTinggi']->nama_pt }}</span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="bg-success rounded p-3 text-white shadow h-100">
                        <strong style=>Ketua</strong>
                        <span style="line-height: 2; margin: 0; padding: 0; display: block;">{{ $data['mahasiswa']->nama }}
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
                <div class="col-md-4 d-flex">
                    <div class="card bg-primary text-white w-100">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">Dosen</h6>
                            <span
                                style="line-height: 2; margin: 0; padding: 0; display: block;">{{ $data['dosen']->nama }}</span>
                            <p>{{ $data['dosen']->kode_dosen }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection

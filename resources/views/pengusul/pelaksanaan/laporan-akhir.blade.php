@extends('pengusul/pelaksanaan/master')

@section('konten')
    <div class="container mt-4">
        <!-- Header Section -->
        <div class="card shadow-sm ps-4 pt-3 pb-0 mb-3 fw-bold">
            <p>Laporan Akhir</p>
        </div>

        <!-- Title Section -->
        <div class="card shadow-sm ps-4 pt-2 fw-bold pe-4 pb-1">
            <p class="card-title">{{ $data['pkm']->judul }}</p>
        </div>

        <!-- Form Section -->
        <div class="card shadow-sm p-4">
            <form action="{{ route('pengusul.upload-lapkhir') }}" method="POST" class="needs-validation" novalidate
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="row">
                    <!-- Column 1: Scheme Information -->
                    <div class="col-md-4">
                        <h6 class="fw-bold">Skema</h6>
                        <p>{{ $data['skema']->nama_skema }}</p>
                        <h6 class="fw-bold">Tahun</h6>
                        <p>{{ $data['pkm']->created_at->year }}</p>
                    </div>

                    <!-- Column 2: Funding and Upload Status -->
                    <div class="col-md-4 d-flex flex-column">
                        <h6 class="fw-bold">Dana Disetujui (Rp)</h6>
                         @if ($data['totalDana'] > 0)
                            <span>Rp {{ number_format($data['totalDana'], 0, ',', '.') }}</span>
                        @else
                            <span>-</span>
                        @endif

                        @if ($data['pkm']->lapkhir ?? false)
                            <div class="mt-4 d-flex align-items-center">
                                <p class="text-success mb-0"><strong>Sudah diupload</strong></p>
                                <a href="{{ route('pengusul.laporan-akhir.downloadLapkhir', ['id' => $data['pkm']->id]) }}" class="btn btn-success btn-sm ms-auto" target="_blank">Download</a>
                            </div>
                        @else
                            <div class="mb-3">
                                <label for="laporanAkhir" class="form-label">Upload Laporan Akhir (PDF)</label>
                                <input type="file" class="form-control w-50" id="laporanAkhir" name="laporanAkhir" required>
                                <div class="invalid-feedback">File ini wajib diisi</div>
                                @error('laporanAkhir')
                                    <small class="text-danger">{{ $message }}</small><br>
                                @enderror
                                <small class="form-text text-muted">Hanya file PDF dengan ukuran maksimal 5MB</small>
                            </div>
                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        @endif
                    </div>

                    <!-- Column 3: Validation Status -->
                    <div class="col-md-4">
                        <h6 class="fw-bold">Status Validasi Dosen</h6>
                        @if ($data['valDospem']== 1)
                            <span class="text-success"><strong>Disetujui</strong></span>
                        @else
                            <span class="text-danger"><strong>Belum disetujui</strong></span>
                        @endif
                    </div>
                </div>

                <!-- Detailed Information Section -->
                <div class="mt-4">
                    <div class="row g-3">
                        <!-- Perguruan Tinggi -->
                        <div class="col-md-4">
                            <div class="bg-warning p-3 rounded text-white shadow h-100">
                                <strong style=>Perguruan Tinggi</strong>
                                <span style="line-height: 2; margin: 0; padding: 0; display: block;">{{ $data['perguruanTinggi']->nama_pt }}</span>
                            </div>
                        </div>

                        <!-- Ketua -->
                        <div class="col-md-4">
                            <div class="bg-success p-3 rounded text-white shadow h-100">
                                <strong style=>Ketua</strong>
                                <span style="line-height: 2; margin: 0; padding: 0; display: block;">{{ $data['mahasiswa']->nama }} - {{ $data['mahasiswa']->nim }}</span>
                                <p>{{ $data['prodi']->nama_prodi }} - {{ $data['prodi']->kode_prodi }}</p>
                                <p><strong>Kelompok:</strong></p>
                                <ul>
                                    @foreach ($data['anggota'] as $anggota)
                                        <li>{{ $anggota->nama }} - {{ $anggota->nim}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Dosen -->
                        <div class="col-md-4">
                            <div class="bg-primary p-3 rounded text-white shadow h-100">
                                <strong style=>Dosen</strong>
                                <span style="line-height: 2; margin: 0; padding: 0; display: block;">{{ $data['dosen']->nama }}</span>
                                <p>{{ $data['dosen']->kode_dosen }}</p>
                            </div>
                        </div>
                       </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
@endsection

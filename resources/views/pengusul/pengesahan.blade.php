@extends('pengusul/master')

@section('konten')
<div class="container-fluid mt-3 px-5">
    <h5>Pengisian Identitas Mahasiswa Pengusul PKM</h5>
    
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header bg-primary text-white">
            PENGESAHAN USULAN PKM {{ strtoupper($viewData['skemaPkm']) }}
        </div>
        <div class="card-body">
            <form action="{{ route('pengusul.pengesahan.store') }}" method="POST">
                @csrf

                <!-- 1. Judul Kegiatan -->
                <div class="mb-3">
                    <label><strong>1. Judul Kegiatan</strong></label>
                    <p>{{ $viewData['judulPkm'] }}</p>
                </div>

                <!-- 2. Bidang Kegiatan -->
                <div class="mb-3">
                    <label><strong>2. Bidang Kegiatan</strong></label>
                    <p>{{ $viewData['skemaPkm'] }}</p>
                </div>

                <!-- 3. Ketua Pelaksana -->
                <div class="mb-3">
                    <label><strong>3. Ketua Pelaksana</strong></label>
                    <ul class="list-unstyled">
                        <li>Nama Lengkap: {{ $viewData['namaPengusul'] }}</li>
                        <li>NIM: {{ $viewData['nimPengusul'] }}</li>
                        <li>Program Studi: {{ $viewData['namaProdi'] }}</li>
                        <li>Perguruan Tinggi: {{ $viewData['namaPt'] }}</li>
                        <li>Alamat Rumah dan No. HP: {{ $viewData['alamatPengusul'] }} / {{ $viewData['noHpPengusul'] }}</li>
                        <li>Email: {{ $viewData['emailPengusul'] }}</li>
                    </ul>
                </div>

                <!-- 4. Jumlah Anggota -->
                <div class="mb-3">
                    <label><strong>4. Jumlah Anggota</strong></label>
                    <p>{{ $viewData['anggota'] }} Orang</p>
                </div>

                <!-- 5. Dosen Pendamping -->
                <div class="mb-3">
                    <label><strong>5. Dosen Pendamping</strong></label>
                    <ul class="list-unstyled">
                        <li>Nama Lengkap: {{ $viewData['namaDospem'] }}</li>
                        <li>NIDN: {{ $viewData['nidn'] }}</li>
                        <li>No. HP: {{ $viewData['noHpDospem'] }}</li>
                    </ul>
                </div>

                <!-- 6. Biaya Kegiatan -->
                <div class="mb-3">
                    <label><strong>6. Biaya Kegiatan</strong></label>
                    <ul class="list-unstyled">
                        <li>Dana Kemendikbud: Rp{{ number_format($viewData['danaKemdikbud'], 0, ',', '.') }}</li>
                        <li>Dana PT: Rp{{ number_format($viewData['danaPt'], 0, ',', '.') }}</li>
                        <li>Dana Lain: Rp{{ number_format($viewData['danaLain'], 0, ',', '.') }}</li>
                    </ul>
                </div>

                <!-- Form Pengesahan -->
                <div class="mb-3">
                    <label><strong>Kota Pengesahan</strong></label>
                    <input type="text" class="form-control @error('kota_pengesahan') is-invalid @enderror" 
                           name="kota_pengesahan" 
                           value="{{ old('kota_pengesahan', $viewData['pengesahan']->kota_pengesahan ?? '') }}">
                    @error('kota_pengesahan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label><strong>Waktu Pelaksanaan (bulan)</strong></label>
                    <input type="number" class="form-control @error('waktu_pelaksanaan') is-invalid @enderror" 
                           name="waktu_pelaksanaan" 
                           value="{{ old('waktu_pelaksanaan', $viewData['pengesahan']->waktu_pelaksanaan ?? '') }}">
                    @error('waktu_pelaksanaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label><strong>Nama Pengesahan</strong></label>
                    <input type="text" class="form-control @error('nama_pengesahan') is-invalid @enderror" 
                           name="nama_pengesahan" 
                           value="{{ old('nama_pengesahan', $viewData['pengesahan']->nama ?? '') }}">
                    @error('nama_pengesahan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label><strong>Jabatan</strong></label>
                    <input type="text" class="form-control @error('jabatan') is-invalid @enderror" 
                           name="jabatan" 
                           value="{{ old('jabatan', $viewData['pengesahan']->jabatan ?? '') }}">
                    @error('jabatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label><strong>NIP</strong></label>
                    <input type="text" class="form-control @error('NIP') is-invalid @enderror" 
                           name="NIP" 
                           value="{{ old('NIP', $viewData['pengesahan']->NIP ?? '') }}">
                    @error('NIP')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Simpan Pengesahan</button>
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">Kembali</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
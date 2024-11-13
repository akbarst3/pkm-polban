@extends('dospem/master')
@section('konten')
    <div class="container my-4">
        <h4>Data Pembimbingan Usulan Proposal PKM</h4>

        <!-- Filter Tahun -->
        <div class="d-flex align-items-center mb-3">
            <label class="me-2" for="yearSelect">Tahun:</label>
            <select id="yearSelect" class="form-select form-select-sm w-auto me-2">
                <option selected>2024</option>
                <option>2023</option>
            </select>
        </div>

        <!-- Data Usulan -->
        <div class="card p-4">
            <h5 class="text">Data Usulan</h5>
            <h6 class="text-center">Apakah Proposal Berikut Ini Akan Disetujui?</h6>
            <div class="row my-3">
                <div class="col-2 text-end"><strong>Judul</strong></div>
                <div class="col-8">{{ $judul }}</div>
            </div>
            <div class="row my-2">
                <div class="col-2 text-end"><strong>Skema</strong></div>
                <div class="col-8">{{ $skema }}</div>
            </div>
            <div class="row my-2">
                <div class="col-2 text-end"><strong>Ketua</strong></div>
                <div class="col-8">{{ $nama }}</div>
            </div>
            <div class="row my-2">
                <div class="col-2 text-end"><strong>NIM</strong></div>
                <div class="col-8">{{ $nim }}</div>
            </div>
            <div class="row my-2">
                <div class="col-2 text-end"><strong>Program Studi</strong></div>
                <div class="col-8">{{ $namaProdi }}</div>
            </div>
            <div class="row my-2">
                <div class="col-2 text-end"><strong>Dosen Pembimbing</strong></div>
                <div class="col-8">{{ $namaDospem }}</div>
            </div>
            <div class="row my-2">
                <div class="col-2 text-end"><strong>NIDN</strong></div>
                <div class="col-8">{{ $nidn }}</div>
            </div>

            <!-- Status Validasi Dosen -->
            <div class="row my-2">
                <div class="col-2 text-end"><strong>Status Validasi Dosen</strong></div>
                <div class="col-8">
                    <span id="statusBadge"
                        class="badge {{ $status == 1 ? 'bg-success' : ($status == 0 ? 'bg-warning text-dark' : 'bg-secondary') }}">
                        {{ $status == 1 ? 'Disetujui' : ($status == 0 ? 'Ditolak' : 'Belum Diproses') }}
                    </span>
                </div>
            </div>

            <!-- Aksi Tombol -->
            <div class="row mt-4">
                <div class="col-4 text-end">
                    <a href="{{ route('dospem.proposal') }}" class="btn btn-outline-secondary">Kembali</a>
                    <form action="{{ route('dospem.validate') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="pkm_id" value="{{ $pkm_id }}">
                        <button type="submit" name="val_dospem" value="1"
                            class="btn btn-success mx-2">Setujui</button>
                        <button type="submit" name="val_dospem" value="0" class="btn btn-danger">Tolak</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

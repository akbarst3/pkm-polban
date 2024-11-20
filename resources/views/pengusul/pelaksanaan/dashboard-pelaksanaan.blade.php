@extends('pengusul/pelaksanaan/master')
    @section('konten')
    <div class="container my-4">
        <div class="card shadow-sm p-4">
            <h2 class="text-primary">SELAMAT DATANG, {{ $data['mahasiswa']->nama }}</h2>
            <p>Anda sedang login di role <strong>Pengusul - Mahasiswa</strong></p>
        </div>
    </div>

        <!-- Informasi Utama -->
        <div class="container my-1">
            <div class="card shadow-sm p-4">
                <h6>{{ $data['pkm']->judul }} </h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Skema:</strong> <br>{{ $data['skema']->nama_skema }}
                        </div>
                        <div class="col-md-6">
                            <strong>Tahun:</strong> <br>{{ $data['pkm']->created_at->year }}

                        </div>
            </div>
            <!-- Informasi Detail -->
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
            </div>


            <!-- Tombol Kembali -->
            <div class="mt-4 text-end">
                <a href="{{ route('pengusul.dashboard') }}" class="btn btn-secondary">Kembali</a>
            </div>

        </div>
    </div>
    @endsection

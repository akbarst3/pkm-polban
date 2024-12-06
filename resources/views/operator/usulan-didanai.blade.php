@extends('operator/master')

@section('konten')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ $perguruanTinggi->nama_pt }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="p-4 bg-white rounded shadow">
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5>USULAN DIDANAI</h5>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Kolom Utama -->
                        <div class="col-md-5 mb-4">
                            <!-- Kolom Kiri Berbasis Baris -->
                            <div class="row mb-4">
                                <div class="col-md-9 text-end">
                                    <p>Tahun Pelaksanaan</p>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="tahun-pelaksanaan" class="form-control" disabled
                                        value="2024">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-9 text-end">
                                    <p>Klaster</p>
                                </div>
                                <div class="col-md-3">
                                    <div class="w-70 text-center" style="background-color: #58afdd; color: white;">
                                        KLASTER 1
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-6 mb-3">
                            <div class="row align-items-center">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <p class="mb-0 text-end">PKM 8 Bidang yang Didanai</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p>{{ $data['pkm8bidang'] }}</p>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <p class="mb-0 text-end">PKM Artikel Ilmiah yang Didanai</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p>{{ $data['pkmAi'] }}</p>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <p class="mb-0 text-end">PKM Gagasan Futuristik yang Didanai</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p>{{ $data['pkmGft'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">No.</th>
                                        <th style="width: 15%;">Skema</th>
                                        <th style="width: 50%;">Judul</th>
                                        <th style="width: 30%;">Nama Ketua</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['pkm'] as $index => $pkm)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $pkm->skema->nama_skema }}</td>
                                            <td>{{ $pkm->judul }}</td>
                                            <td>{{ $pkm->mahasiswa->nama }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

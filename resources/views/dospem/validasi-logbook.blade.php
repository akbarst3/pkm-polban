@extends('dospem/master')

@section('konten')
    <div class="container my-4">
        <h5>Data Usulan Proposal PKM</h5>

        <!-- Filter Tahun -->
        <div class="d-flex align-items-center mb-3">
            <label class="me-2" for="yearSelect">Tahun:</label>
            <button class="btn btn-light border me-2" id="yearSelect">2024</button>
        </div>

        <!-- Table -->
        <div class="card shadow-sm p-4">
            <h5>Daftar Usulan</h5>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center align-middle">No.</th>
                            <th class="text-center align-middle">Pengusul</th>
                            <th class="text-center align-middle">Judul</th>
                            <th class="text-center align-middle">Skema</th>
                            <th class="text-center align-middle">Validasi Logbook</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['pkms'] as $index => $pkm)
                            <tr>
                                <td class="text-center align-middle">{{ $index + 1 }}</td>
                                <td class="text-center align-middle">{{ $pkm->mahasiswa->nama }}</td>
                                <td class="text-center align-middle">
                                    {{ $pkm->judul }}<br>
                                </td>
                                <td class="text-center align-middle">{{ $pkm['skema']->nama_skema }}</td>
                                <td class="text-center align-middle">
                                    <a class="btn btn-secondary mx-4" href="{{ route('dosen-pendamping.validasi-logbook.logbook-kegiatan', $pkm->id) }}">Logbook Kegiatan</a>
                                    <a class="btn btn-secondary mx-4" href="{{ route('dosen-pendamping.validasi-logbook.logbook-keuangan', $pkm->id) }}">Logbook Keuangan</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

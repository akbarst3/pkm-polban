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
        <div class="card shadow rounded p-4">
            <h5>Daftar Usulan</h5>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center align-middle" style="width: 2%">No.</th>
                            <th class="text-center align-middle" style="width: 10%">Pengusul</th>
                            <th class="text-center align-middle" style="width: 50%">Judul</th>
                            <th class="text-center align-middle" style="width: 10%">Skema</th>
                            <th class="text-center align-middle" style="width: 30%">Validasi Logbook</th>
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
                                <td class="text-center align-middle d-flex justify-content-center align-items-center"
                                    style="height: 100px;">
                                    <a class="btn btn-secondary me-2"
                                        href="{{ route('dosen-pendamping.validasi-logbook.logbook-kegiatan', $pkm->id) }}" title="Logbook Kegiatan">
                                        <i class="bi bi-journal-check"></i>
                                    </a>
                                    <a class="btn btn-secondary"
                                        href="{{ route('dosen-pendamping.validasi-logbook.logbook-keuangan', $pkm->id) }}" title="Logbook Keuangan">
                                        <i class="bi bi-receipt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

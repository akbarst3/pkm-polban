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
                            <th>No.</th>
                            <th>Pengusul</th>
                            <th>Judul</th>
                            <th>Skema</th>
                            <th>Proposal</th>
                            <th>Pengesahan</th>
                            <th>Validasi Dosen Pendamping</th>
                            <th>Validasi Pimpinan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengusuls as $index => $pengusul)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pengusul->nama }}</td>
                                <td>
                                    {{ $pkms[$index]->judul ?? 'Judul tidak tersedia' }}<br>
                                    <small>Pendamping: {{ $nameDospems[$index] ?? 'Belum ditentukan' }}</small><br>
                                    <small>({{ $kodeDospems[$index] ?? 'Belum ditentukan' }})</small>
                                </td>
                                <td>{{ $skemas[$index] ?? 'Tidak ada skema' }}</td>
                                <td>
                                    <button class="btn btn-link text-danger">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-link text-success">
                                        <a class="text-success"><i class="bi bi-clipboard-check"></i></a>
                                    </button>
                                </td>
                                <td>
                                    <span class="badge {{ $valDospems[$index] ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $valDospems[$index] ? 'Disetujui' : 'Belum Diproses' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $valPts[$index] ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $valPts[$index] ? 'Disetujui' : 'Belum Diproses' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('dosen-pendamping.validasi-usulan-disetujui', ['pkm' => $pkms[$index]->id]) }}"
                                        class="btn btn-primary btn-sm me-1">
                                        <i class="bi bi-hand-index-thumb"></i> </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

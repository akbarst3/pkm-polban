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
                        @foreach ($data['viewData']['pengusuls'] as $index => $pengusul)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pengusul->nama }}</td>
                                <td>
                                    {{ $data['viewData']['pkms'][$index]->judul ?? 'Judul tidak tersedia' }}<br>
                                    <small>Pendamping:
                                        {{ $data['viewData']['nameDospems'][$index] ?? 'Belum ditentukan' }}</small><br>
                                    <small>({{ $data['viewData']['kodeDospems'][$index] ?? 'Belum ditentukan' }})</small>
                                </td>
                                <td>{{ $data['viewData']['skemas'][$index] ?? 'Tidak ada skema' }}</td>
                                <td>
                                    @if ($data['viewData']['pkms'][$index]->proposal)
                                        <a href="{{ route('dosen-pendamping.proposal.show', ['filename' => base64_encode($data['viewData']['pkms'][$index]->proposal)]) }}"
                                            class="btn btn-link text-danger" target="_blank" title="Lihat Proposal">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    @else
                                        <button class="btn btn-link text-secondary" disabled>
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-link text-success">
                                        <a class="text-success"><i class="bi bi-clipboard-check"></i></a>
                                    </button>
                                </td>
                                <td>
                                    <span
                                        class="badge {{ $data['viewData']['valDospems'][$index] === null ? 'bg-secondary' : ($data['viewData']['valDospems'][$index] ? 'bg-success' : 'bg-danger') }}">
                                        @if ($data['viewData']['valDospems'][$index] === null)
                                            Belum Diproses
                                        @elseif ($data['viewData']['valDospems'][$index] == 1)
                                            Disetujui
                                        @else
                                            Ditolak
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="badge {{ $data['viewData']['valPts'][$index] === null ? 'bg-secondary' : ($data['viewData']['valPts'][$index] ? 'bg-success' : 'bg-danger') }}">
                                        @if ($data['viewData']['valPts'][$index] === null)
                                            Belum Diproses
                                        @elseif ($data['viewData']['valPts'][$index] == 1)
                                            Disetujui
                                        @else
                                            Ditolak
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('dosen-pendamping.validasi-usulan', ['pkm' => $data['viewData']['pkms'][$index]->id]) }}"
                                        class="btn btn-primary btn-sm me-1"
                                        @if ($data['viewData']['valPts']) style="pointer-events: none; opacity: 0.6;" @endif>
                                        <i class="bi bi-pencil-square"></i>
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

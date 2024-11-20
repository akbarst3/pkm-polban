@extends('pimpinan/master')
@section('konten')
    <div class="container my-4">
        <h5>Data Usulan Proposal PKM</h5>

        <!-- Filter Tahun -->
        <div class="d-flex align-items-center mb-3">
            <label class="me-2" for="yearSelect">Tahun:</label>
            <div class="bg-light border rounded p-2" id="yearSelect">2024</div>
        </div>

        <!-- Approve/Reject/Reset Buttons -->
        <div class="mb-3 d-flex">
            @php
                $needsValidation = in_array(null, $data['valPts'], true);
            @endphp

            @if ($needsValidation)
                <form action="{{ route('perguruan-tinggi.validasi-pimpinan-all') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="val_pt" value=1>
                    <button type="submit" class="btn btn-success me-2">Setujui Semua</button>
                </form>

                <form action="{{ route('perguruan-tinggi.validasi-pimpinan-all') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="val_pt" value=0>
                    <button type="submit" class="btn btn-danger me-2">Tolak Semua</button>
                </form>
            @else
                <form action="{{ route('perguruan-tinggi.validasi-pimpinan-reset') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Reset Semua</button>
                </form>
            @endif

        </div>

        <!-- Table -->
        <div class="card shadow-sm p-4">
            <h5>Daftar Usulan</h5>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Pengusul</th>
                            <th class="text-center">Judul</th>
                            <th class="text-center">Skema</th>
                            <th class="text-center">Dosen Pendamping</th>
                            <th class="text-center">Validasi Dosen Pendamping</th>
                            <th class="text-center">Validasi Pimpinan</th>
                            <th class="text-center">{{ $needsValidation === true ? 'Aksi' : 'Hasil Validasi' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['pengusuls'] as $index => $pengusul)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pengusul->nama }}</td>
                                <td>
                                    {{ $data['pkms'][$index]->judul ?? 'Judul tidak tersedia' }}<br>
                                    <p>Pendamping: {{ $data['dospems'][$index] ?? 'Belum ditentukan' }}</p>
                                </td>
                                <td>{{ $data['skemas'][$index] ?? 'Tidak ada skema' }}</td>
                                <td>{{ $data['dospems'][$index] ?? 'Tidak ada dosen' }}</td>
                                <td>
                                    <span
                                        class="badge 
                                        {{ $data['valDospems'][$index] === null ? 'bg-secondary' : ($data['valDospems'][$index] ? 'bg-success' : 'bg-danger') }}">
                                        {{ $data['valDospems'][$index] === null ? 'Belum Diproses' : ($data['valDospems'][$index] ? 'Disetujui' : 'Ditolak') }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="badge 
                                        {{ $data['valPts'][$index] === null ? 'bg-secondary' : ($data['valPts'][$index] ? 'bg-success' : 'bg-danger') }}">
                                        {{ $data['valPts'][$index] === null ? 'Belum Diproses' : ($data['valPts'][$index] ? 'Disetujui' : 'Ditolak') }}
                                    </span>
                                </td>
                                <td>
                                    @if (is_null($data['valPts'][$index]))
                                        <div class="d-flex justify-content-between">
                                            <form action="" method="POST" class="mx-1">
                                                @csrf
                                                <input type="hidden" name="pkm_id"
                                                    value="{{ $data['pkms'][$index]->id }}">
                                                <input type="hidden" name="val_pt" value="1">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            </form>
                                            <form action="" method="POST" class="mx-1">
                                                @csrf
                                                <input type="hidden" name="pkm_id"
                                                    value="{{ $data['pkms'][$index]->id }}">
                                                <input type="hidden" name="val_pt" value="0">
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="badge {{ $data['valPts'][$index] ? 'bg-success' : 'bg-danger' }}">
                                            {{ $data['valPts'][$index] ? 'Disetujui' : 'Ditolak' }}
                                        </span>
                                    @endif
                                </td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@extends('pimpinan/master')

@section('konten')
    <div class="container my-4">
        <h5>Data Usulan Proposal PKM</h5>

        <!-- Filter Tahun -->
        <div class="d-flex align-items-center mb-3">
            <label class="me-2" for="yearSelect">Tahun:</label>
            <button class="btn btn-light border me-2" id="yearSelect">2024</button>
        </div>

        <!-- Approve/Reject/Reset Buttons -->
        <div class="mb-3 d-flex">
            <form action="{{ route('validasi.pimpinan.all') }}" method="POST">
                @csrf
                <input type="hidden" name="val_pt" value="1">
                <button type="submit" class="btn btn-success me-2">Setujui semua</button>
            </form>
            <form action="{{ route('validasi.pimpinan.all') }}" method="POST">
                @csrf
                <input type="hidden" name="val_pt" value="0">
                <button type="submit" class="btn btn-danger me-2">Tolak Semua</button>
            </form>
            <form action="{{ route('validasi.pimpinan.reset') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Reset Semua</button>
            </form>
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
                            <th>Dosen Pendamping</th>
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
                                    <small>Pendamping: {{ $dospems[$index] ?? 'Belum ditentukan' }}</small>
                                </td>
                                <td>{{ $skemas[$index] ?? 'Tidak ada skema' }}</td>
                                <td>{{ $dospems[$index] ?? 'Tidak ada dosen' }}</td>
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
                                    <form action="{{ route('validasi.pimpinan') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="pkm_id" value="{{ $pkms[$index]->id }}">
                                        <input type="hidden" name="val_pt" value="1">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('validasi.pimpinan') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="pkm_id" value="{{ $pkms[$index]->id }}">
                                        <input type="hidden" name="val_pt" value="0">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

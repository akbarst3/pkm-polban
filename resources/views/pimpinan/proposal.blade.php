<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Data Usulan Proposal PKM</title>
</head>

<body>
    @extends('pimpinan/master')

    @section('konten')
    <div class="container my-4">
        <div class="card shadow-sm p-4">
            <h2>Data Usulan Proposal PKM</h2>
            <div class="mb-3">
                <button class="btn btn-success">Setujui semua</button>
                <button class="btn btn-danger">Tolak semua</button>
                <button class="btn btn-secondary">Reset semua</button>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Pengusul</th>
                        <th>Judul</th>
                        <th>Skema</th>
                        <th>Proposal</th>
                        <th>Pengesahan</th>
                        <th>Validasi Dosen Pembimbing</th>
                        <th>Validasi Pimpinan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usulans as $index => $usulan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $usulan->pengusul }}</td>
                        <td>{{ $usulan->judul }}</td>
                        <td>{{ $usulan->skema }}</td>

                        <!-- Tombol Proposal dan Pengesahan -->
                        <td><button class="btn btn-light"><i class="bi bi-file-earmark-pdf"></i></button></td>
                        <td><button class="btn btn-light"><i class="bi bi-file-earmark-text"></i></button></td>

                        <!-- Validasi Dosen Pembimbing -->
                        <td>
                            <span class="badge bg-secondary">Belum Diproses</span>
                        </td>

                        <!-- Status Validasi Pimpinan -->
                        <td>
                            @if($usulan->status_pimpinan == 1)
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($usulan->status_pimpinan == 2)
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-secondary">Belum Diproses</span>
                            @endif
                        </td>

                        <!-- Tombol Setujui dan Tolak -->
                        <td>
                            <form action="{{ route('setujuiProposal', $usulan->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>

                            <form action="{{ route('tolakProposal', $usulan->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

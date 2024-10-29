<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <title>Data Usulan Proposal PKM</title>
</head>

<body>
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
            <button class="btn btn-success me-2">Setujui semua</button>
            <button class="btn btn-danger me-2">Tolak Semua</button>
            <button class="btn btn-primary">Reset Semua</button>
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
                            <th>Validasi Dosen Pembimbing</th>
                            <th>Validasi Pimpinan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Valensia Febrianto</td>
                            <td>
                                Judul PKM<br>
                                <small>Pendamping: RENNY NIRWANA SARI (0701108007)</small>
                            </td>
                            <td>PKM-K</td>
                            <td>
                                <button class="btn btn-link text-danger">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-link text-muted">
                                    <i class="bi bi-clipboard-minus"></i>
                                </button>
                            </td>
                            <td><span class="badge bg-secondary">Belum Diproses</span></td>
                            <td><span class="badge bg-secondary">Belum Diproses</span></td>
                            <td>
                                <button class="btn btn-success btn-sm">
                                    <i class="bi bi-check-circle"></i>
                                </button>
                                <button class="btn btn-danger btn-sm">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endsection

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

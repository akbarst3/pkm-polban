<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Data Pembimbingan Usulan Proposal PKM</title>
</head>

<body>
    @extends('dospem/master')

    @section('konten')
    <div class="container my-4">
        <h4>Data Pembimbingan Usulan Proposal PKM</h4>

        <!-- Filter Tahun -->
        <div class="d-flex align-items-center mb-3">
            <label class="me-2" for="yearSelect">Tahun:</label>
            <select id="yearSelect" class="form-select form-select-sm w-auto">
                <option>2024</option>
                <option>2023</option>
            </select>
        </div>

        <!-- Table -->
        <div class="card shadow-sm p-4">
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
                            <td>Aplikasi Pendataan PKM Polban</td>
                            <td>PKM-K</td>
                            <td>
                                <button class="btn btn-link text-danger">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-link text-success">
                                    <a href="validasiusulandisetujui"><i class="bi bi-clipboard-check"></i></a>
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

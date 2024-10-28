<!-- File: resources/views/dospem/logbook_keuangan.blade.php -->

@extends('dospem.master')

@section('konten')
<div class="container my-4">
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h6 class="mb-0">Log Book Keuangan</h6>
        </div>
    <!-- Tabel Log Book Keuangan -->
    <div class="card shadow-sm p-4">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Harga Satuan (Rp)</th>
                        <th>Jumlah</th>
                        <th>Total (Rp)</th>
                        <th>Berkas</th>
                        <th>Validasi Dosen</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>03-10-2024</td>
                        <td>Boost ads pencapaian PKM</td>
                        <td>86,243/postingan</td>
                        <td>1</td>
                        <td>86,243</td>
                        <td>
                            <button class="btn btn-link text-secondary">
                                <i class="bi bi-file-earmark"></i>
                            </button>
                        </td>
                        <td>
                            <select class="form-select form-select-sm" aria-label="Validasi Dosen">
                                <option selected>Disetujui</option>
                                <option>Ditolak</option>
                            </select>
                        </td>
                    </tr>
                    <!-- Additional rows as needed -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation" class="mt-3">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>
@endsection

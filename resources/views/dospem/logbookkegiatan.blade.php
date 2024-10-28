<!-- File: resources/views/dospem/logbook.blade.php -->

@extends('dospem.master')

@section('konten')
<div class="container my-4">
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h6 class="mb-0">Log Book Kegiatan</h6>
        </div>

    <!-- Tabel Log Book Kegiatan -->
    <div class="card shadow-sm p-4">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Capaian</th>
                        <th>Waktu Pelaksanaan (Menit)</th>
                        <th>Berkas</th>
                        <th>Validasi Dosen</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>8-10-2024</td>
                        <td>Finalisasi dan Pengunggahan Laporan Akhir</td>
                        <td>100%</td>
                        <td>180</td>
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

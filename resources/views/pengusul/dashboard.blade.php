<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Perbaikan meta viewport -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Dashboard - Program Kreativitas Mahasiswa</title>
</head>

<body>
    @extends('pengusul/master') <!-- Pastikan ini di bagian atas -->

    @section('konten')
    <div class="container-fluid mt-3 px-5">
        <h5>Beranda Pengusul Program Kreativitas Mahasiswa</h5>
        <div class="card">
            <div class="card-header bg-primary text-white">
                IDENTITAS PERSONAL
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td><strong>Nama</strong></td>
                            <td>: {{ $mahasiswa->nama }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nomor Induk</strong></td>
                            <td>: {{ $mahasiswa->nim }}</td>
                        </tr>
                        <tr>
                            <td><strong>Program Studi</strong></td>
                            <td>: D3 Teknik Informatika</td>
                        </tr>
                        <tr>
                            <td><strong>Institusi</strong></td>
                            <td>: Politeknik Negeri Bandung</td>
                        </tr>
                        <tr>
                            <td><strong>Angkatan</strong></td>
                            <td>: 2023</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @endsection
</body>

</html>

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
    @extends('dospem/master') <!-- Pastikan ini di bagian atas -->

    @section('konten')
    <div class="container my-4">
        <div class="card shadow-sm p-4">
            <h2 class="text-primary">SELAMAT DATANG, JONNER HUTAHEAN!</h2>
            <p>Anda sedang login di role <strong>DOSEN PENDAMPING</strong></p>
        </div>
    </div>
    @endsection

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

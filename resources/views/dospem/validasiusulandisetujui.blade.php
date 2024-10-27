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
            <select id="yearSelect" class="form-select form-select-sm w-auto me-2">
                <option selected>2024</option>
                <option>2023</option>
            </select>
        </div>

        <!-- Data Usulan -->
        <div class="card p-4">
            <h5 class="text">Data Usulan</h5> <!-- Judul Data Usulan -->
            <h6 class="text-center">Apakah Proposal Berikut Ini Akan Disetujui?</h5>
            <div class="row my-3">
                <div class="col-2 text-end"><strong>Judul</strong></div> <!-- Rata kanan -->
                <div class="col-8">Judul PKM</div>
            </div>
            <div class="row my-2">
                <div class="col-2 text-end"><strong>Skema</strong></div> <!-- Rata kanan -->
                <div class="col-8">PKM-K</div>
            </div>
            <div class="row my-2">
                <div class="col-2 text-end"><strong>Ketua</strong></div> <!-- Rata kanan -->
                <div class="col-8">VALENSIA FEBRIANTO</div>
            </div>
            <div class="row my-2">
                <div class="col-2 text-end"><strong>NIM</strong></div> <!-- Rata kanan -->
                <div class="col-8">231511065</div>
            </div>
            <div class="row my-2">
                <div class="col-2 text-end"><strong>Program Studi</strong></div> <!-- Rata kanan -->
                <div class="col-8">D-3 Teknik Informatika</div>
            </div>
            <div class="row my-2">
                <div class="col-2 text-end"><strong>Dosen Pembimbing</strong></div> <!-- Rata kanan -->
                <div class="col-8">RENNY NIRWANA SARI</div>
            </div>
            <div class="row my-2">
                <div class="col-2 text-end"><strong>NIDN</strong></div> <!-- Rata kanan -->
                <div class="col-8">0701108007</div>
            </div>

            <!-- Status Validasi Dosen -->
            <div class="row my-2">
                <div class="col-2 text-end"><strong>Status Validasi Dosen</strong></div> <!-- Rata kanan -->
                <div class="col-8">
                    <span id="statusBadge" class="badge bg-secondary">Belum Diproses</span>
                </div>
            </div>

            <!-- Aksi Tombol -->
            <div class="row mt-4">
                <div class="col-4 text-end"> <!-- Adjust the column size as needed -->
                <button class="btn btn-outline-secondary" onclick="kembali()">Kembali</button>
                <button class="btn btn-success mx-2" onclick="setujui()">Setujui</button>
                <button class="btn btn-danger" onclick="tolak()">Tolak</button>
            </div>
        </div>
    </div>
    @endsection

    <script>
        function setujui() {
            const badge = document.getElementById('statusBadge');
            badge.textContent = 'Disetujui';
            badge.className = 'badge bg-success'; // Ubah warna menjadi hijau
        }

        function tolak() {
            const badge = document.getElementById('statusBadge');
            badge.textContent = 'Ditolak';
            badge.className = 'badge bg-warning text-dark'; // Ubah warna menjadi oranye
        }

        function kembali() {
            // Logika untuk kembali ke halaman sebelumnya
            alert('Kembali ke halaman sebelumnya');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

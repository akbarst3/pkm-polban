<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Identitas Pengusul - Program Kreativitas Mahasiswa</title>
</head>

<body>
    @extends('pengusul/master') <!-- Menggunakan master layout yang sama -->

    @section('konten')
    <div class="container-fluid mt-3 px-5">
        <h5>Pengisian Identitas Mahasiswa Pengusul PKM</h5>
        <div class="card">
            <div class="card-header bg-primary text-white">
                PENGESAHAN USULAN PKM KARSA CIPTA
            </div>
            <div class="card-body">
                <form action="#" method="POST">
                    @csrf <!-- Laravel CSRF token -->

                    <!-- 1. Judul Kegiatan -->
                    <div class="form-group mb-3">
                        <label><strong>1. Judul Kegiatan</strong></label>
                        <p>{{ $judul_kegiatan }}</p> <!-- Data dari database -->
                    </div>

                    <!-- 2. Bidang Kegiatan -->
                    <div class="form-group mb-3">
                        <label><strong>2. Bidang Kegiatan</strong></label>
                        <p>{{ $bidang_kegiatan }}</p> <!-- Data dari database -->
                    </div>

                    <!-- 3. Ketua Pelaksana Kegiatan -->
                    <div class="form-group mb-3">
                        <label><strong>3. Ketua Pelaksana Kegiatan</strong></label>
                        <ul>
                            <li>Nama Lengkap: {{ $ketua_nama }}</li> <!-- Data dari database -->
                            <li>NIM: {{ $ketua_nim }}</li> <!-- Data dari database -->
                            <li>Program Studi: {{ $ketua_prodi }}</li> <!-- Data dari database -->
                            <li>Alamat Rumah dan No Telp/HP: {{ $ketua_alamat }}</li> <!-- Data dari database -->
                            <li>Email: {{ $ketua_email }}</li> <!-- Data dari database -->
                        </ul>
                    </div>

                    <!-- 4. Anggota Pelaksana Kegiatan/Penulis -->
                    <div class="form-group mb-3">
                        <label><strong>4. Anggota Pelaksana Kegiatan/Penulis</strong></label>
                        <p>{{ $jumlah_anggota }} Orang</p> <!-- Data dari database -->
                    </div>

                    <!-- 5. Dosen Pendamping -->
                    <div class="form-group mb-3">
                        <label><strong>5. Dosen Pendamping</strong></label>
                        <ul>
                            <li>Nama Lengkap dan Gelar: {{ $dosen_nama }}</li> <!-- Data dari database -->
                            <li>NIDN: {{ $dosen_nidn }}</li> <!-- Data dari database -->
                            <li>Alamat Rumah dan No Telp/HP: {{ $dosen_alamat }}</li> <!-- Data dari database -->
                        </ul>
                    </div>

                    <!-- 6. Dana Usulan -->
                    <div class="form-group mb-3">
                        <label><strong>6. Dana Usulan</strong></label>
                        <ul>
                            <li>Kemendikbudristek: Rp{{ $dana_kemendikbud }}</li> <!-- Data dari database -->
                            <li>Institusi Lain: Rp{{ $dana_institusi_lain }}</li> <!-- Data dari database -->
                        </ul>
                    </div>

                    <!-- 7. Jangka Waktu Pelaksanaan -->
                    <div class="form-group mb-3">
                        <label><strong>7. Jangka Waktu Pelaksanaan</strong></label>
                        <p>{{ $jangka_waktu }} bulan</p> <!-- Data dari database -->
                    </div>

                    <!-- Input untuk persetujuan -->
                    <div class="form-group mb-3">
                        <label for="approval"><strong>Menyetujui</strong></label>
                        <input type="text" class="form-control" id="approval" name="approval" placeholder="Masukkan nama">
                    </div>

                    <div class="form-group mb-3">
                        <label for="nip"><strong>NIP/NIK</strong></label>
                        <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP/NIK">
                    </div>

                    <!-- Tombol Submit -->
                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-secondary" onclick="window.history.back()">Kembali</button>
                    </div>

                    <p class="text-right">Bandung, {{ date('d F Y') }}</p> <!-- Tanggal otomatis -->
                    <p class="text-right"><strong>Ketua Pelaksana Kegiatan,</strong></p>
                    <p class="text-right"><strong>{{ $ketua_nama }}</strong></p> <!-- Data dari database -->
                    <p class="text-right">NIM. {{ $ketua_nim }}</p> <!-- Data dari database -->
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @endsection
</body>

</html>

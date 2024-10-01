<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Perbaikan meta viewport -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert CDN -->
    <title>Dashboard</title>
</head>

<body>
    @extends('operator/master') <!-- Pastikan ini di bagian atas -->

    @section('konten')
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">{{ $perguruanTinggi }}</h3> <!-- Menggunakan variabel $data -->
                    </div>
                </div>
            </div>
        </div>

        <div class="container my-4">
            <div class="row">
                <!-- Kolom Utama -->
                <div class="col-md-6 mb-3">
                    <!-- Kolom Kiri Berbasis Baris -->
                    <div class="row mb-4">
                        <div class="col-md-9 text-end fw-bold">
                            <p>Tahun Pelaksanaan</p>
                        </div>
                        <div class="col-md-3">
                            <input type="text" id="tahun-pelaksanaan" class="form-control" disabled value="2024">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-9 text-end">
                            <p>Klaster</p>
                        </div>
                        <div class="col-md-3">
                            <div class="w-75 text-center" style="background-color: #58afdd; color: white;">
                                KLASTER 1
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-9 text-end">
                            <p>Kuota PKM 8 Bidang</p>
                        </div>
                        <div class="col-md-3">
                            <p>400</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-9 text-end">
                            <p>Kuota PKM Artikel Ilmiah</p>
                        </div>
                        <div class="col-md-3">
                            <p>50</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-9 text-end">
                            <p>Kuota PKM Gagasan Futuristik Tertulis</p>
                        </div>
                        <div class="col-md-3">
                            <p>50</p>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan (Form Upload) -->
                <div class="col-md-6">
                    <div class="form-upload">
                        <script>
                            @if (session('success'))
                                Swal.fire({
                                    title: 'Success!',
                                    text: "{{ session('success') }}",
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                            @endif
                        </script>
                        @if ($statusFiles['beritaAcaraPendanaan'] == true)
                            <div class="mb-3">
                                <div class="row align-items-center">
                                    <div class="row mb-3"> <!-- Menambahkan row untuk setiap file -->
                                        <div class="col-md-6"> <!-- Kolom kiri -->
                                            <p class="mb-0 text-end">Berita Acara PKM Skema Pendanaan</p>
                                            <p class="text-secondary text-end">PKM 8 Bidang</p>
                                        </div>
                                        <div class="col-md-6"> <!-- Kolom kanan -->
                                            <div class="w-50 text-center align-top"
                                                style="background-color: #33b864; color: white; border-radius: 5px;">
                                                Sudah Upload
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3"> <!-- Menambahkan row untuk setiap file -->
                                        <div class="col-md-6"> <!-- Kolom kiri -->
                                            <p class="mb-0 text-end">Surat Komitmen Dana Tambahan</p>
                                            <p class="text-secondary text-end">PKM 8 Bidang</p>
                                        </div>
                                        <div class="col-md-6"> <!-- Kolom kanan -->
                                            <div class="w-50 text-center align-top"
                                                style="background-color: #33b864; color: white; border-radius: 5px;">
                                                Sudah Upload
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3"> <!-- Menambahkan row untuk setiap file -->
                                        <div class="col-md-6"> <!-- Kolom kiri -->
                                            <p class="mb-0 text-end">Berita Acara PKM Skema Insentif</p>
                                            <p class="text-secondary text-end">PKM 8 Bidang</p>
                                        </div>
                                        <div class="col-md-6"> <!-- Kolom kanan -->
                                            <div class="w-50 text-center align-top"
                                                style="background-color: #33b864; color: white; border-radius: 5px;">
                                                Sudah Upload
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            @else
                                <form action="{{ route('operator.file') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="file1" class="label">Berita Acara PKM Skema Pendanaan</label>
                                        <input type="file" class="form-control w-50" id="file1"
                                            name="beritaAcaraPendanaan">
                                    </div>

                                    <div class="mb-3">
                                        <label for="file2" class="label">Surat Komitmen Dana Tambahan</label>
                                        <input type="file" class="form-control w-50" id="file2" name="suratKomitmen">
                                    </div>

                                    <div class="mb-3">
                                        <label for="file3" class="label">Berita Acara PKM Skema Insentif</label>
                                        <input type="file" class="form-control w-50" id="file3"
                                            name="beritaAcaraInsentif">
                                    </div>

                                    <button type="submit" class="btn btn-success w-25">Upload</button>
                                </form>
                                <!-- SweetAlert Script -->
                        @endif
                    </div>
                </div>
            </div>


            <!-- Tabel -->
            <div class="row">
                <div class="col">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Jenis</th>
                                <th>Skema</th>
                                <th>Usulan</th>
                                <th>Isian Identitas</th>
                                <th>Upload Proposal</th>
                                <th>Val. Dosen</th>
                                <th>Val. Pimpinan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($namaSkema as $idSkema => $skema)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($loop->iteration == 9 || $loop->iteration == 10)
                                            PKM {{ $skema }}
                                        @else
                                            PKM 8 Bidang
                                        @endif
                                    </td>
                                    <td>PKM {{ $skema }}</td>
                                    <td>{{ $dataPkms[0]['judulCounts'][$idSkema]['total'] ?? 0 }}</td>
                                    <td>{{ $dataPkms[1]['proposalCounts'][$idSkema]['total'] ?? 0 }}</td>
                                    <td>{{ $dataPkms[2]['pengisianCounts'][$idSkema]['count'] ?? 0 }}</td>
                                    <td>{{ $dataPkms[3]['validasiCounts']['val_dospem'][$idSkema]['total'] ?? 0 }}</td>
                                    <td>{{ $dataPkms[3]['validasiCounts']['val_pt'][$idSkema]['total'] ?? 0 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    @endsection
</body>

</html>

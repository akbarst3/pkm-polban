<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Dashboard</title>
</head>

<body>
    @extends('operator/master')

    @section('konten')
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">{{ $perguruanTinggi->nama_pt }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5>REKAP TAHAPAN</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="row mb-4">
                                    <div class="col-md-9 text-end">
                                        <p>Tahun Pelaksanaan</p>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" id="tahun-pelaksanaan" class="form-control" disabled
                                            value="2024">
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

                            @if (session('success'))
                                <script>
                                    Swal.fire({
                                        title: 'Success!',
                                        text: "{{ session('success') }}",
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: '#003c72',
                                    });
                                </script>
                            @endif
                            @if (session('error'))
                                <script>
                                    Swal.fire({
                                    icon: 'info',
                                    title: 'Tidak Bisa Akses Halaman!',
                                    text: "{{ session('error') }}",
                                    confirmButtonColor: '#003c72',
                                    timer: 10000,
                                    timerProgressBar: true,
                                    showClass: {
                                        popup: 'animate__animated animate__fadeInDown'
                                    },
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOutUp'
                                    }
                                });
                                </script>
                            @endif


                            <div class="col-md-6">
                                <div class="form-upload">
                                    @if ($statusFiles['beritaAcaraPendanaan'] == true)
                                        <div class="mb-3">
                                            <div class="row align-items-center">
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <p class="mb-0 text-end">Berita Acara PKM Skema Pendanaan</p>
                                                        <p class="text-secondary text-end">PKM 8 Bidang</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="w-50 text-center align-top"
                                                            style="background-color: #33b864; color: white; border-radius: 5px;">
                                                            Sudah Upload
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <p class="mb-0 text-end">Surat Komitmen Dana Tambahan</p>
                                                        <p class="text-secondary text-end">PKM 8 Bidang</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="w-50 text-center align-top"
                                                            style="background-color: #33b864; color: white; border-radius: 5px;">
                                                            Sudah Upload
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <p class="mb-0 text-end">Berita Acara PKM Skema Insentif</p>
                                                        <p class="text-secondary text-end">PKM 8 Bidang</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="w-50 text-center align-top"
                                                            style="background-color: #33b864; color: white; border-radius: 5px;">
                                                            Sudah Upload
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mb-3">

                                            <form action="{{ route('operator.file') }}" method="POST"
                                                class="needs-validation" novalidate enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="file1" class="label">Berita Acara PKM Skema
                                                        Pendanaan</label>
                                                    <input type="file" class="form-control w-50" id="file1"
                                                        name="beritaAcaraPendanaan" required>
                                                    <div class="invalid-feedback">File ini wajib diisi</div>
                                                    @error('beritaAcaraPendanaan')
                                                        <small style="color: red;">{{ $message }}</small><br>
                                                    @enderror
                                                    <small class="form-text text-muted">Maksimal ukuran file 5MB</small>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="file2" class="label">Surat Komitmen Dana
                                                        Tambahan</label>
                                                    <input type="file" class="form-control w-50" id="file2"
                                                        name="suratKomitmen" required>
                                                    <div class="invalid-feedback">File ini wajib diisi</div>
                                                    @error('suratKomitmen')
                                                        <small style="color: red;">{{ $message }}</small><br>
                                                    @enderror
                                                    <small class="form-text text-muted">Maksimal ukuran file 5MB</small>

                                                </div>
                                                <div class="mb-3">
                                                    <label for="file3" class="label">Berita Acara PKM Skema
                                                        Insentif</label>
                                                    <input type="file" class="form-control w-50" id="file3"
                                                        name="beritaAcaraInsentif" required>
                                                    <div class="invalid-feedback">File ini wajib diisi</div>
                                                    @error('beritaAcaraInsentif')
                                                        <small style="color: red;">{{ $message }}</small><br>
                                                    @enderror
                                                    <small class="form-text text-muted">Maksimal ukuran file 5MB</small>

                                                </div>
                                                <button type="submit" class="btn btn-success w-25">Upload</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>

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
                                                    <td>{{ $dataPkms[0]['judulCounts'][$idSkema] ?? 0 }}</td>
                                                    <td>{{ $dataPkms[1]['proposalCounts'][$idSkema] ?? 0 }}</td>
                                                    <td>{{ $dataPkms[2]['pengisianCounts'][$idSkema]['count'] ?? 0 }}</td>
                                                    <td>{{ $dataPkms[3]['validasiCounts']['val_dospem'][$idSkema] ?? 0 }}
                                                    </td>
                                                    <td>{{ $dataPkms[3]['validasiCounts']['val_pt'][$idSkema] ?? 0 }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endsection

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            'use strict';
                            var forms = document.querySelectorAll('.needs-validation');
                            Array.prototype.slice.call(forms).forEach(function(form) {
                                form.addEventListener('submit', function(event) {
                                    if (!form.checkValidity()) {
                                        event.preventDefault();
                                        event.stopPropagation();
                                    }
                                    form.classList.add('was-validated');
                                }, false);
                            });
                        });
                    </script>
</body>

</html>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="public/css/style.css"> <!-- Pastikan jalur benar -->
    <title>Usulan Baru</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .custom-icon {
            font-size: 1.5rem;
        }
    </style>
</head>

@extends('operator/master')

@section('konten')

    <body class=" bg-secondary bg-opacity-50 ">
        <div class="container">
            <div class="breadcrumb-container col-12 ml-auto mr-2 p-3">
            </div>
            <div class="table-header col-11  ml-auto mr-5 text-left bg-primary mb-0 ">
                <p class=" m-0 p-1 text-white">DAFTAR USULAN {{ strtoupper($perguruanTinggi->nama_pt) }}</p>
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

            <div class="container-md col-11 ml-auto mr-5 bg-white pt-2 pb-3 mt-0 ">
                <!-- Filter Dropdowns -->
                <div class="table-container">
                    <div class="row align-items-end mb-3">
                        <div class="col-md-4">
                            <label for="skema-filter">Filter Skema:</label>
                            <select class="form-control" id="skema-filter" required>
                                <option value="" selected>--Semua Skema--</option>
                                @foreach ($skema as $item)
                                    <option value="{{ $item->nama_skema }}"> {{ $item->nama_skema }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-8">
                            <a href="{{ route('operator.identitas.usulan') }}" class="btn btn-primary w-20">+ Data
                                Baru</a>
                        </div>
                    </div>

                    <table class="table table-striped table-bordered table-hover" id="data-table">
                        <thead>
                            <tr>
                                <th class="text-center align-middle" scope="col">No</th>
                                <th class="text-center align-middle" scope="col">Pengusul</th>
                                <th class="text-center align-middle" scope="col">Judul</th>
                                <th class="text-center align-middle w-1" scope="col">Skema</th>
                                <th class="text-center align-middle" scope="col">Isian Kosong</th>
                                <th class="text-center align-middle" scope="col">Val. Dosen</th>
                                <th class="text-center align-middle" scope="col">Val. Pimpinan</th>
                                <th class="text-center align-middle" scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengusuls as $index => $pengusul)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        {{ $pengusul->nama_mahasiswa }}<br>
                                        {{ $pengusul->nim }}<br>
                                        {{ $pengusul->nama_prodi }} ({{ $pengusul->kode_prodi }})<br>
                                        Angkatan {{ $pengusul->angkatan }}
                                    </td>
                                    <td>{{ $pengusul->judul_pkm }}</td>
                                    <td>{{ $pengusul->nama_skema }}</td>
                                    <td>
                                        @if ($pengusul->jumlah_mahasiswa < 3)
                                            Anggota Kurang, <br>
                                        @endif
                                        @if ($pengusul->alamat == null)
                                            Alamat, <br>
                                            Email, <br>
                                            Luaran, <br>
                                            Dana Usulan <br>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$pengusul->val_dospem)
                                            <i
                                                class="d-flex justify-content-center bi bi-x-circle-fill text-danger custom-icon"></i>
                                        @else
                                            <i
                                                class="d-flex justify-content-center bi bi-check-circle-fill text-success custom-icon"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$pengusul->val_pt)
                                            <i
                                                class="d-flex justify-content-center bi bi-x-circle-fill text-danger custom-icon"></i>
                                        @else
                                            <i
                                                class="d-flex justify-content-center bi bi-check-circle-fill text-success custom-icon"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-primary mb-2" onclick="viewData('{{ $pengusul->nim }}')">
                                            <i class="bi bi-person"></i>
                                        </button> <br>
                                        <form action="{{ route('operator.usulan.baru.delete', $pengusul->nim) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
            <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
            </script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
                integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
            </script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
                integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
            </script>
            <script>
                function confirmDeletion(event) {
                    event.preventDefault();
                    const form = event.target.closest('form');
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#003c72',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }

                const deleteButtons = document.querySelectorAll('.btn-danger');
                deleteButtons.forEach(button => {
                    button.addEventListener('click', confirmDeletion);
                });

                function viewData(nim) {
                    window.location.href = '/operator/usulan-baru/' + nim
                }

                $(document).ready(function() {
                    var table = $('#data-table').DataTable({
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
                        }
                    });

                    $('#skema-filter').on('change', function() {
                        var selectedSkema = $(this).val();
                        table.column(3)
                            .search(selectedSkema)
                            .draw();
                    });
                });
            </script>
    </body>
@endsection

</html>

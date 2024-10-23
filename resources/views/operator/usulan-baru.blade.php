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
</head>

@extends('operator/master')

@section('konten')

    <body class=" bg-secondary bg-opacity-50 ">
        <div class="container">
            <div class="breadcrumb-container col-12 ml-auto mr-2 p-3">
            </div>
            <div class="table-header col-11  ml-auto mr-5 text-left bg-primary mb-0 ">
                <p class=" m-0 p-1 text-white">DAFTAR USULAN {{ $perguruanTinggi->nama_pt }}</p>
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
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="tahun">Tahun:</label>
                            <select class="form-control" id="tahun">
                                <option value="" disabled selected>Pilih Tahun</option>
                                <option>2021</option>
                                <option>2022</option>
                                <option>2023</option>
                                <option>2024</option>
                            </select>
                        </div>
                        <div class=" form-group col-md-3">
                            <label for="skema">Skema:</label>
                            <select class="form-control" id="skema">
                                <option value="" disabled selected>--Pilih Skema--</option>
                                <option>PKM-K</option>
                                <option>PKM-P</option>
                                <option>PKM-T</option>
                                <option>PKM-M</option>
                            </select>
                        </div>
                        <div class=" form group col-md-2">
                            <label for="angkatan">Tahun Angkatan:</label>
                            <select class="form-control" id="angkatan">
                                <option value="" disabled selected>Pilih Angkatan</option>
                                <option>2020</option>
                                <option>2021</option>
                                <option>2022</option>
                                <option>2023</option>
                            </select>
                        </div>
                        <div class=" form-group col-md-2">
                            {{-- <label for="jumlahBaris">Jumlah Baris:</label>
                                <select class="form-control" id="jumlahBaris">
                                  <option>10</option>
                                  <option>20</option>
                                  <option>50</option>
                                </select> --}}
                        </div>
                        <div class=" form-group row col-md-4 ml-1">
                            <div class="input-group ">
                                <input type="text" id="search" class="form-control" placeholder="Pencarian...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" id="search-button">Cari</button>
                                </div>
                                <div class="col-md-2">
                                    <a href="{{ route('operator.identitas.usulan') }}"><button class="btn btn-primary"
                                            id="add-new">+
                                            Data Baru</button></a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Pengusul</th>
                                <th scope="col">Judul</th>
                                <th scope="col">Skema</th>
                                <th scope="col">Isian Kosong</th>
                                <th scope="col">Val. Dosen</th>
                                <th scope="col">Val. Pimpinan</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($pengusuls as $index => $pengusul)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        {{ $pengusul->nama_mahasiswa }}<br>
                                        {{ $pengusul->nim }}<br>
                                        {{ $pengusul->nama_prodi }}
                                    </td>
                                    <td>{{ $pengusul->judul_pkm }}</td>
                                    <td>{{ $pengusul->nama_skema }}</td>
                                    <td>
                                        @if ($pengusul->jumlah_mahasiswa < 3)
                                            Anggota Kurang <br>
                                        @endif
                                        @if ($pengusul->alamat == null)
                                            Alamat <br>
                                            Email <br>
                                            Luaran <br>
                                            Dana Usulan <br>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($pengusul->mahasiswa->detailPkm->val_dospem == false)
                                            <i class="bi bi-x-circle-fill text-danger"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($pengusul->mahasiswa->detailPkm->val_pt == false)
                                            <i class="bi bi-x-circle-fill text-danger"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-primary" onclick="viewData('{{ $pengusul->nim }}')">
                                            <i class="bi bi-person"></i>
                                        </button>
                                        <form action="{{ route('delete.pengusul', $pengusul->nim) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
                integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
            </script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
                integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
            </script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
                integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
            </script>
            <script>
                function viewData(nim) {
                    window.location.href = '/operator/usulan-baru/' + nim;
                }
            </script>    
    </body>
@endsection

</html>

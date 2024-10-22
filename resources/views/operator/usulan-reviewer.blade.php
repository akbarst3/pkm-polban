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
    <title>Usulan Reviewer</title>
</head>
@extends('operator/master')

@section('konten')

    <body class=" bg-secondary bg-opacity-50 ">
        {{-- <div class="sidebar col-md-2 bg-white" style="position: fixed; top: 0; bottom: 0;">
                <!-- Isi sidebar -->
            </div>
            <div class="navbar bg-white" style="position: fixed; top: 0; left: 0; right: 0; height: 50px;">
                <!-- Isi sidebar -->
            </div> --}}
        <div>
            <div class="breadcrumb-container col-12 ml-auto mr-2 mt-1 p-3">
                <a href="#" class="breadcrumb-item">Usulan Reviewer</a> &lt;
                <a href="/operator/identitasReviewer" class="breadcrumb-item">Identitas Usulan</a>
            </div>
            <div class="table-header col-11  ml-auto mr-5 text-left bg-primary mb-0 ">
                <p class=" m-0 p-1">DAFTAR USULAN REVIEWER POLITEKNIK NEGERI BANDUNG</p>
            </div>
            <div class="container-md col-11 ml-auto mr-5 bg-white pt-2 pb-5 mt-0 ">
                <div class=" form-group col-md-2 ml-1">
                    <a href="/operator/identitasReviewer"><button class="btn btn-primary" id="add-new">+ Data
                            Baru</button></a>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">NIDN</th>
                            <th scope="col">Nama Reviewer</th>
                            <th scope="col">Skema</th>
                        </tr>
                    </thead>


                    {{-- <tbody>
                            <tr scope= "row"> </tr>
                            <tr>
                                <td scope= "row">1</td>
                                <td>Restu Akbar <br>231511088 <br> D3 Teknik Informatika</td>
                                <td>Percobaan oleh admin <br> Pendamping: Bambang - <br>0010117409</td>
                                <td>PKM-K</td>
                                <td>Alamat, Email, Anggota masih <br> kurang, Luaran, Dana usulan</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td scope= "row">2</td>
                                <td>Akbar Restu<br>2315110001<br>D3 Teknik Informatika</td>
                                <td>Percobaan oleh admin lagi<br>Pendamping: Bambang - 0010117409</td>
                                <td>PKM-P</td>
                                <td>Alamat, Email, Anggota masih kurang, Luaran, Dana usulan</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td scope= "row">3</td>
                                <td>Melly<br>2315110002<br>D3 Teknik Informatika</td>
                                <td>Percobaan oleh admin 3<br>Pendamping: Bambang - 0010117409</td>
                                <td>PKM-T</td>
                                <td>Alamat, Email, Anggota masih kurang, Luaran, Dana usulan</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        </tbody> --}}
                </table>
                {{-- <td>
                        <button class="btn btn-warning btn-sm">Edit</button>
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </td> --}}
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
    </body>
@endsection

</html>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Identitas Reviewer</title>
  </head>
  @extends('operator/master')

    @section('konten')
    <body class="wrapper bg-secondary bg-opacity-50">
        {{-- <div class="sidebar col-md-2 bg-white" style="position: fixed; top: 0; bottom: 0;">
            <!-- Isi sidebar -->
        </div>
        <div class="navbar bg-white" style="position: fixed; top: 0; left: 0; right: 0; height: 50px;">
            <!-- Isi sidebar -->
        </div> --}}
        <div>
            <div class="breadcrumb-container col-12 ml-auto mr-5 mt-0 p-3">
                <a href="/operator/usulanReviewer" class="breadcrumb-item">Usulan Reviewer</a> &lt; 
                <a href="/operator/identitasReviewer" class="breadcrumb-item">Identitas Usulan</a>
            </div>
            <div class="container-md col-11 ml-4  bg-white pt-2 pb-3 ">
                <h4 class="mt-0 pb-3 ml-0">Usulan Reviewer</h4>
                <form action="">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3 text-right" >
                                <label for="">NIDN</label>
                            </div>
                            <dif class="col-md-4">
                                <input type="text" name="" class="form-control" placeholder="Masukkan NIDN">
                                <small class=" pl-2">NIDN harap diketik, tidak di copy paste</small>
                            </dif>
                        </div>
                    </div><div class="form-group pt-2">
                        <div class="row">
                            <div class="col-md-3 text-right">
                                <label for="">Nama Dosen</label>
                            </div>
                            <dif class="col-md-4">
                                <input type="text" name="" class="form-control" placeholder="Masukkan Nama Lengkap">
                            </dif>
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">email</label>
                                    <input type="email" name="" class="form-control" placeholder="Masukkan emain anda" id="email">
                                    <label for="">Nama</label>
                                </div>   
                            </div>
                            <dif class="col-md-6">
                                <div class="form-group">
                                    <label for="password">User Akun Mahasiswa</label>
                                    <input type="Password" name="" class="form-control" placeholder="Masukkan Password">
                                </div> 
                            </dif>
                        </div>
                    </div> --}}
                    <div class="form-group pt-2">
                        <div class="row">
                            <div class="col-md-3 text-right">
                                <label for="">Program Studi</label>
                            </div>
                            <dif class="col-md-4">
                                <input type="text" class="form-control" placeholder="Masukkan Program Studi"> 
                            </div>
                        </div>
                    <div class="form-group pt-2">
                        <div class="row">
                            <div class="col-md-3 text-right">
                                <label for="">Skema</label>
                            </div>
                            <dif class="col-md-4">
                                <select class="form.control col-md-12" id="">
                                    <option value="" selected>--Pilih Skema--</option>
                                    @foreach ($skema as $item )
                                    <option value="{{$item->id_skema}}">PKM {{ $item->nama_skema }}</option>
                                    @endforeach
                                    
                                    
                                </select>
                            </div>
                        </div>
                        <div class="pl-5 ml-3">
                            <div class="pl-5 ml-5">
                                <div class=" p-5 ml-5">
                                    <button type="Batal" class="btn btn-secondary bg-opacity-50 ">Reset</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <div class="col-md-3">
                            <label for="">Alasan</label>
                        </div>
                        <div class="col-md-9">
                            <textarea class="form.control col-5" name="" id="" cols="30" rows="10"></textarea>
                        </div> 
                    </div> --}}
                    {{-- <dif class="form-group">
                        <label for="">Simpan</label>
                        <input type="file" class="form-control-file">
                        
                    </dif> --}}
                </form>
            </div>    
        </div>
        
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      </body>
    @endsection
</html>
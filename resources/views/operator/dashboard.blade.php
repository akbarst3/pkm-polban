{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initialscale=1.0">
    <title>Daftar Mahasiswa</title>
</head>

<body>
    <form action="{{ route('operator.logout') }}" method="post">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body> --}}

@extends('operator/master')

@section('konten')
<div class="app-content-header"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Politeknik Negeri Bandung</h3>
            </div>
        </div> <!--end::Row-->
    </div> <!--end::Container-->
</div> <!--end::App Content Header--> <!--begin::App Content-->
<div class="app-content container"> 
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Rekap Tahapan</h5>
                </div> <!-- /.card-header -->
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Tahun Pelaksanaan</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Berita Acara PKM Skema Pendanaan</label>
                            <button class="btn btn-danger w-100">BELUM UPLOAD</button>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Klaster</label>
                            <button class="btn btn-primary w-100">KLASTER I</button>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Surat Komitmen Dana Tambahan</label>
                            <button class="btn btn-danger w-100">BELUM UPLOAD</button>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Kuota PKM 8 Bidang</label>
                            <input type="text" class="form-control" value="400" disabled>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Berita Acara PKM Skema Insentif</label>
                            <button class="btn btn-danger w-100">BELUM UPLOAD</button>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Kuota PKM Artikel Ilmiah</label>
                            <input type="text" class="form-control" value="50" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Kuota PKM Gagasan Futuristik Tertulis</label>
                            <input type="text" class="form-control" value="50" disabled>
                        </div>
                    </div>

                    <!-- Table -->
                    <table class="table table-bordered">
                        <thead>
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
                            <tr>
                                <td>1</td>
                                <td>PKM 8 Bidang</td>
                                <td>PKM Karsa Cipta</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>PKM 8 Bidang</td>
                                <td>PKM Karya Inovatif</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>PKM 8 Bidang</td>
                                <td>PKM Kewirausahaan</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>PKM 8 Bidang</td>
                                <td>PKM Penerapan IPTEK</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>PKM 8 Bidang</td>
                                <td>PKM Pengabdian Kepada Masyarakat</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>PKM 8 Bidang</td>
                                <td>PKM Riset Eksakta</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>PKM 8 Bidang</td>
                                <td>PKM Riset Sosial Humaniora</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>PKM 8 Bidang</td>
                                <td>PKM Video Gagasan Konstruktif</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>PKM Artikel Ilmiah</td>
                                <td>PKM Artikel Ilmiah</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>PKM Gagasan Futuristik Tertulis</td>
                                <td>PKM Gagasan Futuristik Tertulis</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                        </tbody>
                    </table>

                </div> <!-- ./card-body -->
            </div> <!-- /.card -->
        </div> <!-- /.col -->
    </div> <!--end::Row-->
</div> <!--end::App Content-->
@endsection

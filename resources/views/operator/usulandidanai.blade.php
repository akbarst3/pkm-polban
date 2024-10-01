@extends('operator/master')

@section('konten')
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Politeknik Negeri Bandung</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="container my-4">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5>USULAN DIDANAI</h5>
                            </div>
                        </div>
        
                        <div class="row">
                            <!-- Kolom Utama -->
                            <div class="col-md-5 mb-4">
                                <!-- Kolom Kiri Berbasis Baris -->
                                <div class="row mb-4">
                                    <div class="col-md-9 text-end">
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
                            </div>
        
                            <!-- Kolom Kanan -->
                            <div class="col-md-6 mb-3">
                                <div class="row align-items-center">
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <p class="mb-0 text-end">PKM 8 Bidang yang Didanai</p>
                                        </div>
                                        <div class="col-md-3">
                                            <p>0</p>
                                        </div>
                                    </div>
        
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <p class="mb-0 text-end">PKM Artikel Ilmiah yang Didanai</p>
                                        </div>
                                        <div class="col-md-3">
                                            <p>0</p>
                                        </div>
                                    </div>
        
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <p class="mb-0 text-end">PKM Gagasan Futuristik yang Didanai</p>
                                        </div>
                                        <div class="col-md-3">
                                            <p>0</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Skema</th>
                                            <th>Judul</th>
                                            <th>Nama Ketua</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        

                 
        <!-- Content -->
        {{-- <div class="app-content container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title">Usulan Didanai</h5>
                        </div>
                        <div class="card-body">
                            <!-- First Row (Tahun, PKM Info) -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Tahun Pelaksanaan</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">PKM 8 Bidang Yang Didanai</label>
                                    <input type="text" class="form-control" value="0" disabled>
                                </div>
                            </div>

                            <!-- Second Row (Klaster, PKM Gagasan) -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Klaster</label>
                                    <button class="btn btn-primary w-100">KLASTER I</button>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">PKM Artikel Ilmiah Yang Didanai</label>
                                    <input type="text" class="form-control" value="0" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">PKM Gagasan Futuristik Tertulis Yang Didanai</label>
                                    <input type="text" class="form-control" value="0" disabled>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Skema</th>
                                            <th>Judul</th>
                                            <th>Nama Ketua</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Empty rows -->
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- ./card-body -->
                    </div> <!-- /.card -->
                </div> <!-- /.col -->
            </div>
        </div> --}}
@endsection
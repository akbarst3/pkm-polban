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
        <!--end::App Content Header-->

        <!--begin::App Content-->
        <div class="app-content container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <!--begin::Card Header-->
                        <div class="card-header">
                                <h5 class="card-title">Data Mahasiswa</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="programStudi" class="form-label">Program Studi</label>
                                            <select class="form-select" id="programStudi">
                                                <option selected>Pilih Program Studi</option>
                                                <option value="1">Teknik Informatika</option>
                                                <option value="2">Sistem Informasi</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="nim" class="form-label">NIM</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="nim" placeholder="Masukkan NIM">
                                                <button class="btn btn-primary">Cek</button>
                                            </div>
                                            <small class="text-muted">NIM harap diketik, tidak di copy paste dari Excel, Word, PDF, dll</small>
                                        </div>
                                    </div>
            
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="namaMahasiswa" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="namaMahasiswa" placeholder="Masukkan Nama">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tahunMasuk" class="form-label">Tahun Masuk</label>
                                            <input type="number" class="form-control" id="tahunMasuk" placeholder="Tahun Masuk">
                                        </div>
                                    </div>
            
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="usernameMahasiswa" class="form-label">Username Akun Mahasiswa</label>
                                            <input type="text" class="form-control" id="usernameMahasiswa" placeholder="Masukkan Username">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="passwordMahasiswa" class="form-label">Password Akun Mahasiswa</label>
                                            <input type="password" class="form-control" id="passwordMahasiswa" placeholder="Masukkan Password">
                                        </div>
                                    </div>
            
                                    <!-- Data Proposal Usulan -->
                                    <h5>Data Proposal Usulan</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="judulProposal" class="form-label">Judul Proposal</label>
                                            <input type="text" class="form-control" id="judulProposal" placeholder="Masukkan Judul Proposal">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="skemaPKM" class="form-label">Skema PKM</label>
                                            <select class="form-select" id="skemaPKM">
                                                <option selected>Pilih Skema</option>
                                                <option value="1">PKM-1</option>
                                                <option value="2">PKM-2</option>
                                            </select>
                                        </div>
                                    </div>
            
                                    <!-- Dosen Pendamping -->
                                    <h5>Dosen Pendamping</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="nidn" class="form-label">NIDN</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="nidn" placeholder="Masukkan NIDN">
                                                <button class="btn btn-primary">Cari</button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="namaDosen" class="form-label">Nama Dosen</label>
                                            <input type="text" class="form-control" id="namaDosen" placeholder="Masukkan Nama Dosen">
                                        </div>
                                    </div>
            
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="programStudiDosen" class="form-label">Program Studi Dosen</label>
                                            <input type="text" class="form-control" id="programStudiDosen" placeholder="Masukkan Program Studi Dosen">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="noHpDosen" class="form-label">No HP Dosen</label>
                                            <input type="tel" class="form-control" id="noHpDosen" placeholder="Masukkan No HP">
                                        </div>
                                    </div>
            
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="emailDosen" class="form-label">Email Dosen</label>
                                            <input type="email" class="form-control" id="emailDosen" placeholder="Masukkan Email">
                                            <small class="text-muted">Login dosen akan dikirim ke email ini</small>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="usernameDosen" class="form-label">Username Dosen</label>
                                            <input type="text" class="form-control" id="usernameDosen" placeholder="Masukkan Username">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="passwordDosen" class="form-label">Password Dosen</label>
                                            <input type="password" class="form-control" id="passwordDosen" placeholder="Masukkan Password">
                                        </div>
                                    </div>
            
                                    <!-- Buttons -->
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary me-2">Batal</button>
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

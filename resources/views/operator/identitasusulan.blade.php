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

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="p-4 bg-white rounded shadow-sm">
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5>DATA MAHASISWA</h5>
                        </div>
                    </div>

                    <form action="/operator/identitasusulan" method="POST">

                        <div class="row">
                            <!-- Kolom Utama -->
                            <div class="col-md-6 mb-3">
                                <!-- Kolom Kiri Berbasis Baris -->
                                <div class="row mb-4">
                                    <div class="col-md-3 text-end">
                                        <p>Program Studi</p>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="form-select" id="programStudi" name="programStudi">
                                            <option selected>Pilih Program Studi</option>
                                            <option value="1">Teknik Informatika</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-3 text-end">
                                        <p>NIM</p>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="nim" name="nim"
                                                placeholder="Masukkan NIM">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-3 text-end">
                                        <p>Nama</p>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="namaMahasiswa" name="namaMahasiswa"
                                                placeholder="Masukkan Nama">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-3 text-end">
                                        <p>Tahun Masuk</p>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="form-select" id="tahunMasuk" name="tahunMasuk">
                                            <option selected>Tahun Masuk</option>
                                            <option value="1">2023</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6 mb-3">
                                <div class="row align-items-center">
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <p class="mb-0 text-end">Username Akun Mahasiswa</p>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="usernameMahasiswa" name="usernameMahasiswa" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <p class="mb-0 text-end">Password Akun Mahasiswa</p>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="passwordMahasiswa" name="passwordMahasiswa" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5>DATA PROPOSAL USULAN</h5>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Kolom Utama -->
                            <div class="col-md-6 mb-3">
                                <!-- Kolom Kiri Berbasis Baris -->
                                <div class="row mb-4">
                                    <div class="col-md-3 text-end">
                                        <p>Judul</p>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="judulProposal" name="judulProposal">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-3 text-end">
                                        <p>Skema PKM</p>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="form-select" id="skemaPKM" name="skemaPKM">
                                            <option selected>Skema PKM</option>
                                            <option value="1">PKM 8 Bidang</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5>DOSEN PENDAMPING</h5>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Kolom Utama -->
                            <div class="col-md-6 mb-3">
                                <!-- Kolom Kiri Berbasis Baris -->
                                <div class="row mb-4">
                                    <div class="col-md-3 text-end">
                                        <p>NIDN</p>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="nidn" name="nidn">
                                            <button class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-3 text-end">
                                        <p>Nama Dosen</p>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="namaDosen" name="namaDosen" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-3 text-end">
                                        <p>Program Studi</p>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="programStudiDosen" name="programStudiDosen" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-3 text-end">
                                        <p>Nomor Hp</p>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="noHpDosen" name="noHpDosen" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-3 text-end">
                                        <p>Email</p>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="emailDosen" name="emailDosen" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6 mb-3">
                                <div class="row align-items-center">
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <p class="mb-0 text-end">Username Akun Dosen</p>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="usernameDosen" name="usernameDosen" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <p class="mb-0 text-end">Password Akun Dosen</p>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="passwordDosen" name="passwordDosen" disabled >
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button class="btn" style="background-color: #C4C4C4; color: white; width: auto;">
                                Batal
                            </button>
                            <button class="btn" type="submit"
                                style="background-color: #33B864; color: white; width: auto; margin-left: 10px;">
                                Simpan
                            </button>
                        </div>
                    </form>



                </div> <!-- End of container -->
            </div>
        </div>
    </div>
@endsection

@extends('operator.master')
@section('konten')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ $perguruanTinggi->nama_pt }}</h3>
                </div>
            </div>
            <div class="container my-4 p-4 rounded shadow bg-white">
                <h5>DATA MAHASISWA</h5>
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="row mb-4">
                                <div class="row mb-4">
                                    <div class="col-md-3 text-end">
                                        <p>Prodi</p>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" value="{{ $data['namaProdi'] }}"
                                            disabled>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-3 text-end">
                                        <p>NIM</p>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" value="{{ $data['mahasiswa']->nim }}"
                                            disabled>
                                    </div>
                                </div>

                                <div class="col-md-3 text-end">
                                    <p>Nama</p>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="{{ $data['mahasiswa']->nama }}"
                                        disabled>
                                </div>
                            </div>


                            <div class="row mb-4">
                                <div class="col-md-3 text-end">
                                    <p>Tahun Masuk</p>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="{{ $data['mahasiswa']->angkatan }}"
                                        disabled>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="row mb-4">
                                <div class="col-md-6 text-end">
                                    <p>Username Pengusul</p>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" value="{{ $data['pengusul']->username }}"
                                        disabled>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6 text-end">
                                    <p>Password Pengusul</p>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control"
                                        value="{{ $data['pengusul']->password_plain }}" disabled>
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
                        <div class="col-md-6 mb-3">

                            <div class="row mb-4">
                                <div class="col-md-3 text-end">
                                    <p>Judul PKM</p>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="{{ $data['judulPkm'] }}" disabled>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-3 text-end">
                                    <p>Skema PKM</p>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="{{ $data['judulSkema'] }}" disabled>
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
                        <div class="col-md-6 mb-3">

                            <div class="row mb-4">
                                <div class="col-md-3 text-end">
                                    <p>NIDN</p>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="{{ $data['dosen']->kode_dosen }}"
                                        disabled>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-3 text-end">
                                    <p>Dosen Pendamping</p>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="{{ $data['dosen']->nama }}" disabled>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-3 text-end">
                                    <p>No HP</p>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="{{ $data['dosen']->no_hp }}"
                                        disabled>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-3 text-end">
                                    <p>Email</p>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="{{ $data['dosen']->email }}"
                                        disabled>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="row mb-4">
                                <div class="col-md-6 text-end">
                                    <p>Username Dospem</p>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" value="{{ $data['dosen']->username }}"
                                        disabled>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6 text-end">
                                    <p>Password Dospem</p>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control"
                                        value="{{ $data['dosen']->password_plain }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <a href="{{ route('operator.daftar-usulan.') }}" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    @endsection

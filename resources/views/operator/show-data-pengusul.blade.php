<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Usulan</title>
</head>

@extends('operator.master')
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
                    <div style="max-width: 100%; margin: 0 auto;">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>DATA MAHASISWA</h5>

                                <div class="row mb-4">
                                    <div class="col-md-4 text-end">
                                        <p>Program Studi</p>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" value="{{ $data['namaProdi'] }}"
                                            disabled>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-4 text-end">
                                        <p>NIM</p>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" value="{{ $data['mahasiswa']->nim }}"
                                            disabled>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-4 text-end">
                                        <p>Nama</p>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" value="{{ $data['mahasiswa']->nama }}"
                                            disabled>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-4 text-end">
                                        <p>Tahun Masuk</p>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control"
                                            value="{{ $data['mahasiswa']->angkatan }}" disabled>
                                    </div>
                                </div>

                                <h5>DATA PROPOSAL USULAN</h5>

                                <div class="row mb-4">
                                    <div class="col-md-4 text-end">
                                        <p>Judul PKM</p>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" value="{{ $data['judulPkm'] }}" disabled>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-4 text-end">
                                        <p>Skema PKM</p>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" value="{{ $data['judulSkema'] }}"
                                            disabled>
                                    </div>
                                </div>

                                <h5>DOSEN PENDAMPING</h5>

                                <div class="row mb-4">
                                    <div class="col-md-4 text-end">
                                        <p>NIDN</p>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" value="{{ $data['dosen']->kode_dosen }}"
                                            disabled>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-4 text-end">
                                        <p>Nama Dosen</p>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" value="{{ $data['dosen']->nama }}"
                                            disabled>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-4 text-end">
                                        <p>No HP</p>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" value="{{ $data['dosen']->no_hp }}"
                                            disabled>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-4 text-end">
                                        <p>Email</p>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" value="{{ $data['dosen']->email }}"
                                            disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5>DATA AKUN PENGUSUL</h5>

                                <div class="row mb-4">
                                    <div class="col-md-4 text-end">
                                        <p>Username Pengusul</p>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control"
                                            value="{{ $data['pengusul']->username }}" disabled>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-4 text-end">
                                        <p>Password Pengusul</p>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control"
                                            value="{{ $data['pengusul']->password }}" disabled>
                                    </div>
                                </div>

                                <h5>DATA AKUN DOSEN PENDAMPING</h5>

                                <div class="row mb-4">
                                    <div class="col-md-4 text-end">
                                        <p>Username Dospem</p>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" value="{{ $data['dosen']->username }}"
                                            disabled>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-4 text-end">
                                        <p>Password Dospem</p>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control"
                                            value="{{ $data['dosen']->password }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('operator.usulan.baru') }}" class="btn btn-primary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

</html>

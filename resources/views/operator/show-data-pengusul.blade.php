@extends('operator.master')

@section('konten')
    <div class="container my-4">
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
                                <input type="text" class="form-control" value="{{ $namaProdi }}" disabled>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-3 text-end">
                                <p>NIM</p>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" value="{{ $mahasiswa->nim }}" disabled>
                            </div>
                        </div>
                        
                        <div class="col-md-3 text-end">
                            <p>Nama</p>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" value="{{ $mahasiswa->nama }}" disabled>
                        </div>
                    </div>


                    <div class="row mb-4">
                        <div class="col-md-3 text-end">
                            <p>Tahun Masuk</p>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" value="{{ $mahasiswa->angkatan }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="row mb-4">
                        <div class="col-md-6 text-end">
                            <p>Username Pengusul</p>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{ $pengusul->username }}" disabled>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 text-end">
                            <p>Password Pengusul</p>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{ $pengusul->password }}" disabled>
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
                            <input type="text" class="form-control" value="{{ $judulPkm }}" disabled>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3 text-end">
                            <p>Skema PKM</p>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" value="{{ $judulSkema }}" disabled>
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
                            <input type="text" class="form-control" value="{{ $dosen->kode_dosen }}" disabled>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-3 text-end">
                            <p>Dosen Pendamping</p>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" value="{{ $dosen->nama }}" disabled>
                        </div>
                    </div>

                    {{-- <div class="row mb-4">
                        <div class="col-md-3 text-end">
                            <p>Program Studi</p>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" value="{{ $namaProdiDosen }}" disabled>
                        </div>
                    </div> --}}

                    <div class="row mb-4">
                        <div class="col-md-3 text-end">
                            <p>No HP</p>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" value="{{ $dosen->no_hp }}" disabled>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3 text-end">
                            <p>Email</p>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" value="{{ $dosen->email }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="row mb-4">
                        <div class="col-md-6 text-end">
                            <p>Username Dospem</p>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{ $dosen->username }}" disabled>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 text-end">
                            <p>Password Dospem</p>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{ $dosen->password }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <a href="{{ route('operator.usulanBaru.nim', ['nim' => $mahasiswa->nim]) }}" class="btn btn-primary">Kembali</a>
    </div>
@endsection
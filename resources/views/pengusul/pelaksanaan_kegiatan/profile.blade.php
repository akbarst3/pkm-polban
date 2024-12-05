@extends('pengusul/pelaksanaan_kegiatan/master')

@section('konten')
<div class="container">
    <div class="card mb-4">
        <div class="card-body text-center">
            <div class="d-flex flex-column align-items-center">
                <div class="bg-orange p-3 rounded-circle">
                    <img src="https://via.placeholder.com/100" class="rounded-circle" alt="User Image">
                </div>
                <h3 class="mt-3"> {{$data['mahasiswa']->nama}}</h3>
                <p class="text-muted">Pengusul - Mahasiswa</p>
            </div>
        </div>
    </div>
    
    <form action="{{ route('pengusul.pelaksanaan_kegiatan.profile.update') }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama" value= {{$data['mahasiswa']->nama}} readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Nomor KTP</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="no_ktp" value="{{ old('no_ktp', $data->no_ktp ?? '') }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" name="email" >
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="jenis_kelamin" placeholder="L/P">
                    </div>
                    <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" name="tanggal_lahir" value="2004-03-03">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Tempat Lahir</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="tempat_lahir" >
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="alamat" rows="3"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Kota</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="kota" >
                    </div>
                    <label class="col-sm-3 col-form-label">Kode Pos</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" name="kode_pos" >
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Nomor Ponsel</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="no_hp" >
                    </div>
                    <label class="col-sm-3 col-form-label">Nomor Telepon</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="telp_rumah" >
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Facebook</label>
                    <div class="col-sm-9">
                        <input type="url" class="form-control" name="facebook" placeholder="Masukkan link facebook">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Youtube</label>
                    <div class="col-sm-9">
                        <input type="url" class="form-control" name="youtube" placeholder="Masukkan link youtube">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Instagram</label>
                    <div class="col-sm-9">
                        <input type="url" class="form-control" name="instagram" placeholder="Masukkan link instagram">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Tiktok</label>
                    <div class="col-sm-9">
                        <input type="url" class="form-control" name="tiktok" placeholder="Masukkan link tiktok">
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection
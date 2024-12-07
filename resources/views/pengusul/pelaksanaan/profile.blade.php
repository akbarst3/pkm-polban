@extends('pengusul/pelaksanaan/master')

@section('konten')
    <style>
        .bg-upper {
            background-color: #EE820D;
        }
    </style>
    <div class="container d-flex flex-column align-items-center p-4" style="background-color: #f9f9f9;">
        <!-- Card 1 -->
        <div class="card shadow rounded mb-4 w-100" style="max-width: 100vw;">
            <div class="upper bg-upper" style="height: 100px;"></div>
            <div class="user text-center position-relative">
                <div class="profile rounded-circle border border-white bg-light overflow-hidden mx-auto"
                    style="width: 90px; height: 90px; margin-top: -45px;">
                    <label for="foto_profil" class="w-100 h-100 d-flex justify-content-center align-items-center"
                        style="cursor: pointer;">
                        <img id="profileImage" src="{{ route('pengusul.pelaksanaan.profile.open-photo', ['path' => $data->pengusul->foto_profil]) ?? asset('images/person.png') }}"
                            alt="User Profile" class="w-100 h-100 object-fit-cover">
                    </label>
                </div>
            </div>

            <div class="text-center mt-3">
                <h4 class="mb-0">{{ $data->nama }}</h4>
                <span class="text-muted d-block mb-2">Pengusul - Mahasiswa</span>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="card shadow rounded w-100" style="max-width: 100vw;">
            <div class="card-body">
                <form action="{{ route('pengusul.pelaksanaan.profile.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <input type="file" id="foto_profil" name="foto_profil" accept="image/*" style="display: none;"
                        onchange="previewImage(event)">

                    <!-- Nama -->
                    <div class="form-group mb-3">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama }}"
                            readonly>
                    </div>

                    <!-- Nomor KTP -->
                    <div class="form-group mb-3">
                        <label for="no_ktp">Nomor KTP</label>
                        <input type="text" class="form-control" id="no_ktp" name="no_ktp"
                            value="{{ old('no_ktp', $data->pengusul->no_ktp ?? '') }}">
                        @error('no_ktp')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', $data->pengusul->email ?? '') }}">
                        @error('email')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin dan Tanggal Lahir -->
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                <option value="" disabled
                                    {{ old('jenis_kelamin', $data->pengusul->jenis_kelamin ?? '') == '' ? 'selected' : '' }}>
                                    Pilih Jenis Kelamin</option>
                                <option value="L"
                                    {{ old('jenis_kelamin', $data->pengusul->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="P"
                                    {{ old('jenis_kelamin', $data->pengusul->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', $data->pengusul->tanggal_lahir ?? '') }}">
                            @error('tanggal_lahir')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="form-group mb-3">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                            value="{{ old('tempat_lahir', $data->pengusul->tempat_lahir ?? '') }}">
                        @error('tempat_lahir')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="form-group mb-3">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ old('alamat', $data->pengusul->alamat ?? '') }}</textarea>
                        @error('alamat')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kota dan Kode Pos -->
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label for="kota">Kota</label>
                            <input type="text" class="form-control" id="kota" name="kota"
                                value="{{ old('kota', $data->pengusul->kota ?? '') }}">
                            @error('kota')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="kode_pos">Kode Pos</label>
                            <input type="number" class="form-control" id="kode_pos" name="kode_pos"
                                value="{{ old('kode_pos', $data->pengusul->kode_pos ?? '') }}">
                            @error('kode_pos')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Nomor Ponsel dan Telepon -->
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label for="no_hp">Nomor Ponsel</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp"
                                value="{{ old('no_hp', $data->pengusul->no_hp ?? '') }}">
                            @error('no_hp')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="telp_rumah">Nomor Telepon</label>
                            <input type="text" class="form-control" id="telp_rumah" name="telp_rumah"
                                value="{{ old('telp_rumah', $data->pengusul->telp_rumah ?? '') }}">
                            @error('telp_rumah')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-50">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = document.getElementById('profileImage');
                img.src = e.target.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection

@extends('pengusul/master')

@section('konten')
    <div class="m-5 p-4 bg-white rounded shadow-sm">
        <form
            action="{{ $isEdit == false ? route('pengusul.edit-usulan.tambah-anggota') : route('pengusul.edit-usulan.edit-anggota', $data['anggota']->nim) }}"
            method="POST" class="needs-validation" novalidate style="max-width: 70%; margin: 0;">
            @csrf
            @if ($isEdit == true)
                @method('PUT')
            @endif
            <div class="mb-4">
                <h5>{{ $title }}</h5>
                <div class="row mb-4 mt-4">
                    <div class="col-md-3 text-end">
                        <p>Program Studi</p>
                    </div>
                    <div class="col-md-9">
                        <select class="form-select" id="programStudi" name="programStudi" required>
                            <option value="" selected disabled>Pilih Program Studi</option>
                            @foreach ($data['prodi'] as $item)
                                <option value="{{ $item->kode_prodi }}" @if ($isEdit && $data['prodiAnggota']->kode_prodi == $item->kode_prodi) selected @endif>
                                    {{ $item->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                        <small class="invalid-feedback">
                            Program studi wajib dipilih.
                        </small>
                    </div>
                </div>

                <div class="row mb-4 mt-4">
                    <div class="col-md-3 text-end">
                        <p>NIM</p>
                    </div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="text" class="form-control no-char" id="nim" name="nim"
                                placeholder="Masukkan NIM" value="{{ $isEdit ? $data['anggota']->nim : '' }}" required>
                            <small class="invalid-feedback">
                                NIM wajib diisi.
                            </small>
                        </div>
                        @error('nim')
                            <small class="error text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4 mt-4">
                    <div class="col-md-3 text-end">
                        <p>Nama</p>
                    </div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukkan Nama" value="{{ $isEdit ? $data['anggota']->nama : '' }}" required>
                            <div class="invalid-feedback">
                                Nama Mahasiswa wajib diisi.
                            </div>
                        </div>
                        @error('nama')
                            <small class="error text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4 mt-4">
                    <div class="col-md-3 text-end">
                        <p>Tahun Masuk</p>
                    </div>
                    <div class="col-md-9">
                        <select class="form-select" id="tahunMasuk" name="tahunMasuk" required>
                            <option value="" selected disabled>Pilih Tahun</option>
                            @for ($i = 2020; $i <= 2024; $i++)
                                <option value="{{ $i }}" @if ($isEdit && $data['anggota']->angkatan == $i) selected @endif>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                        <small class="invalid-feedback">
                            Tahun masuk wajib dipilih.
                        </small>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <a class="btn bg-secondary text-white" href="{{ route('pengusul.edit-usulan') }}"> Kembali
                    </a>
                    <button class="btn bg-success text-white" type="submit" style="margin-left: 10px;">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

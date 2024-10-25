<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Usulan Baru</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <form action="{{ route('operator.usulan.baru.store') }}" method="POST" class="needs-validation"
                        novalidate style="max-width: 70%; margin: 0;">
                        @csrf
                        <div class="mb-4">
                            <h5>DATA MAHASISWA</h5>
                            <div class="row mb-4 mt-4">
                                <div class="col-md-3 text-end">
                                    <p>Program Studi</p>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-select" id="programStudi" name="programStudi" required>
                                        <option value="" selected disabled>Pilih Program Studi</option>
                                        @foreach ($prodi as $item)
                                            <option value="{{ $item->kode_prodi }}"
                                                {{ old('programStudi') == $item->kode_prodi ? 'selected' : '' }}>
                                                {{ $item->nama_prodi }}</option>
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
                                            placeholder="Masukkan NIM" value="{{ old('nim') }}" required>
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
                                        <input type="text" class="form-control" id="namaMahasiswa" name="namaMahasiswa"
                                            placeholder="Masukkan Nama" value="{{ old('namaMahasiswa') }}" required>
                                        <div class="invalid-feedback">
                                            Nama Mahasiswa wajib diisi.
                                        </div>
                                    </div>
                                    @error('namaMahasiswa')
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
                                            <option value="{{ $i }}"
                                                {{ old('tahunMasuk') == $i ? 'selected' : '' }}>{{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                    <small class="invalid-feedback">
                                        Program studi wajib dipilih.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5>DATA PROPOSAL USULAN</h5>
                            <div class="row mb-4 mt-4">
                                <div class="col-md-3 text-end">
                                    <p>Judul</p>
                                </div>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <textarea class="form-control" id="judulProposal" name="judulProposal" rows="3" required>{{ old('judulProposal') }}</textarea>
                                        <div class="invalid-feedback">
                                            Judul wajib diisi.
                                        </div>
                                    </div>
                                    @error('judulProposal')
                                        <small class="error text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4 mt-4">
                                <div class="col-md-3 text-end">
                                    <p>Skema PKM</p>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-select" id="skemaPKM" name="skemaPKM" required>
                                        <option value="" selected disabled>Skema PKM</option>
                                        @foreach ($skema as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('skemaPKM') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama_skema }}</option>
                                        @endforeach
                                    </select>
                                    <small class="invalid-feedback">
                                        Skema wajib dipilih.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5>DOSEN PENDAMPING</h5>
                            <div class="row mb-4 mt-4">
                                <div class="col-md-3 text-end">
                                    <p>NIDN</p>
                                </div>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control no-char" id="nidn" name="nidn"
                                            value="{{ old('nidn') }}" required>
                                        <button type="button" class="btn btn-primary cari"
                                            style="border-radius: 5px;">Cari</button>
                                        <small class="invalid-feedback">
                                            NIDN dospem wajib diisi.
                                        </small>
                                    </div>
                                    @error('nidn')
                                        <small class="error text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4 mt-4">
                                <div class="col-md-3 text-end">
                                    <p>Nama Dosen</p>
                                </div>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="namaDosen" id="namaDosen"
                                            value="{{ old('namaDosen') }}" disabled required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4 mt-4">
                                <div class="col-md-3 text-end">
                                    <p>Program Studi</p>
                                </div>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="programStudiDosen"
                                            name="programStudiDosen" disabled required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4 mt-4">
                                <div class="col-md-3 text-end">
                                    <p>Nomor Hp</p>
                                </div>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="noHpDosen" name="noHpDosen"
                                            disabled required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4 mt-4">
                                <div class="col-md-3 text-end">
                                    <p>Email</p>
                                </div>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="emailDosen" name="emailDosen"
                                            disabled required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <a class="btn bg-secondary text-white" href="{{ route('operator.usulan.baru') }}"> Kembali
                            </a>
                            <button class="btn bg-success text-white" type="submit" style="margin-left: 10px;">
                                Simpan
                            </button>
                        </div>
                    </form>
                    @if (session()->has('error'))
                        <script>
                            Swal.fire({
                                title: 'Perhatian!',
                                text: "{{ session('error') }}",
                                icon: 'warning',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#003c72',
                            });
                        </script>
                    @endif
                </div> <!-- End of container -->
            </div>
        </div>
    </div>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nidnInput = document.getElementById('nidn');
            const cariButton = document.querySelector('.cari');
            const namaDosenInput = document.getElementById('namaDosen');
            const programStudiDosenInput = document.getElementById('programStudiDosen');
            const noHpDosenInput = document.getElementById('noHpDosen');
            const emailDosenInput = document.getElementById('emailDosen');
            let isCari = false
            const form = document.querySelector('.needs-validation')

            nidnInput.addEventListener('input', function() {
                namaDosenInput.value = '';
                programStudiDosenInput.value = '';
                noHpDosenInput.value = '';
                emailDosenInput.value = '';
            });

            cariButton.addEventListener('click', function(e) {
                e.preventDefault();

                const nidn = nidnInput.value;

                const xhr = new XMLHttpRequest();
                xhr.open('POST', "{{ route('operator.identitas.usulan.find') }}", true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const data = JSON.parse(xhr.responseText);
                        namaDosenInput.value = data.nama;
                        programStudiDosenInput.value = data.program_studi;
                        noHpDosenInput.value = data.no_hp;
                        emailDosenInput.value = data.email;
                    } else {
                        if (xhr.status === 404) {
                            const data = JSON.parse(xhr.responseText);
                            Swal.fire({
                                title: 'Error!',
                                text: data.message,
                                icon: 'error',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#003c72',
                            });
                        } else {
                            Swal.fire({
                                title: 'Oops!',
                                text: "Something went wrong",
                                icon: 'error',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#003c72',
                            });
                        }
                    }
                };

                isCari = true;
                xhr.send('nidn=' + nidn + '&_token={{ csrf_token() }}');
            });

            form.addEventListener('submit', function(event) {
                if (!isCari) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Perhatian!',
                        text: "Lakukan pencarian dosen terlebih dahulu!",
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                }
            })

            (function() {
                'use strict'
                var forms = document.querySelectorAll('.needs-validation')
                Array.prototype.slice.call(forms)
                    .forEach(function(form) {
                        form.addEventListener('submit', function(event) {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }
                            form.classList.add('was-validated')
                        }, false)
                    })
            })()

            document.querySelectorAll('.no-char').forEach(function(element) {
                element.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            });
        });
    </script>
@endsection

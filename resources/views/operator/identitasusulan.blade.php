@extends('operator/master')

@section('konten')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <script>
        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    </script>

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="p-4 bg-white rounded shadow-sm">
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5>DATA MAHASISWA</h5>
                        </div>
                    </div>

                    <form action="{{ route('operator.identitasusulan') }}" method="POST">

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
                                            @foreach ($pt_prodi as $item)
                                                <option value="{{ $item->kode_prodi }}">{{ $item->nama_prodi }}</option>
                                            @endforeach
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
                                            <input type="text" class="form-control" id="namaMahasiswa"
                                                name="namaMahasiswa" placeholder="Masukkan Nama">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-3 text-end">
                                        <p>Tahun Masuk</p>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="tahunMasuk" id="">
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
                                                <input type="text" class="form-control" id="usernameMahasiswa"
                                                    name="usernameMahasiswa" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <p class="mb-0 text-end">Password Akun Mahasiswa</p>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="passwordMahasiswa"
                                                    name="passwordMahasiswa" disabled>
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
                                            <input type="text" class="form-control" id="judulProposal"
                                                name="judulProposal">
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
                                            @foreach ($skema as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_skema }}</option>
                                            @endforeach
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
                                            @csrf
                                            <input type="text" class="form-control" id="nidn" name="nidn">
                                            <button class="btn btn-primary cari">Cari</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-3 text-end">
                                        <p>Nama Dosen</p>
                                    </div>
                                    <div class="col-md-9">

                                        <div class="input-group">
                                            <input type="text" class="form-control" id="namaDosen" name="namaDosen"
                                                disabled placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-3 text-end">
                                        <p>Program Studi</p>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="programStudiDosen"
                                                name="programStudiDosen" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-3 text-end">
                                        <p>Nomor Hp</p>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="noHpDosen" name="noHpDosen"
                                                disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-3 text-end">
                                        <p>Email</p>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="emailDosen" name="emailDosen"
                                                disabled>
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
                                                <input type="text" class="form-control" id="usernameDosen"
                                                    name="usernameDosen" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <p class="mb-0 text-end">Password Akun Dosen</p>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="passwordDosen"
                                                    name="passwordDosen" disabled>
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
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const nidnInput = document.getElementById('nidn');
                            const cariButton = document.querySelector('.cari');
                            const namaDosenInput = document.getElementById('namaDosen');
                            const programStudiDosenInput = document.getElementById('programStudiDosen');
                            const noHpDosenInput = document.getElementById('noHpDosen');
                            const emailDosenInput = document.getElementById('emailDosen');

                            nidnInput.addEventListener('input', function() {
                                namaDosenInput.value = '';
                                programStudiDosenInput.value = '';
                                noHpDosenInput.value = '';
                                emailDosenInput.value = '';
                            });

                            cariButton.addEventListener('click', function(e) {
                                e.preventDefault(); // Mencegah form submit

                                const nidn = nidnInput.value;

                                const xhr = new XMLHttpRequest();
                                xhr.open('POST', "{{ route('operator.dosen') }}", true);
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
                                            alert(xhr.responseJSON
                                            .message); // Menampilkan pesan jika data tidak ditemukan
                                        } else {
                                            alert(
                                            'Terjadi kesalahan, silakan coba lagi.'); // Menampilkan pesan kesalahan umum
                                        }
                                    }
                                };

                                xhr.send('nidn=' + nidn + '&_token={{ csrf_token() }}');
                            });
                        });
                    </script>



                </div> <!-- End of container -->
            </div>
        </div>
    </div>
@endsection

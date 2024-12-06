@extends('pengusul/master')
@section('konten')
    <div class="container my-3">
        <h3 class="mb-4">Edit Usulan : Judul PKM</h3>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow rounded">
                    <div class="card-header bg-primary text-white">Identitas Pengusul</div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-3 text-end fw-bold">Nama Pengusul</div>
                            <div class="col-md-8 ms-4">: {{ $data['mahasiswa']->nama }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3 text-end fw-bold">NIM</div>
                            <div class="col-md-8 ms-4">: {{ $data['mahasiswa']->nim }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3 text-end fw-bold">Program Studi</div>
                            <div class="col-md-8 ms-4">: {{ $data['prodi'][0]->nama_prodi }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3 text-end fw-bold">Angkatan</div>
                            <div class="col-md-8 ms-4">: {{ $data['mahasiswa']->angkatan }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex align-items-stretch my-5">
                <div class="col-md-6">
                    <div class="card mb-4 h-100 shadow rounded">
                        <div class="card-header bg-primary text-white">Data Mahasiswa</div>
                        <div class="card-body">
                            <form action="{{ route('pengusul.identitas-usulan.edit-usulan.edit-mhs', $data['mahasiswa']->nim) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <label for="address">Alamat Rumah</label>
                                    <textarea rows="4" class="form-control" id="address" name="alamatMhs"
                                        {{ $data['pengusul']->alamat ? 'disabled' : '' }}>{{ $data['pengusul']->alamat ?? '' }}</textarea>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">No HP</label>
                                            <input type="text" class="form-control" id="phone" name="noHpMhs"
                                                value="{{ $data['pengusul']->no_hp ?? '' }}"
                                                {{ $data['pengusul']->no_hp ? 'disabled' : '' }}>
                                        </div>
                                        @error('noHpMhs')
                                            <small class="error text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_home">No Telepon Rumah</label>
                                            <input type="text" class="form-control" id="phone_home" name="noTelpRumahMhs"
                                                value="{{ $data['pengusul']->telp_rumah ?? '' }}"
                                                {{ $data['pengusul']->telp_rumah ? 'disabled' : '' }}>
                                        </div>
                                        @error('noTelpRumahMhs')
                                            <small class="error text-danger">{{ $message }}</small>
                                        @enderror

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="emailMhs"
                                        value="{{ $data['pengusul']->email ?? '' }}"
                                        {{ $data['pengusul']->email ? 'disabled' : '' }}>
                                </div>
                                @error('email')
                                    <small class="error text-danger">{{ $message }}</small>
                                @enderror
                                <div class="mt-5 d-flex justify-content-end">
                                    <button class="btn btn-primary" type="submit"
                                        {{ ($data['pengusul']->no_hp ?? '') && ($data['pengusul']->telp_rumah ?? '') && ($data['pengusul']->email ?? '') && ($data['pengusul']->alamat ?? '') ? 'disabled' : '' }}>
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4 h-100 shadow rounded">
                        <div class="card-header bg-primary text-white">Data Dosen Pendamping</div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p><strong>Nama Dosen</strong></p>
                                        <p>{{ $data['dospem']->nama }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p><strong>NIDN</strong></p>
                                        <p>{{ $data['dospem']->kode_dosen }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p><strong>No HP</strong></p>
                                        <p>{{ $data['dospem']->no_hp }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <p><strong>No Telepon Rumah</strong></p>
                                        <p>-</p>
                                    </div>
                                </div>
                            </div>
                            <p><strong>Email</strong></p>
                            <p>{{ $data['dospem']->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <div class="card mb-4 shadow rounded">
                    <div class="card-header bg-primary text-white">Data Usulan</div>
                    <div class="card-body">
                        <form action="{{ route('pengusul.identitas-usulan.edit-usulan.edit-pkm', $data['pkm']->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="skema">Skema</label>
                                <input type="text" class="form-control" id="skema"
                                    value="PKM {{ $data['skema']->nama_skema }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="judul">Judul</label>
                                <textarea class="form-control" id="judul" rows="4" readonly>{{ $data['pkm']->judul }}</textarea>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dana_kemahasiswaan">Dana Usulan ke Kemdikbudristek</label>
                                        <input type="text" class="form-control" id="dana_kemdikbud"
                                            name="dana_kemdikbud" value="{{ $data['pkm']->dana_kemdikbud ?? '' }}"
                                            {{ $data['pkm']->dana_kemdikbud ? 'disabled' : '' }} oninput="updateDana()"
                                            required>
                                    </div>
                                    @error('dana_kemdikbud')
                                        <small class="error text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dana_perguruan_tinggi">Dana Tambahan Perguruan Tinggi</label>
                                        <input type="text" class="form-control" id="dana_pt" name="dana_pt"
                                            value="{{ $data['pkm']->dana_pt ?? '' }}"
                                            {{ $data['pkm']->dana_pt ? 'disabled' : '' }} oninput="updateDana()" required>
                                    </div>
                                    @error('dana_pt')
                                        <small class="error text-danger">{{ $message }}</small>
                                    @enderror

                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dana_lain">Dana Instansi Lain (Opsional)</label>
                                        <input type="text" class="form-control" id="dana_lain" name="dana_lain"
                                            value="{{ $data['pkm']->dana_lain ?? '' }}"
                                            {{ $data['pkm']->dana_lain || $data['pkm']->dana_kemdikbud ? 'disabled' : '' }}
                                            oninput="updateDana()">
                                    </div>
                                    @error('dana_lain')
                                        <small class="error text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="instansi_lain">Nama Instansi Lain (Sebutkan nama instansinya)</label>
                                        <input type="text" class="form-control" id="instansi_lain"
                                            name="instansi_lain" value="{{ $data['pkm']->instansi_lain ?? '' }}"
                                            {{ $data['pkm']->instansi_lain || $data['pkm']->dana_kemdikbud ? 'disabled' : '' }}>
                                    </div>
                                    @error('instansi_lain')
                                        <small class="error text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dana_total">Dana Usulan Total</label>
                                        <input type="text" class="form-control" id="dana_total" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit"
                                    {{ ($data['pkm']->dana_kemdikbud ?? '') && ($data['pkm']->dana_pt ?? '') ? 'disabled' : '' }}>
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 shadow rounded">
                    <div class="card-header bg-primary text-white">Anggota</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Program Studi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['anggota'] as $index => $person)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $person->nama }}</td>
                                            <td>{{ $person->prodi->nama_prodi }}</td>
                                            <td>{{ $index == 0 ? 'Ketua Kelompok' : 'Anggota ' . $index }}</td>
                                            <td>
                                                @if ($index != 0)
                                                    <div class="d-flex justify-content-start">
                                                        <a class="btn btn-primary btn-sm mx-2"
                                                            href="{{ route('pengusul.identitas-usulan.edit-usulan.edit-anggota', $person->nim) }}">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <form
                                                            action="{{ route('pengusul.identitas-usulan.edit-usulan.hapus-anggota', $person->nim) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-sm">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            @php
                                $jumlahAnggota = count($data['anggota']);
                            @endphp

                            @if ($jumlahAnggota < 5)
                                <button type="button" class="btn btn-primary" id="tambahAnggota">
                                    <a href="{{ route('pengusul.identitas-usulan.edit-usulan.tambah-anggota') }}"
                                        style="color:white; text-decoration: none;">+
                                        Tambah Anggota</a>
                                </button>
                            @else
                                <button type="button" class="btn btn-primary" id="tambahAnggota" disabled
                                    title="Jumlah anggota sudah maksimal">
                                    <span style="color:white;">+
                                        Tambah Anggota</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 shadow rounded">
                    <div class="card-header bg-primary text-white">Luaran</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Luaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['luarans']['skemaluaran'] as $i => $skema)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $skema['nama_luaran'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-5 d-flex justify-content-end">
                            <a href="{{ route('pengusul.identitas-usulan.index') }}" class="btn btn-secondary"> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const danaKemdikbudField = document.getElementById("dana_kemdikbud");
            const danaPtField = document.getElementById("dana_pt");
            const danaLainField = document.getElementById("dana_lain");
            const danaTotalField = document.getElementById("dana_total");
            const instansiLainField = document.getElementById("instansi_lain");

            if (danaKemdikbudField.value) {
                danaKemdikbudField.value = formatRupiah(removeFormat(danaKemdikbudField.value));
            }
            if (danaPtField.value) {
                danaPtField.value = formatRupiah(removeFormat(danaPtField.value));
            }
            if (danaLainField && danaLainField.value) {
                danaLainField.value = formatRupiah(removeFormat(danaLainField.value));
            }
            updateDana();
        });

        function updateDana() {
            const dana_kemdikbud = parseInt(removeFormat(document.getElementById("dana_kemdikbud").value)) || 0;
            const dana_pt = parseInt(removeFormat(document.getElementById("dana_pt").value)) || 0;
            const dana_lain = parseInt(removeFormat(document.getElementById("dana_lain") ? document.getElementById(
                "dana_lain").value : 0)) || 0;

            const totalDana = dana_kemdikbud + dana_pt + dana_lain;
            document.getElementById("dana_total").value = formatRupiah(totalDana);

            const instansiLainField = document.getElementById("instansi_lain");
            if (dana_lain > 0) {
                instansiLainField.required = true;
            } else {
                instansiLainField.required = false;
            }
        }

        function formatRupiah(angka) {
            return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function removeFormat(rupiah) {
            return rupiah.replace(/[^\d]/g, "");
        }

        document.getElementById("dana_kemdikbud").addEventListener("input", function() {
            this.value = formatRupiah(removeFormat(this.value));
            updateDana();
        });

        document.getElementById("dana_pt").addEventListener("input", function() {
            this.value = formatRupiah(removeFormat(this.value));
            updateDana();
        });

        if (document.getElementById("dana_lain")) {
            document.getElementById("dana_lain").addEventListener("input", function() {
                this.value = formatRupiah(removeFormat(this.value));
                updateDana();
            });
        }

        function confirmDeletion(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#003c72',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
        const deleteButtons = document.querySelectorAll('.btn-danger');
        deleteButtons.forEach(button => {
            button.addEventListener('click', confirmDeletion);
        });
    </script>
@endsection

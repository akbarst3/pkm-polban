<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Pengesahan Usulan PKM</title>
    <style>
        /* Custom CSS for letter layout */
        .letter-container {
            width: 70%;
            margin: auto;
            padding: 2rem;
            border: 1px solid #000;
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.5;
        }

        .letter-header {
            text-align: center;
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .section-title {
            font-weight: bold;
            margin-top: 1rem;
        }

        .text-right {
            text-align: right;
        }

        .approval-signature {
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
        }

        .signature-block {
            width: 40%;
            text-align: center;
        }

        .signature-block p {
            margin: 0.5rem 0;
        }

        .field {
            padding-left: 1rem;
            margin-bottom: 0.5rem;
        }

        /* Styling for inline input fields to blend with text */
        .inline-input {
            border: none;
            border-bottom: 1px solid #000;
            width: auto;
            display: inline;
            padding: 0;
            font-family: inherit;
            font-size: inherit;
            text-align: center;
        }

        .inline-input:focus {
            outline: none;
            box-shadow: none;
            border-color: #000;
        }
    </style>
</head>

<body>
    @extends('pengusul/master')

    @section('konten')
        @if (session('success'))
            <script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6',
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d33',
                });
            </script>
        @endif
        <form action="{{ route('pengusul.pengesahan.store') }}" method="POST">
            @csrf
            <div class="letter-container">
                <div class="letter-header">
                    PENGESAHAN USULAN PKM {{ strtoupper($viewData['skemaPkm']) }}
                </div>

                <!-- 1. Judul Kegiatan -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="section-title col-md-6">
                                <p>1. Judul Kegiatan</p>
                            </div>
                            <div class="field col-md-6">
                                <p>: {{ $viewData['judulPkm'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Bidang Kegiatan -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="section-title col-md-6">
                                <p>2. Bidang Kegiatan</p>
                            </div>
                            <div class="field col-md-6">
                                <p>: {{ $viewData['skemaPkm'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Ketua Pelaksana Kegiatan -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="section-title">3. Ketua Pelaksana Kegiatan</div>
                            <div class="field col-md-6 px-4 m-0">
                                <p>a. Nama Lengkap</p>
                            </div>
                            <div class="field col-md-6">
                                <p>: {{ $viewData['namaPengusul'] }}</p>
                            </div>

                            <div class="field col-md-6 px-4 m-0">
                                <p>b. NIM</p>
                            </div>
                            <div class="field col-md-6">
                                <p>: {{ $viewData['nimPengusul'] }}</p>
                            </div>

                            <div class="field col-md-6 px-4 m-0">
                                <p>c. Program Studi</p>
                            </div>
                            <div class="field col-md-6">
                                <p>: {{ $viewData['namaProdi'] }}</p>
                            </div>

                            <div class="field col-md-6 px-4 m-0">
                                <p>d. Perguruan Tinggi</p>
                            </div>
                            <div class="field col-md-6">
                                <p>: {{ $viewData['namaPt'] }}</p>
                            </div>

                            <div class="field col-md-6 px-4 m-0">
                                <p>e. Alamat Rumah dan No Telp/HP</p>
                            </div>
                            <div class="field col-md-6">
                                <p>: {{ $viewData['alamatPengusul'] }}, {{ $viewData['noHpPengusul'] }}, {{ $viewData['telpRumahPengusul'] }}</p>
                            </div>

                            <div class="field col-md-6 px-4 m-0">
                                <p>e. Email</p>
                            </div>
                            <div class="field col-md-6">
                                <p>: {{ $viewData['emailPengusul'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Anggota Pelaksana Kegiatan/Penulis -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="section-title col-md-6">4. Anggota Pelaksana Kegiatan/Penulis</div>
                            <div class="field col-md-6">: {{ $viewData['anggota'] }}</div>
                        </div>
                    </div>
                </div>

                <!-- 5. Dosen Pendamping -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="section-title">5. Dosen Pendamping</div>
                            <div class="field col-md-6 px-4 m-0">
                                <p>a. Nama Lengkap</p>
                            </div>
                            <div class="field col-md-6">
                                <p>: {{ $viewData['namaDospem'] }}</p>
                            </div>
                            <div class="field col-md-6 px-4 m-0">
                                <p>b. NIDN</p>
                            </div>
                            <div class="field col-md-6">
                                <p>: {{ $viewData['nidn'] }}</p>
                            </div>
                            <div class="field col-md-6 px-4 m-0">
                                <p>c. No. HP</p>
                            </div>
                            <div class="field col-md-6">
                                <p>: {{ $viewData['noHpDospem'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 6. Dana Usulan -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="section-title">6. Dana Usulan</div>
                            <div class="field col-md-6 px-4 m-0">
                                <p>a. Kemendikbudristek</p>
                            </div>
                            <div class="field col-md-6">
                                <p>: Rp {{ number_format($viewData['danaKemdikbud'], 0, ',', '.') }}</p>
                            </div>
                            <div class="field col-md-6 px-4 m-0">
                                <p>b. Perguruan Tinggi</p>
                            </div>
                            <div class="field col-md-6">
                                <p>: Rp {{ number_format($viewData['danaPt'], 0, ',', '.') }}</p>
                            </div>
                            <div class="field col-md-6 px-4 m-0">
                                <p>c. Sumber Instansi Lain</p>
                            </div>
                            <div class="field col-md-6">
                                <p>: Rp {{ number_format($viewData['danaLain'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 7. Jangka Waktu Pelaksanaan -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="section-title col-md-6">7. Jangka Waktu Pelaksanaan</div>
                            <div class="field col-md-6">:
                                <input type="number" class="inline-input @error('waktu_pelaksanaan') is-invalid @enderror"
                                    name="waktu_pelaksanaan" min="1"
                                    value="{{ old('waktu_pelaksanaan', $viewData['pengesahan']->waktu_pelaksanaan ?? '') }}"
                                    {{ $viewData['pengesahan'] ? 'disabled' : '' }}>
                                bulan
                                @error('waktu_pelaksanaan')
                                    <div class="invalid-feedback d-inline">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Approval section -->
                <div class="text-right mt-4">
                    <input type="text" class="inline-input @error('kota_pengesahan') is-invalid @enderror"
                        name="kota_pengesahan"
                        value="{{ old('kota_pengesahan', $viewData['pengesahan']->kota_pengesahan ?? '') }}"
                        {{ $viewData['pengesahan'] ? 'disabled' : '' }}>
                    @error('kota_pengesahan')
                        <div class="invalid-feedback d-inline">{{ $message }}</div>
                    @enderror, {{ date('d F Y') }}
                </div>
                <div class ="approval-signature">
                    <div class="signature-block"></div>
                    <div class="signature-block">
                        <p>Ketua Pelaksana Kegiatan,</p>
                        <br><br><br>
                        <u>
                            <p>({{ $viewData['namaPengusul'] }})<br></p>
                        </u>
                        NIM. {{ $viewData['nimPengusul'] }}
                    </div>
                </div>

                <!-- Signature section -->
                <div class="approval-signature">
                    <div class="signature-block">
                        <p>Menyetujui,</p>
                        <p>
                            <input type="text" class="inline-input @error('jabatan') is-invalid @enderror" name="jabatan"
                                value="{{ old('jabatan', $viewData['pengesahan']->jabatan ?? '') }}"
                                {{ $viewData['pengesahan'] ? 'disabled' : '' }}>
                            @error('jabatan')
                            <div class="invalid-feedback d-inline">{{ $message }}</div>
                        @enderror
                        </p>
                        <br><br>
                        <p>
                            <input type="text" class="inline-input @error('nama_pengesahan') is-invalid @enderror"
                                name="nama_pengesahan"
                                value="{{ old('nama_pengesahan', $viewData['pengesahan']->nama ?? '') }}"
                                {{ $viewData['pengesahan'] ? 'disabled' : '' }}>
                            @error('nama_pengesahan')
                            <div class="invalid-feedback d-inline">{{ $message }}</div>
                        @enderror
                        </p>
                        <p>NIP/NIK.
                            <input type="text" class="inline-input @error('NIP') is-invalid @enderror" name="NIP"
                                value="{{ old('NIP', $viewData['pengesahan']->NIP ?? '') }}"
                                {{ $viewData['pengesahan'] ? 'disabled' : '' }}>
                            @error('NIP')
                            <div class="invalid-feedback d-inline">{{ $message }}</div>
                        @enderror
                        </p>
                    </div>

                    <div class="signature-block">
                        <p>Dosen Pendamping,</p>
                        <br><br><br>
                        <u>
                            <p>({{ $viewData['namaDospem'] }})</p>
                        </u>
                        <p>NIDN. {{ $viewData['nidn'] }}</p>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-4 d-flex justify-content-end gap-2">
                    @if ($viewData['pengesahan'] == null)
                        <a href="{{ route('pengusul.identitas-usulan') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    @else
                        <a href="{{ route('pengusul.identitas-usulan') }}" class="btn btn-secondary">Kembali</a>
                    @endif
                </div>
            </div>
        </form>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @endsection
</body>

</html>

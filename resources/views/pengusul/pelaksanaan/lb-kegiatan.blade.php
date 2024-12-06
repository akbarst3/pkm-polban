@extends('pengusul/pelaksanaan/master')

@section('konten')
    <style>
        #detailLogbookBtn {
            margin-top: 20px;
        }
    </style>
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="card shadow rounded p-4 flex-grow-1">
                <p class="h5 mb-0">Logbook Kegiatan</p>
            </div>
        </div>
    </div>

    <div class="container my-1">
        <div class="card shadow rounded p-4">
            <h6 class="mb-4 border-bottom">{{ $data['pkm']->judul }}</h6>

            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Skema:</strong>
                    <p>{{ $data['pkm']->skema->nama_skema }}</p>
                    <strong>Tahun:</strong>
                    <p>{{ $data['pkm']->created_at->year }}</p>
                </div>
                <div class="col-md-4">
                    <strong>Pendanaan (Rp)</strong>
                    <p class="text-success">Rp.
                        {{ number_format($data['pkm']->dana_kemdikbud + $data['pkm']->dana_pt + $data['pkm']->lain) }}</p>
                    <strong>Capaian</strong>
                    <p class="{{ $data['logbook_kegiatan']->count() > 0 ? 'text-success' : 'text-danger' }}">
                        {{ number_format(round($data['capaian']), 2) }}%
                    </p>
                </div>
                <div class="col-md-4">
                    <strong>Total Waktu (Menit)</strong>
                    <p class="text-success">{{ $data['totalWaktu'] }}</p>
                    <strong>Rekomendasi SKS</strong>
                    <p>2 SKS
                    </p>
                </div>
            </div>

            <hr>

            <div class="mt-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="bg-warning p-3 rounded text-white shadow h-100">
                            <strong>Perguruan Tinggi</strong>
                            <span class="d-block mt-2">{{ $data['perguruanTinggi']->nama_pt }}</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="bg-success p-3 rounded text-white shadow h-100">
                            <strong>Ketua</strong>
                            <span class="d-block mt-2">{{ $data['mahasiswa']->nama }} -
                                {{ $data['mahasiswa']->nim }}</span>
                            <p class="mb-1">{{ $data['prodi']->nama_prodi }} - {{ $data['prodi']->kode_prodi }}</p>
                            <strong>Kelompok:</strong>
                            <ul class="ps-3 mb-0">
                                @foreach ($data['mahasiswas'] as $mahasiswa)
                                    @if ($mahasiswa->nim != $data['mahasiswa']->nim)
                                        <li>{{ $mahasiswa->nama }} - {{ $mahasiswa->nim }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="bg-primary p-3 rounded text-white shadow h-100">
                            <strong>Dosen</strong>
                            <span class="d-block mt-2">{{ $data['dospem']->nama }}</span>
                            <p>{{ $data['dospem']->kode_dosen }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @if ($data['logbook_kegiatan']->count() > 0)
                <div class="text-end mt-4">
                    <button id="detailLogbookBtn" class="btn btn-primary">
                        <i class="fas fa-list"></i> Lebih Detail
                    </button>
                </div>
            @endif

        </div>
    </div>
    @if ($data['logbook_kegiatan']->count() === 0)
        <div class="container my-4">
            <div class="alert alert-info text-center" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                Belum ada logbook kegiatan. Silakan tambahkan logbook pertama Anda.
            </div>

            <div class="text-center">
                <a href="{{ route('pengusul.pelaksanaan.logbook-kegiatan.tambah-logbook') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Logbook Pertama
                </a>
            </div>
        </div>
    @endif

    <div id="logbookDetail" class="container mt-4" style="display: none;">
        <div class="card shadow rounded p-4">
            <div class="d-flex justify-content-end mb-3">
                <button id="closeLogbookDetailBtn" class="btn btn-secondary me-2">
                    <i class="fas fa-times"></i> Tutup
                </button>

                <a href="{{ route('pengusul.pelaksanaan.logbook-kegiatan.tambah-logbook') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Logbook
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 2%;">No</th>
                            <th style="width: 12%;">Tanggal</th>
                            <th style="width: 30%;">Kegiatan</th>
                            <th style="width: 12%;">Capaian</th>
                            <th style="width: 20%;">Waktu Pelaksanaan (Menit)</th>
                            <th style="width: 15%;">Berkas</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['logbook_kegiatan'] as $index => $logbook)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ date('d-m-y', strtotime($logbook->tanggal)) }}</td>
                                <td>
                                    <div style="max-width: 250px; word-wrap: break-word;">
                                        {{ $logbook->uraian }}
                                    </div>
                                </td>
                                <td>{{ $logbook->capaian }}%</td>
                                <td>{{ $logbook->waktu_pelaksanaan }}</td>
                                <td>
                                    <a href="{{ route('pengusul.pelaksanaan.logbook-kegiatan.download', ['id' => $logbook->id]) }}"
                                        class="btn btn-sm btn-info">
                                        <i class="bi bi-file-earmark-arrow-down"></i>
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('pengusul.pelaksanaan.logbook-kegiatan.edit-logbook', $logbook->id) }}"
                                            class="btn btn-sm btn-warning me-1">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form
                                            action="{{ route('pengusul.pelaksanaan.logbook-kegiatan.delete', $logbook->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('detailLogbookBtn').addEventListener('click', function() {
            var logbookDetail = document.getElementById('logbookDetail');

            if (logbookDetail.style.display === 'none') {
                logbookDetail.style.display = 'block';
                this.innerHTML = '<i class="fas fa-list"></i> Sembunyikan Detail';
            } else {
                logbookDetail.style.display = 'none';
                this.innerHTML = '<i class="fas fa-list"></i> Lebih Detail';
            }
        });

        document.getElementById('closeLogbookDetailBtn').addEventListener('click', function() {
            var logbookDetail = document.getElementById('logbookDetail');
            logbookDetail.style.display = 'none';
            document.getElementById('detailLogbookBtn').innerHTML = '<i class="fas fa-list"></i> Lebih Detail';
        });

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

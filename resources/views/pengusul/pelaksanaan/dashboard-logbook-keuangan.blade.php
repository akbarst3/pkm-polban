@extends('pengusul/pelaksanaan/master')

@section('konten')
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="card shadow-sm p-4 flex-grow-1">
                <p class="h5 mb-0">Logbook Keuangan</p>
            </div>
        </div>
    </div>

    @if ($data['logbook_keuangan']->count() > 0)
        <button id="detailLogbookBtn" class="btn btn-primary position-fixed bottom-0 end-0 m-4 shadow-lg">
            <i class="fas fa-list"></i> Lebih Detail
        </button>
    @endif

    <div class="container my-1">
        <div class="card shadow-sm p-4">
            <h6 class="mb-4">{{ $data['pkm']->judul }}</h6>

            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Skema:</strong>
                    <p>{{ $data['skema']->nama_skema }}</p>
                    <strong>Tahun:</strong>
                    <p>{{ $data['pkm']->created_at->year }}</p>
                </div>
                <div class="col-md-4">
                    <strong>Total Dana:</strong>
                    <p class="text-primary">Rp. {{ number_format($data['dana_total']) }}</p>
                    <strong>Sisa:</strong>
                    <p class="text-danger">Rp. {{ number_format($data['sisa_dana']) }}</p>
                </div>
                <div class="col-md-4">
                    <strong>Penggunaan:</strong>
                    <p class="text-success">Rp. {{ number_format($data['total_penggunaan']) }}</p>
                    <strong>Status Validasi:</strong>
                    <p>{{ $data['logbook_keuangan']->where('val_dospem', true)->count() }}/{{ $data['logbook_keuangan']->count() }}
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
        </div>
    </div>
    @if ($data['logbook_keuangan']->count() === 0)
        <div class="container my-4">
            <div class="alert alert-info text-center" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                Belum ada logbook keuangan. Silakan tambahkan logbook pertama Anda.
            </div>

            @if ($data['total_penggunaan'] < $data['dana_total'])
                <div class="text-center">
                    <a href="{{ route('pengusul.form-tambah-logbook-keuangan') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah Logbook Pertama
                    </a>
                </div>
            @endif
        </div>
    @endif

    <div id="logbookDetail" class="container mt-4" style="display: none;">
        <div class="card shadow-sm p-4">
            <div class="d-flex justify-content-end mb-3">
                <button id="closeLogbookDetailBtn" class="btn btn-secondary me-2">
                    <i class="fas fa-times"></i> Tutup
                </button>

                @if ($data['total_penggunaan'] < $data['dana_total'])
                    <a href="{{ route('pengusul.form-tambah-logbook-keuangan') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah Logbook
                    </a>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th style="min-width: 200px;">Keterangan</th>
                            <th>Harga Satuan (Rp)</th>
                            <th>Jumlah</th>
                            <th>Total (Rp)</th>
                            <th>Berkas</th>
                            <th>Validasi Dosen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['logbook_keuangan'] as $index => $logbook)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $logbook->tanggal }}</td>
                                <td>
                                    <div style="max-width: 250px; word-wrap: break-word;">
                                        {{ $logbook->ket_item }}
                                    </div>
                                </td>
                                <td>Rp. {{ number_format($logbook->harga, 0, ',', '.') }}</td>
                                <td>{{ $logbook->jumlah }}</td>
                                <td>Rp. {{ number_format($logbook->harga * $logbook->jumlah, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('pengusul.download-bukti', ['id' => $logbook->id]) }}"
                                        class="btn btn-sm btn-info">
                                        <i class="bi bi-file-earmark-arrow-down"></i>
                                    </a>
                                </td>
                                <td>
                                    @if ($logbook->val_dospem == true)
                                        <span class="badge bg-success">Tervalidasi</span>
                                    @elseif ($logbook->val_dospem === null)
                                        <span class="badge bg-warning">Belum Validasi</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($logbook->val_dospem === null)
                                        <div class="d-flex">
                                            <a href="{{ route('pengusul.edit-logbook-keuangan', $logbook->id) }}"
                                                class="btn btn-sm btn-warning me-1">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('pengusul.hapus-logbook-keuangan', $logbook->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
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

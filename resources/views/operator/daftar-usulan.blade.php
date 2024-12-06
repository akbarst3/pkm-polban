@extends('operator.master')

@section('konten')
    <div class="card rounded shadow m-4">
        <div class="card-header bg-primary text-white p-3">
            <h6 class="m-0">DAFTAR USULAN {{ strtoupper($perguruanTinggi->nama_pt) }}</h6>
        </div>

        <div class="card-body">
            <!-- Filter Dropdowns -->
            <div class="table-container">
                <div class="row align-items-end mb-3">
                    <div class="col-md-4">
                        <label for="skema-filter">Filter Skema:</label>
                        <select class="form-control" id="skema-filter" required>
                            <option value="" selected>--Semua Skema--</option>
                            @foreach ($skema as $item)
                                <option value="{{ $item->nama_skema }}">{{ $item->nama_skema }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-8 text-end">
                        <a href="{{ route('operator.daftar-usulan.usulan-baru') }}" class="btn btn-primary">+ Data
                            Baru</a>
                    </div>
                </div>

                <table class="table table-striped table-bordered table-hover" id="data-table">
                    <thead>
                        <tr>
                            <th class="text-center align-middle" scope="col">No</th>
                            <th class="text-center align-middle" scope="col">Pengusul</th>
                            <th class="text-center align-middle" scope="col">Judul</th>
                            <th class="text-center align-middle" scope="col">Skema</th>
                            <th class="text-center align-middle" scope="col">Isian Kosong</th>
                            <th class="text-center align-middle" scope="col">Val. Dosen</th>
                            <th class="text-center align-middle" scope="col">Val. Pimpinan</th>
                            <th class="text-center align-middle" scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengusuls as $index => $pengusul)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    {{ $pengusul->nama_mahasiswa }}<br>
                                    {{ $pengusul->nim }}<br>
                                    {{ $pengusul->nama_prodi }} ({{ $pengusul->kode_prodi }})<br>
                                    Angkatan {{ $pengusul->angkatan }}
                                </td>
                                <td>{{ $pengusul->judul_pkm }}</td>
                                <td>{{ $pengusul->nama_skema }}</td>
                                <td>
                                    @if ($pengusul->jumlah_mahasiswa < 3)
                                        Anggota Kurang,
                                    @endif
                                    @if ($pengusul->alamat == null)
                                        Identitas pengusul,
                                    @endif
                                    @if ($pengusul->dana_pt == null || $pengusul->dana_kemdikbud == null)
                                        Pengajuan dana
                                    @endif
                                    @if ($pengusul->jumlah_mahasiswa >= 3 && $pengusul->alamat != null && $pengusul->dana_pt != null)
                                        <i
                                            class="d-flex justify-content-center bi bi-check-circle-fill text-success custom-icon"></i>
                                    @endif
                                </td>
                                <td>
                                    <i
                                        class="d-flex justify-content-center bi {{ !$pengusul->val_dospem ? 'bi-x-circle-fill text-danger' : 'bi-check-circle-fill text-success' }} custom-icon"></i>
                                </td>
                                <td>
                                    <i
                                        class="d-flex justify-content-center bi {{ !$pengusul->val_pt ? 'bi-x-circle-fill text-danger' : 'bi-check-circle-fill text-success' }} custom-icon"></i>
                                </td>
                                <td>
                                    <button class="btn btn-primary mb-2" onclick="viewData('{{ $pengusul->nim }}')">
                                        <i class="bi bi-person"></i>
                                    </button>
                                    <form action="{{ route('operator.daftar-usulan.delete', $pengusul->nim) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" onclick="confirmDeletion(event)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Optional JavaScript -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script>
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

        function viewData(nim) {
            window.location.href = '/operator/daftar-usulan/' + nim;
        }

        $(document).ready(function() {
            var table = $('#data-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
                }
            });

            $('#skema-filter').on('change', function() {
                var selectedSkema = $(this).val();
                table.column(3).search(selectedSkema).draw();
            });
        });
    </script>
@endsection

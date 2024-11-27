@php
    use Carbon\Carbon;
@endphp

@extends('dospem.master')

@section('konten')
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h6 class="mb-0 fw-bold">Log Book Kegiatan</h6>
            </div>

            <!-- Tabel Log Book Kegiatan -->
            <div class="card shadow-sm p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="data-table">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Berkas</th>
                                <th>Validasi Dosen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['logbooks'] as $logbook)
                                <tr>
                                    <td class="align-middle">{{ \Carbon\Carbon::parse($logbook->tanggal)->format('d-m-Y') }}
                                    </td>
                                    <td class="align-middle">{{ $logbook->ket_item }}</td>
                                    <td class="align-middle">{{ $logbook->harga }}%</td>
                                    <td class="align-middle">{{ $logbook->bukti }}</td>
                                    <td class="align-middle">
                                        <a href=""><i class="bi bi-file-earmark-fill"
                                                style="font-size: 35px;"></i></a>
                                    </td>
                                    <td class="align-middle">
                                        @if ($logbook->validasi === null)
                                            <form
                                                action="{{ route('dosen-pendamping.validasi-logbook.logbook-keuangan.approve', $logbook->id) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form
                                                action="{{ route('dosen-pendamping.validasi-logbook.logbook-keuangan.reject', $logbook->id) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    Tolak
                                                </button>
                                            </form>
                                        @elseif ($logbook->validasi)
                                            <span class="badge p-2 bg-success">Disetujui</span>
                                        @else
                                            <span class="badge p-2 bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                var table = $('#data-table').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
                    }
                });
            });
        </script>
    @endsection

@extends('pengusul/master')
    @section('konten')
        <div class="container-fluid mt-3 px-5">
            <h5>Beranda Pengusul Program Kreativitas Mahasiswa</h5>
            <div class="card">
                <div class="card-header bg-primary text-white">
                    IDENTITAS PERSONAL
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td><strong>Nama</strong></td>
                                <td>: {{ $data['mahasiswa']->nama }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nomor Induk</strong></td>
                                <td>: {{ $data['mahasiswa']->nim }}</td>
                            </tr>
                            <tr>
                                <td><strong>Program Studi</strong></td>
                                <td>: {{ $data['prodi']->nama_prodi }}</td>
                            </tr>
                            <tr>
                                <td><strong>Institusi</strong></td>
                                <td>: {{ $data['perguruanTinggi']->nama_pt }}</td>
                            </tr>
                            <tr>
                                <td><strong>Angkatan</strong></td>
                                <td>: {{ $data['mahasiswa']->angkatan }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @endsection

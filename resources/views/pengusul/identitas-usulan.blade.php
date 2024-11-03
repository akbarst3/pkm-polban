@extends('pengusul/master')
@section('konten')

    <body style="background-color: #d1d1d1;">
        <div class="container mt-4">
            <h4>Pengisian Identitas Mahasiswa Pengusul PKM</h4>
            <div class="card mt-4 my-10">
                <div class="card-body ">
                    <h5 class="card-title">Daftar Usulan</h5>
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Skema</th>
                                <th>Judul</th>
                                <th>Peran</th>
                                <th>Edit</th>
                                <th>Pengesahan</th>
                                <th>Upload Proposal</th>
                                <th>Val. Dosen</th>
                                <th>Val. Pimpinan</th>
                                <th>Hasil Evaluasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td>{{ $data['skema']->nama_skema }}</td>
                                <td>{{ $data['pkm']->judul }}</td>
                                <td>Ketua Kelompok</td>
                                <td>
                                    <a href="{{ route('pengusul.edit-usulan') }}">
                                        <button class="btn btn-outline-secondary">
                                            <img src="{{ asset('icons/edit-icon.png') }}" alt="Edit" width="20">
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <a href="">
                                        <button class="btn btn-outline-secondary">
                                            <img src="{{ asset('icons/print-icon.png') }}" alt="Print" width="20">
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <a href="">
                                        <button class="btn btn-outline-secondary">
                                            <img src="{{ asset('icons/upload-icon.png') }}" alt="Upload" width="20">
                                        </button>
                                    </a>
                                </td>
                                @php
                                    $valDospem = $data['pkm']->val_dospem;
                                    $valPt = $data['pkm']->val_pt;
                                @endphp
                                <td>
                                    <span class="badge {{ $valDospem ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $valDospem ? 'SUDAH' : 'BELUM' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $valPt ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $valPt ? 'SUDAH' : 'BELUM' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $valDospem && $valPt ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $valDospem && $valPt ? 'SUDAH' : 'BELUM' }}
                                    </span>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection

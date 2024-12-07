@extends('pengusul/pelaksanaan/master')
@section('konten')
    <style>
        .modal-header {
            background-color: #007bff;
            color: white;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s;
        }

        a:hover {
            color: #007bff;
            text-decoration: underline;
        }
    </style>
    <div class="container mt-2 ">
        <div class="card shadow rounded ps-3 pt-3 pb-0 mb-3 mt-0 fw-bold">
            <p class="">Laporan Kemajuan</p>
        </div>
        <div class="card shadow rounded ps-3 pt-1 pb-1 fw-bold pe-3">
            <p class="card-title ">{{ $data['pkm']->judul }}</p>
        </div>
        <div class="card shadow rounded p-3">
            <div class="row ps-4 pb-1 pt-3 pe-4">
                <!-- Kolom Skema dan Tahun -->
                <div class="col-md-4 mb-0 ps-4">
                    <div class="col-md-6">
                        <strong>Skema:</strong> <br>{{ $data['skema']->nama_skema }}
                    </div>
                    <div class="col-md-6 pt-3">
                        <strong>Tahun:</strong> <br>{{ $data['pkm']->created_at->year }}
                    </div>
                </div>

                <!-- Kolom Dana Disetujui dan Status Upload -->
                <div class="col-md-4 mb-0 ps-4">
                    <div class="col-md-6">
                        <strong>Dana Disetujui (Rp):</strong> <br>
                        @if ($data['totalDana'] > 0)
                            <span>Rp {{ number_format($data['totalDana']) }}</span>
                        @else
                            <span>-</span>
                        @endif
                    </div>
                </div>

                <!-- Kolom Status Validasi Dosen -->
                <div class="col-md-4 mb-0 ps-4">
                    <div class="col-md-6 pt-3">
                        <strong>Status Upload:</strong> <br>
                        <div class="d-flex align-items-center">
                            @if ($data['pkm']->sosmed->count() === 0)
                                <span
                                    class="text-success text-nowrap me-1"><strong>{{ $data['statusUpload'] }}</strong></span>
                                <i class="bi bi-info-circle"></i>
                            @else
                                <span class="text-danger text-nowrap"><strong>{{ $data['statusUpload'] }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row ps-4 pe-4 pb-2 pt-1">
                <div class="col-md-4">
                    <div class="bg-warning p-3 rounded text-white shadow h-100">
                        <strong style=>Perguruan Tinggi</strong>
                        <span
                            style="line-height: 2; margin: 0; padding: 0; display: block;">{{ $data['perguruanTinggi']->nama_pt }}</span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="bg-success rounded p-3 text-white shadow h-100">
                        <strong style=>Ketua</strong>
                        <span style="line-height: 2; margin: 0; padding: 0; display: block;">{{ $data['mahasiswa']->nama }}
                            - {{ $data['mahasiswa']->nim }}</span>
                        <p>{{ $data['prodi']->nama_prodi }} - {{ $data['prodi']->kode_prodi }}</p>
                        <p><strong>Kelompok:</strong></p>
                        <ul>
                            @foreach ($data['anggota'] as $anggota)
                                <li>{{ $anggota->nama }} - {{ $anggota->nim }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 d-flex">
                    <div class="card bg-primary text-white w-100">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">Dosen</h6>
                            <span
                                style="line-height: 2; margin: 0; padding: 0; display: block;">{{ $data['dosen']->nama }}</span>
                            <p>{{ $data['dosen']->kode_dosen }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ps-4 pe-4 pb-2 pt-1 my-3">
                <div class="col-3">
                    <div class="d-flex align-items-center">
                        <a href="">
                            <i class="me-2 bi bi-instagram"></i> <span>Instagram</span></a>
                    </div>
                    <p class="mb-0">Follower: 286</p>
                    <p class="mb-0">Post: 30</p>
                </div>
                <div class="col-3">
                    <div class="d-flex align-items-center">
                        <a href="">
                            <i class="me-2 bi bi-tiktok"></i> <span>Tiktok</span></a>
                    </div>
                    <p class="mb-0">Follower:</p>
                    <p class="mb-0">Post:</p>
                </div>
                <div class="col-3">
                    <div class="d-flex align-items-center">
                        <a href="">
                            <i class="me-2 bi bi-facebook"></i><span>Facebook</span></a>
                    </div>
                    <p class="mb-0">Follower:</p>
                    <p class="mb-0">Post:</p>
                </div>
                <div class="col-3">
                    <div class="d-flex align-items-center">
                        <a href="">
                            <i class="me-2 bi bi-youtube"></i> <span>YouTube</span></a>
                    </div>
                    <p class="mb-0">Follower:</p>
                    <p class="mb-0">Post:</p>
                </div>
            </div>
            <div class="row ps-4 pe-4 pb-2 pt-1">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#myModal">Upload</button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Form Link Akun Sosial Media</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="youtube">Link Akun YouTube</label>
                            <input type="url" class="form-control" id="youtube" placeholder="Masukkan link YouTube">
                        </div>
                        <div class="form-group">
                            <label for="instagram">Link Akun Instagram</label>
                            <input type="url" class="form-control" id="instagram" placeholder="Masukkan link Instagram">
                        </div>
                        <div class="form-group">
                            <label for="twitter">Link Akun Twitter</label>
                            <input type="url" class="form-control" id="twitter" placeholder="Masukkan link Twitter">
                        </div>
                        <div class="form-group">
                            <label for="tiktok">Link Akun TikTok</label>
                            <input type="url" class="form-control" id="tiktok" placeholder="Masukkan link TikTok">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Kirim</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
@endsection

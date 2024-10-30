<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  @extends('pengusul/master') <!-- Pastikan ini di bagian atas -->

    @section('konten')
  <body>
    <div class="container-fluid bg-secondary bg-opacity-50 vh-100">
        <div class="ps-4 pt-4 pb-0">
            <p>Pengisian Identitas Mahasiswa Pengusul PKM</p>
        </div>
        <div class="ms-4 me-4 pt-0">
            <div class="container  bg-white ps-3 pe-3 pt-2 pb-5">
                <div class="pb-3">
                    <p>Daftar Usulan</p>
                    <a href="" class="btn btn-secondary rounded-0" style="opacity: 0.5;">Kembali</a>
                </div>
                <div class="table-header text-left bg-primary border border-primary ">
                    <p class=" p-1 m-1">Upload Proposal{{-- {{ $perguruanTinggi->nama_pt }} --}}</p>
                    <div class="table-container border bg-white">
                        <div>
                            <div class="fs-6 pt-3 pb-2 ps-4 ms-2">
                                <td>Langkah 1 pilih berkas proposal</td>
                            </div>
                            <div class="ms-5 pb-4 pt-1">
                                <form method="POST" action="{{ route('pengusul.proposal.post') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mb-3">
                                            <input class="form-control-sm" name="file" type="file" id="formFile">
                                        </div>
                                        <div class="pe-5">
                                            <input type="submit" class="btn btn-info btn-sm rounded-0">
                                        </div>
                                    </div>
                                </form>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
 </body>
 @endsection
  {{-- <body>
    <div>
        <div class="p-3">
            <th class="">Pengisian Identitas Mahasiswa Pengusul PKM</th>
        </div>
        <div class="container-md col-11 ml-auto mr-5 bg-white pt-2 pb-5 mt-0  border">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="fw-normal fs-7 ">Upload Proposal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <form method="POST" action="{{route("pengusul.proposal.post")}}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <input class="form-control-sm" name="file" type="file" id="formFile">
                                </div>
                                <input type="submit" class="btn btn-primary btn-sm">
                            </form>                                                   
                        </td>
                    </tr>
                </tbody>
            </table>
        </div> 
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body> --}}
  {{-- <body>
    <div>
        <div class="p-3">
            <h3 class="">Pengisian Identitas Mahasiswa Pengusul PKM</h3>
        </div>
        <div class="container-md col-11 ml-auto mr-5 bg-white pt-2 pb-5 mt-0 border">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <div class="">
                <p class="m-0 p-1">DAFTAR USULAN</p>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover border-top">
                    <thead>
                        <tr>
                            <th scope="col" class="fw-normal fs-7">No</th>
                            <th scope="col" class="fw-normal fs-7">Tahun</th>
                            <th scope="col" class="fw-normal fs-7">Skema</th>
                            <th scope="col" class="fw-normal fs-7 col-3">Judul</th>
                            <th scope="col" class="fw-normal fs-7">Peran</th>
                            <th scope="col" class="fw-normal fs-7">Edit</th>
                            <th scope="col" class="fw-normal fs-7">Pengesahan</th>
                            <th scope="col" class="fw-normal fs-7 col-1">Upload Proposal</th>
                            <th scope="col" class="fw-normal fs-7 col-0">Val. Dosen</th>
                            <th scope="col" class="fw-normal fs-7 col-1">Val. Pimpinan</th>
                            <th scope="col" class="fw-normal fs-7 col-1">Hasil Evaluasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($detailPkms->isEmpty())
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data usulan.</td>
                            </tr>
                        @else
                            @foreach ($detailPkms as $detailPkm)
                            <tr>
                                <td>{{ $loop->iteration }}</td> <!-- Menampilkan nomor urut -->
                                <td>{{ date('Y') }}</td> <!-- Tahun saat ini -->
                                <td>{{ $detailPkm->skema->nama_skema ?? '-' }}</td> <!-- Menampilkan nama skema -->
                                <td>{{ $detailPkm->judul }}</td> <!-- Menampilkan judul -->
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>
                                    <form method="POST" action="{{ route('pengusul.proposal.post') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">Upload Proposal</label>
                                            <input class="form-control-sm" name="file" type="file" id="formFile" required>
                                            <input type="hidden" name="id_skema" value="{{ $detailPkm->id_skema }}"> <!-- Menyimpan id_skema -->
                                            <input type="hidden" name="judul" value="{{ $detailPkm->judul }}"> <!-- Menyimpan judul -->
                                        </div>
                                        <input type="submit" class="btn btn-primary btn-sm">
                                    </form> 
                                </td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            @endforeach
                        @endif
                    </body>
                </table>
            </div> 
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body> --}}
</html>
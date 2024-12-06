@extends('pengusul/master')
@section('konten')
    <div class="container-fluid">
        <div class="ps-4 pt-4 pb-2">
            <h5 class="fw-semi-bold">Pengisian Identitas Mahasiswa Pengusul PKM</h5>
        </div>
        <div class="ms-4 me-4">
            <div class="container bg-white shadow rounded-3 p-4">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        Upload Proposal
                    </div>
                    <div class="card-body">
                        @if ($data['pkm']->proposal)
                            <div class="alert alert-success text-center" role="alert">
                                Proposal sudah diupload
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('pengusul.identitas-usulan.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        @else
                            <p class="mb-3">Pilih berkas proposal</p>
                            <form method="POST" action="{{ route('pengusul.identitas-usulan.proposal') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="row align-items-center my-3">
                                    <div class="col-md-12">
                                        <input class="form-control" name="file" type="file" id="formFile">
                                        @error('file')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('pengusul.identitas-usulan.index') }}" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-success">Upload</button>
                                </div>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('operator.master')

@section('konten')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data Mahasiswa</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="p-4 bg-white rounded shadow-sm">
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5>DATA MAHASISWA</h5>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            @foreach ($mahasiswas as $mahasiswa)
                                <button class="btn" onclick="viewData('{{ $mahasiswa->nim }}')">
                                    Lihat Data {{ $mahasiswa->nama }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewData(nim) {
            // Mengarahkan pengguna ke rute dengan NIM mahasiswa
            window.location.href = '/operator/identitasTes/' + nim;
        }
    </script>
@endsection
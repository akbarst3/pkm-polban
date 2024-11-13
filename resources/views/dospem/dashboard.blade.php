@extends('dospem/master')
@section('konten')
    <div class="container my-4">
        <div class="card shadow-sm p-4">
            <h2 class="text-primary">SELAMAT DATANG, {{ $data['dosen']->nama }}!</h2>
            <p>Anda sedang login di role <strong>DOSEN PENDAMPING</strong></p>
        </div>
    </div>
@endsection
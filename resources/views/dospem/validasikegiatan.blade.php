<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Data Pembimbingan Usulan Proposal PKM</title>
</head>
@extends('dospem.master')

@section('konten')
<div class="container my-4">
    <h4>Data Pembimbingan Usulan Kegiatan PKM</h4>

    <!-- Filter Tahun -->
    <div class="d-flex align-items-center mb-3">
        <label class="me-2" for="yearSelect">Tahun:</label>
        <select id="yearSelect" class="form-select form-select-sm w-auto me-2">
            <option>2024</option>
            <option>2023</option>
        </select>
    </div>

    <!-- Tabel Kegiatan -->
    <div class="card shadow-sm p-4">
        <h5 class="text">Tabel Kegiatan</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-hover mt-3">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Pengusul</th>
                        <th>Judul</th>
                        <th>Skema</th>
                        <th>Validasi Logbook Kegiatan</th>
                        <th>Validasi Logbook Keuangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Valensia Febrianto</td>
                        <td>
                            Judul PKM<br>
                            <small>Pendamping: RENNY NIRWANA SARI (0701108007)</small>
                        </td>
                        <td>PKM-K</td>
                        <td>
                            <a href="/dospem/logbookkegiatan"><button class="btn btn-outline-secondary btn-sm">Validasi</button></a>
                        </td>
                        <td>
                            <a href="/dospem/logbookkeuangan"><button class="btn btn-outline-secondary btn-sm">Validasi</button></a>
                        </td>
                    </tr>
                    
                    <!-- Additional rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@extends('pengusul/pelaksanaan/master')
@section('konten')
    @php
        use Carbon\Carbon;
    @endphp
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow rounded m-3">
                    <div class="card-header">
                        <h5 class="card-title">
                            {{ isset($data['edit_mode']) ? 'Edit' : 'Tambah' }} Logbook Kegiatan
                        </h5>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($data['edit_mode']) ? route('pengusul.pelaksanaan.logbook-kegiatan.update', $data['logbook']->id) : route('pengusul.pelaksanaan.logbook-kegiatan.create') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($data['edit_mode']))
                                @method('PATCH')
                            @endif

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal</label>
                                    <input type="text" id="tanggal" name="tanggal"
                                        class="form-control @error('tanggal') is-invalid @enderror" placeholder="DD-MM-YYYY"
                                        value="{{ old('tanggal', isset($data['logbook']) ? Carbon::parse($data['logbook']->tanggal)->format('d-m-Y') : '') }}"
                                        required>
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="uraian">Uraian Kegiatan</label>
                                    <textarea rows="6" name="uraian" class="form-control @error('uraian') is-invalid @enderror" required>{{ old('uraian', isset($data['logbook']) ? $data['logbook']->uraian : '') }}</textarea>
                                    @error('uraian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="capaian">Persen Capaian (%)</label>
                                    <div class="input-group">
                                        <input type="text" id="capaian" name="capaian" class="form-control"
                                            value="{{ old('capaian', isset($data['logbook']) ? $data['logbook']->capaian : '') }}"
                                            oninput="validateInput(this)">
                                    </div>
                                    @error('capaian')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Waktu Kegiatan (Menit)</label>
                                    <input type="text" id="waktu" name="waktu"
                                        class="form-control @error('waktu') is-invalid @enderror"
                                        value="{{ old('waktu', $data['logbook']->waktu_pelaksanaan ?? '') }}" min="1"
                                        required oninput="validateInput(this)"> @error('waktu')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">File Pendukung</label>
                                        @if (isset($data['logbook']) && $data['edit_mode'])
                                            @php
                                                $filePath = $data['logbook']->bukti;
                                                $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                            @endphp

                                            @if (in_array($fileExtension, ['pdf', 'doc', 'docx']))
                                                <iframe
                                                    src="{{ route('pengusul.pelaksanaan.logbook-kegiatan.private-files', ['path' => $filePath]) }}"
                                                    width="100%" height="500px"></iframe>
                                            @elseif (in_array($fileExtension, ['jpg', 'jpeg']))
                                                <img src="{{ route('pengusul.pelaksanaan.logbook-kegiatan.private-files', ['path' => $filePath]) }}"
                                                    alt="Image" style="max-width: 100%; height: auto;">
                                            @else
                                                <p>File tidak dapat ditampilkan.</p>
                                            @endif
                                        @endif
                                        <input type="file" name="bukti"
                                            class="form-control @error('bukti') is-invalid @enderror"
                                            {{ isset($data['edit_mode']) ? '' : 'required' }}>

                                        @error('bukti')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Upload berkas (doc, docx, jpg, jpeg, pdf. Ukuran 1MB)
                                        </small>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($data['edit_mode']) ? 'Perbarui' : 'Simpan' }} Logbook Kegiatan
                                    </button>
                                    <a href="{{ route('pengusul.pelaksanaan.logbook-kegiatan.index') }}"
                                        class="btn btn-secondary">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(document).ready(function() {
            flatpickr("#tanggal", {
                dateFormat: "d-m-Y",
                allowInput: true,
                onReady: function(selectedDates, dateStr, instance) {
                    instance.setDate(new Date(), true);
                }
            });
        });

        function validateInput(input) {
            input.value = input.value.replace(/[^0-9]/g, '');
        }
    </script>
@endpush

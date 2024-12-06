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
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            {{ isset($data['edit_mode']) ? 'Edit' : 'Tambah' }} Logbook Keuangan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <strong>Informasi Dana:</strong>
                                    <ul class="mb-0">
                                        <li>Total Dana: Rp. {{ number_format($data['dana_total']) }}</li>
                                        <li>Total Penggunaan: Rp. {{ number_format($data['total_penggunaan']) }}</li>
                                        <li>Sisa Dana: Rp. {{ number_format($data['sisa_dana']) }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <form
                            action="{{ isset($data['edit_mode']) ? route('pengusul.pelaksanaan.update-logbook-keuangan', $data['logbook']->id) : route('pengusul.pelaksanaan.store-logbook-keuangan') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($data['edit_mode']))
                                @method('PUT')
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

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Keterangan Item</label>
                                    <input type="text" name="ket_item"
                                        class="form-control @error('ket_item') is-invalid @enderror"
                                        value="{{ old('ket_item', isset($data['logbook']) ? $data['logbook']->ket_item : '') }}"
                                        required>
                                    @error('ket_item')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Harga Satuan</label>
                                    <div class="input-group">
                                        <input type="text" id="harga-input" name="harga"
                                            class="form-control rupiah-input @error('harga') is-invalid @enderror"
                                            value="{{ old('harga') ? 'Rp ' . number_format(preg_replace('/[^0-9]/', '', old('harga')), 0, ',', '.') : (isset($data['logbook']) ? 'Rp ' . number_format($data['logbook']->harga, 0, ',', '.') : '') }}"
                                            required oninput="calculateTotal()">
                                    </div>
                                    @error('harga')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Maksimal pengisian: Rp. {{ number_format($data['sisa_dana']) }}
                                    </small>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" id="jumlah-input" name="jumlah"
                                        class="form-control @error('jumlah') is-invalid @enderror"
                                        value="{{ old('jumlah') ?? (isset($data['logbook']) ? $data['logbook']->jumlah : 1) }}"
                                        min="1" required oninput="calculateTotal()">
                                    @error('jumlah')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Total Harga</label>
                                    <input type="text" id="total-harga" class="form-control"
                                        value="{{ isset($data['logbook'])
                                            ? 'Rp ' . number_format($data['logbook']->harga * $data['logbook']->jumlah, 0, ',', '.')
                                            : 'Rp 0' }}"
                                        disabled>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Bukti</label>
                                    <input type="file" name="bukti"
                                        class="form-control @error('bukti') is-invalid @enderror" accept=".pdf"
                                        {{ isset($data['edit_mode']) ? '' : 'required' }}>
                                    @error('bukti')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Ukuran maksimal: 2 MB. Tipe file: PDF
                                    </small>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($data['edit_mode']) ? 'Perbarui' : 'Simpan' }} Logbook Keuangan
                                    </button>
                                    <a href="{{ route('pengusul.pelaksanaan.logbook-keuangan') }}"
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
                    instance.setDate(new Date(), true); // Set default date to today
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const hargaInput = document.getElementById('harga-input');
            const form = hargaInput.closest('form');

            hargaInput.addEventListener('input', function() {
                let value = this.value.replace(/[^\d]/g, '');
                let numericValue = parseFloat(value);

                if (numericValue) {
                    this.value = 'Rp ' + numericValue.toLocaleString('id-ID');
                } else {
                    this.value = '';
                }
            });

            form.addEventListener('submit', function(e) {
                let rawValue = hargaInput.value.replace(/[^\d]/g, '');
                hargaInput.value = rawValue;
            });
        });

        function calculateTotal() {
            const hargaInput = document.getElementById('harga-input');
            const jumlahInput = document.getElementById('jumlah-input');

            const hargaString = hargaInput.value.replace(/[^0-9]/g, '');
            const harga = parseFloat(hargaString) || 0;
            const jumlah = parseInt(jumlahInput.value) || 0;

            const totalHarga = harga * jumlah;

            const formattedTotal = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
            }).format(totalHarga);

            document.getElementById('total-harga').value = formattedTotal;
        }
    </script>
@endpush

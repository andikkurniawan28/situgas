@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <strong>Tambah Tagihan</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('tagihan.store') }}" method="POST">
                        @csrf

                        <!-- Terbit -->
                        <div class="form-group mt-3">
                            <label for="terbit">Terbit</label>
                            <input type="date" name="terbit" id="terbit"
                                class="form-control @error('terbit') is-invalid @enderror" value="{{ old('terbit', date('Y-m-d')) }}"
                                required>
                            @error('terbit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jatuh Tempo -->
                        <div class="form-group mt-3">
                            <label for="jatuh_tempo">Jatuh Tempo</label>
                            <input type="date" name="jatuh_tempo" id="jatuh_tempo"
                                class="form-control @error('jatuh_tempo') is-invalid @enderror" value="{{ old('jatuh_tempo', date('Y-m-d')) }}"
                                required>
                            @error('jatuh_tempo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Klien -->
                        <div class="form-group">
                            <label for="klien_id">Klien</label>
                            <select name="klien_id" id="klien_id"
                                class="form-control @error('klien_id') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Klien --</option>
                                @foreach ($kliens as $klien)
                                    <option value="{{ $klien->id }}" {{ old('klien_id') == $klien->id ? 'selected' : '' }}>
                                        {{ $klien->nama }} ({{ $klien->perusahaan }})
                                    </option>
                                @endforeach
                            </select>
                            @error('klien_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="form-group mt-3">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                                rows="4" required>{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Total -->
                        <div class="form-group mt-3">
                            <label for="total">Total (Rp)</label>
                            <input type="text" id="total_display" class="form-control @error('total') is-invalid @enderror"
                                value="{{ number_format(old('total'), 0, ',', '.') }}" required>
                            <input type="hidden" name="total" id="total" value="{{ old('total') }}">
                            @error('total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <!-- Status Lunas -->
                        <div class="form-group mt-3">
                            <label for="lunas">Status Pembayaran</label>
                            <select name="lunas" id="lunas"
                                class="form-control @error('lunas') is-invalid @enderror" required>
                                <option value="0" {{ old('lunas') === '0' ? 'selected' : '' }}>Belum Lunas</option>
                                <option value="1" {{ old('lunas') === '1' ? 'selected' : '' }}>Lunas</option>
                            </select>
                            @error('lunas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <!-- Tombol -->
                        <button type="submit" class="btn btn-primary mt-4">Simpan</button>
                        <a href="{{ route('tagihan.index') }}" class="btn btn-secondary mt-4">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#klien_id, #lunas').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih --',
                allowClear: false,
                width: '100%'
            });

            const formatRupiah = (number) => {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            };

            const unformatRupiah = (value) => {
                return value.replace(/\./g, '');
            };

            const totalInput = document.getElementById('total_display');
            const totalHidden = document.getElementById('total');

            totalInput.addEventListener('input', function () {
                let raw = unformatRupiah(this.value);
                if (!isNaN(raw)) {
                    this.value = formatRupiah(raw);
                    totalHidden.value = raw;
                }
            });
        });
    </script>
@endsection

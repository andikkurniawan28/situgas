@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <strong>Tambah Pelunasan</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('pelunasan.store') }}" method="POST">
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

                        <!-- Tagihan -->
                        <div class="form-group">
                            <label for="tagihan_id">Tagihan</label>
                            <select name="tagihan_id" id="tagihan_id"
                                class="form-control @error('tagihan_id') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Tagihan --</option>
                                @foreach ($tagihans as $tagihan)
                                    <option value="{{ $tagihan->id }}" {{ old('tagihan_id') == $tagihan->id ? 'selected' : '' }}>
                                        #{{ $tagihan->id }} - {{ $tagihan->keterangan }}
                                        ({{ $tagihan->klien->nama }})
                                    </option>
                                @endforeach
                            </select>
                            @error('tagihan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Akun -->
                        <div class="form-group mt-3">
                            <label for="akun_id">Akun</label>
                            <select name="akun_id" id="akun_id"
                                class="form-control @error('akun_id') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Akun --</option>
                                @foreach ($akuns as $akun)
                                    <option value="{{ $akun->id }}" {{ old('akun_id') == $akun->id ? 'selected' : '' }}>
                                        {{ $akun->nama }} ({{ $akun->kode }})
                                    </option>
                                @endforeach
                            </select>
                            @error('akun_id')
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

                        <!-- Tombol -->
                        <button type="submit" class="btn btn-primary mt-4">Simpan</button>
                        <a href="{{ route('pelunasan.index') }}" class="btn btn-secondary mt-4">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#tagihan_id, #akun_id').select2({
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

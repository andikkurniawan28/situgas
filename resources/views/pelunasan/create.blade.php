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

                        <!-- Tagihan -->
                        <div class="form-group">
                            <label for="tagihan_id">Tagihan</label>
                            <select name="tagihan_id" id="tagihan_id"
                                class="form-control @error('tagihan_id') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Tagihan --</option>
                                @foreach ($tagihans as $tagihan)
                                    <option value="{{ $tagihan->id }}" {{ old('tagihan_id') == $tagihan->id ? 'selected' : '' }}>
                                        #{{ $tagihan->id }} - {{ $tagihan->keterangan }}
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
                                        {{ $akun->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('akun_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Total -->
                        <div class="form-group mt-3">
                            <label for="total">Total Pelunasan (Rp)</label>
                            <input type="number" name="total" id="total"
                                class="form-control @error('total') is-invalid @enderror" value="{{ old('total') }}"
                                required>
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
        });
    </script>
@endsection

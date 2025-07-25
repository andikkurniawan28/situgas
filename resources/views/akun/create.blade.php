@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <strong>Tambah Akun</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('akun.store') }}" method="POST">
                        @csrf

                        <!-- JenisAkun -->
                        <div class="form-group">
                            <label for="jenis_akun_id">JenisAkun</label>
                            <select name="jenis_akun_id" id="jenis_akun_id"
                                class="form-control @error('jenis_akun_id') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih JenisAkun --</option>
                                @foreach ($jenis_akuns as $jenis_akun)
                                    <option value="{{ $jenis_akun->id }}"
                                        {{ old('jenis_akun_id') == $jenis_akun->id ? 'selected' : '' }}>
                                        {{ $jenis_akun->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_akun_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kode -->
                        <div class="form-group mt-3">
                            <label for="kode">Kode</label>
                            <input type="text" name="kode" id="kode"
                                class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode') }}"
                                required autofocus>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama -->
                        <div class="form-group mt-3">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama"
                                class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                required autofocus>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Saldo Normal -->
                        <div class="form-group mt-3">
                            <label for="saldo_normal">Saldo Normal</label>
                            <select name="saldo_normal" id="saldo_normal"
                                class="form-control @error('saldo_normal') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Saldo Normal --</option>
                                <option value="debit" {{ old('saldo_normal') == 'debit' ? 'selected' : '' }}>debit
                                </option>
                                <option value="kredit" {{ old('saldo_normal') == 'kredit' ? 'selected' : '' }}>kredit
                                </option>
                            </select>
                            @error('saldo_normal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol -->
                        <button type="submit" class="btn btn-primary mt-4">Simpan</button>
                        <a href="{{ route('akun.index') }}" class="btn btn-secondary mt-4">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#jenis_akun_id').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih JenisAkun --',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection

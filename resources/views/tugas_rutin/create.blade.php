@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <strong>Tambah Tugas Rutin</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('tugas_rutin.store') }}" method="POST">
                        @csrf

                        <!-- Jabatan -->
                        <div class="form-group">
                            <label for="jabatan_id">Jabatan</label>
                            <select name="jabatan_id" id="jabatan_id"
                                class="form-control @error('jabatan_id') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Jabatan --</option>
                                @foreach ($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id }}"
                                        {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>
                                        {{ $jabatan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jabatan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Judul -->
                        <div class="form-group mt-3">
                            <label for="judul">Judul</label>
                            <input type="text" name="judul" id="judul"
                                class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}"
                                required autofocus>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="form-group mt-3">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                                rows="4">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol -->
                        <button type="submit" class="btn btn-primary mt-4">Simpan</button>
                        <a href="{{ route('tugas_rutin.index') }}" class="btn btn-secondary mt-4">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#jabatan_id').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih Jabatan --',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection

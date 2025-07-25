@extends('template.master')

@section('content')
    <main jabatan="main" class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <strong>Tambah {{ ucwords(str_replace('_', ' ', 'user')) }}</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf

                        <!-- Input Nama -->
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama"
                                class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                required autofocus>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input {{ ucwords(str_replace('_', ' ', 'user')) }}name -->
                        <div class="form-group mt-3">
                            <label for="username">{{ ucwords(str_replace('_', ' ', 'user')) }}name</label>
                            <input type="text" name="username" id="username"
                                class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}"
                                required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Password -->
                        <div class="form-group mt-3">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Select Jabatan -->
                        <div class="form-group mt-3">
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

                        <!-- Checkbox Status Aktif -->
                        <div class="form-group form-check mt-3">
                            <input type="checkbox" name="status_aktif" class="form-check-input" id="status_aktif"
                                value="1" {{ old('status_aktif', 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_aktif">Aktif</label>
                        </div>

                        <!-- Tombol Simpan dan Kembali -->
                        <button type="submit" class="btn btn-primary mt-4">Simpan</button>
                        <a href="{{ route('user.index') }}" class="btn btn-secondary mt-4">Kembali</a>
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

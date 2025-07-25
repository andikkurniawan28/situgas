@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <strong>Tambah {{ ucwords(str_replace('_', ' ', 'klien')) }}</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('klien.store') }}" method="POST">
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

                        <!-- Select Level Klien -->
                        <div class="form-group mt-3">
                            <label for="level_klien_id">Level Klien</label>
                            <select name="level_klien_id" id="level_klien_id"
                                class="form-control @error('level_klien_id') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Level Klien --</option>
                                @foreach ($level_kliens as $level)
                                    <option value="{{ $level->id }}"
                                        {{ old('level_klien_id') == $level->id ? 'selected' : '' }}>
                                        {{ $level->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('level_klien_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Perusahaan -->
                        <div class="form-group mt-3">
                            <label for="perusahaan">Perusahaan</label>
                            <input type="text" name="perusahaan" id="perusahaan"
                                class="form-control @error('perusahaan') is-invalid @enderror"
                                value="{{ old('perusahaan') }}">
                            @error('perusahaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bidang Usaha -->
                        <div class="form-group mt-3">
                            <label for="bidang_usaha">Bidang Usaha</label>
                            <input type="text" name="bidang_usaha" id="bidang_usaha"
                                class="form-control @error('bidang_usaha') is-invalid @enderror"
                                value="{{ old('bidang_usaha') }}">
                            @error('bidang_usaha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Telepon -->
                        <div class="form-group mt-3">
                            <label for="telepon">Telepon</label>
                            <input type="text" name="telepon" id="telepon"
                                class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon') }}">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- WhatsApp -->
                        <div class="form-group mt-3">
                            <label for="whatsapp">WhatsApp</label>
                            <input type="text" name="whatsapp" id="whatsapp"
                                class="form-control @error('whatsapp') is-invalid @enderror" value="{{ old('whatsapp') }}">
                            @error('whatsapp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group mt-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Simpan dan Kembali -->
                        <button type="submit" class="btn btn-primary mt-4">Simpan</button>
                        <a href="{{ route('klien.index') }}" class="btn btn-secondary mt-4">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#level_klien_id').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih Level Klien --',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection

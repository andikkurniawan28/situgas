@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <strong>Tambah {{ ucwords(str_replace('_', ' ', 'level_klien')) }}</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('level_klien.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama"
                                class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                required autofocus>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Select Warna -->
                        <div class="form-group mt-3">
                            <label for="warna">Warna</label>
                            <select name="warna" id="warna" class="form-control @error('warna') is-invalid @enderror"
                                required>
                                <option value="" disabled selected>-- Pilih Warna --</option>
                                <option value="primary" {{ old('warna') == 'primary' ? 'selected' : '' }}>Primary / biru
                                </option>
                                <option value="secondary" {{ old('warna') == 'secondary' ? 'selected' : '' }}>Secondary /
                                    abu-abu</option>
                                <option value="warning" {{ old('warna') == 'warning' ? 'selected' : '' }}>Warning / kuning
                                </option>
                                <option value="success" {{ old('warna') == 'success' ? 'selected' : '' }}>Success / hijau
                                </option>
                                <option value="danger" {{ old('warna') == 'danger' ? 'selected' : '' }}>Danger / merah
                                </option>
                                <option value="info" {{ old('warna') == 'info' ? 'selected' : '' }}>Info / biru muda
                                </option>
                                <option value="dark" {{ old('warna') == 'dark' ? 'selected' : '' }}>Dark / hitam</option>
                            </select>
                            @error('warna')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                        <a href="{{ route('level_klien.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#warna').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih Warna --',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection

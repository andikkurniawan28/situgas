@extends('template.master')

@section('content')
    <main divisi="main" class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <strong>Tambah {{ ucwords(str_replace('_', ' ', 'jabatan')) }}</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('jabatan.store') }}" method="POST">
                        @csrf

                        <!-- Input Nama Jabatan -->
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama"
                                class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                required autofocus>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Select Divisi -->
                        <div class="form-group mt-3">
                            <label for="divisi_id">Divisi</label>
                            <select name="divisi_id" id="divisi_id"
                                class="form-control @error('divisi_id') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih divisi --</option>
                                @foreach ($divisis as $divisi)
                                    <option value="{{ $divisi->id }}">{{ $divisi->nama }}</option>
                                @endforeach
                            </select>
                            @error('divisi_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Checkbox Akses -->
                        <div class="form-group mt-4">
                            <label for="akses">Akses</label>

                            <!-- Checkbox "Pilih Semua" -->
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="checkAll">
                                <label class="form-check-label" for="checkAll"><strong>Pilih Semua Akses</strong></label>
                            </div>

                            <!-- Daftar Checkbox Akses -->
                            <div class="row">
                                @foreach ($akses as $item)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input akses-checkbox" type="checkbox"
                                                name="{{ $item }}" id="akses_{{ $loop->index }}" value="1"
                                                {{ old($item) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="akses_{{ $loop->index }}">
                                                {{ ucwords(str_replace('_', ' ', $item)) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                        <!-- Tombol Simpan dan Kembali -->
                        <button type="submit" class="btn btn-primary mt-4">Simpan</button>
                        <a href="{{ route('jabatan.index') }}" class="btn btn-secondary mt-4">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Select2 untuk dropdown divisi
            $('#divisi_id').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih divisi --',
                allowClear: true,
                width: '100%' // agar responsive
            });

            // Fungsi "Pilih Semua" untuk checkbox akses
            $('#checkAll').on('change', function() {
                $('.akses-checkbox').prop('checked', $(this).prop('checked'));
            });
        });
    </script>
@endsection

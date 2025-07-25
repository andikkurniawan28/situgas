@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <strong>Edit Tugas</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('tugas.update', $tugas->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Judul -->
                        <div class="form-group mt-3">
                            <label for="judul">Judul</label>
                            <input type="text" name="judul" id="judul"
                                class="form-control @error('judul') is-invalid @enderror"
                                value="{{ old('judul', $tugas->judul) }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="form-group mt-3">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                                rows="4" required>{{ old('keterangan', $tugas->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Delegasi -->
                        <div class="form-group mt-3">
                            <label for="didelegasikan_ke">Delegasikan Ke</label>
                            <select name="didelegasikan_ke" id="didelegasikan_ke"
                                class="form-control @error('didelegasikan_ke') is-invalid @enderror" required>
                                <option value="" disabled>-- Pilih User --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ (old('didelegasikan_ke') ?? $tugas->didelegasikan_ke) == $user->id ? 'selected' : '' }}>
                                        {{ $user->nama }} ({{ $user->jabatan->nama }})
                                    </option>
                                @endforeach
                            </select>
                            @error('didelegasikan_ke')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gambar Upload -->
                        <div class="form-group mt-3">
                            <label for="gambar1">Gambar 1</label>
                            <input type="file" accept="image/*" name="gambar1"
                                class="form-control-file @error('gambar1') is-invalid @enderror">
                            @error('gambar1')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label for="gambar2">Gambar 2</label>
                            <input type="file" accept="image/*" name="gambar2"
                                class="form-control-file @error('gambar2') is-invalid @enderror">
                            @error('gambar2')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <label for="gambar3">Gambar 3</label>
                            <input type="file" accept="image/*" name="gambar3"
                                class="form-control-file @error('gambar3') is-invalid @enderror">
                            @error('gambar3')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol -->
                        <button type="submit" class="btn btn-primary mt-4">Update</button>
                        <a href="{{ route('tugas.index') }}" class="btn btn-secondary mt-4">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#didelegasikan_ke').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih --',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection

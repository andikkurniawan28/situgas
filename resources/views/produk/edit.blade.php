@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <strong>Edit Produk</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('produk.update', $produk->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Klien -->
                        <div class="form-group">
                            <label for="klien_id">Klien</label>
                            <select name="klien_id" id="klien_id"
                                class="form-control @error('klien_id') is-invalid @enderror" required>
                                <option value="" disabled>-- Pilih Klien --</option>
                                @foreach ($kliens as $klien)
                                    <option value="{{ $klien->id }}"
                                        {{ old('klien_id', $produk->klien_id) == $klien->id ? 'selected' : '' }}>
                                        {{ $klien->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('klien_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Judul -->
                        <div class="form-group mt-3">
                            <label for="judul">Judul</label>
                            <input type="text" name="judul" id="judul"
                                class="form-control @error('judul') is-invalid @enderror"
                                value="{{ old('judul', $produk->judul) }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="form-group mt-3">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                                rows="4">{{ old('keterangan', $produk->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Link Repo -->
                        <div class="form-group mt-3">
                            <label for="link_repo">Link Repository</label>
                            <input type="url" name="link_repo" id="link_repo"
                                class="form-control @error('link_repo') is-invalid @enderror"
                                value="{{ old('link_repo', $produk->link_repo) }}">
                            @error('link_repo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Link Produk -->
                        <div class="form-group mt-3">
                            <label for="link_produk">Link Produk</label>
                            <input type="url" name="link_produk" id="link_produk"
                                class="form-control @error('link_produk') is-invalid @enderror"
                                value="{{ old('link_produk', $produk->link_produk) }}">
                            @error('link_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Token -->
                        <div class="form-group mt-3">
                            <label for="token">Token</label>
                            <input type="text" name="token" id="token"
                                class="form-control @error('token') is-invalid @enderror"
                                value="{{ old('token', $produk->token) }}" required>
                            @error('token')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status Aktif -->
                        <div class="form-group mt-3">
                            <label for="status_aktif">Status Aktif</label>
                            <select name="status_aktif" id="status_aktif"
                                class="form-control @error('status_aktif') is-invalid @enderror" required>
                                <option value="aktif"
                                    {{ old('status_aktif', $produk->status_aktif) == 'aktif' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="nonaktif"
                                    {{ old('status_aktif', $produk->status_aktif) == 'nonaktif' ? 'selected' : '' }}>
                                    Nonaktif</option>
                            </select>
                            @error('status_aktif')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol -->
                        <button type="submit" class="btn btn-success mt-4">Perbarui</button>
                        <a href="{{ route('produk.index') }}" class="btn btn-secondary mt-4">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#klien_id').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih Klien --',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection

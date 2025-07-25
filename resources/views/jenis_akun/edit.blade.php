@extends('template.master')

@section('content')
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <strong>Edit {{ ucwords(str_replace('_', ' ', 'jenis_akun')) }}</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('jenis_akun.update', $jenis_akun->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama', $jenis_akun->nama) }}" required autofocus>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                    <a href="{{ route('jenis_akun.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

@extends('template.master')

@section('content')
    <main class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <strong>Edit Jabatan</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('jabatan.update', $jabatan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Input Nama -->
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $jabatan->nama) }}" required autofocus>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Divisi -->
                        <div class="form-group mt-3">
                            <label for="divisi_id">Divisi</label>
                            <select name="divisi_id" id="divisi_id"
                                class="form-control @error('divisi_id') is-invalid @enderror" required>
                                <option value="" disabled>-- Pilih divisi --</option>
                                @foreach ($divisis as $divisi)
                                    <option value="{{ $divisi->id }}"
                                        {{ old('divisi_id', $jabatan->divisi_id) == $divisi->id ? 'selected' : '' }}>
                                        {{ $divisi->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('divisi_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Akses -->
                        <div class="form-group mt-4">
                            <label for="akses">Akses</label>

                            <!-- Pilih Semua -->
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="checkAll">
                                <label class="form-check-label" for="checkAll"><strong>Pilih Semua Akses</strong></label>
                            </div>

                            <!-- Semua Checkbox Akses -->
                            <div class="row">
                                @foreach ($akses as $item)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input akses-checkbox" type="checkbox"
                                                name="{{ $item }}" id="{{ $item }}" value="1"
                                                {{ old($item, $jabatan->$item) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ $item }}">
                                                {{ ucwords(str_replace('_', ' ', $item)) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Update</button>
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
            $('#divisi_id').select2({
                theme: 'bootstrap4',
                width: '100%'
            });

            // Toggle semua akses
            $('#checkAll').on('change', function() {
                $('.akses-checkbox').prop('checked', $(this).prop('checked'));
            });

            // Toggle centang all jika semua dipilih
            function updateCheckAll() {
                $('#checkAll').prop('checked', $('.akses-checkbox:checked').length === $('.akses-checkbox').length);
            }

            $('.akses-checkbox').on('change', updateCheckAll);
            updateCheckAll(); // on load
        });
    </script>
@endsection

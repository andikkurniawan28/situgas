@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h2 class="mb-3">Daftar Akun</h2>

                    <a href="{{ route('akun.create') }}" class="btn btn-primary mb-3">
                        + Tambah Akun
                    </a>

                    <div class="card text-dark">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="akun-table" class="table table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>JenisAkun</th>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Saldo Normal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#akun-table').DataTable({
                order: [[0, 'asc']],
                processing: true,
                serverSide: true,
                ajax: '{{ route('akun.index') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'jenis_akun.nama', name: 'jenis_akun.nama' },
                    { data: 'kode', name: 'kode' },
                    { data: 'nama', name: 'nama' },
                    { data: 'saldo_normal', name: 'saldo_normal' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endsection

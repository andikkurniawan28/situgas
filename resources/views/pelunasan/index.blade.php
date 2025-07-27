@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h2 class="mb-3">Daftar Pelunasan</h2>

                    <a href="{{ route('pelunasan.create') }}" class="btn btn-primary mb-3">
                        + Tambah Pelunasan
                    </a>

                    <div class="card text-dark">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="pelunasan-table" class="table table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Terbit</th>
                                            <th>Tagihan</th>
                                            <th>Akun</th>
                                            <th>Total</th>
                                            <th>Dibuat Oleh</th>
                                            {{-- <th>Dibuat Pada</th> --}}
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
            $('#pelunasan-table').DataTable({
                order: [[0, 'desc']],
                processing: true,
                serverSide: true,
                ajax: '{{ route('pelunasan.index') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'terbit', name: 'terbit' },
                    { data: 'tagihan_keterangan', name: 'tagihan.keterangan' },
                    { data: 'akun_nama', name: 'akun.nama' },
                    { data: 'total', name: 'total' },
                    { data: 'user_nama', name: 'user.nama' },
                    // { data: 'created_at', name: 'created_at' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endsection

@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h2 class="mb-3">Daftar Tagihan</h2>

                    <a href="{{ route('tagihan.create') }}" class="btn btn-primary mb-3">
                        + Tambah Tagihan
                    </a>

                    <div class="card text-dark">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tagihan-table" class="table table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Terbit</th>
                                            <th>Jatuh Tempo</th>
                                            <th>Klien</th>
                                            <th>Keterangan</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Dibuat Oleh</th>
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
            $('#tagihan-table').DataTable({
                order: [[0, 'desc']],
                processing: true,
                serverSide: true,
                ajax: '{{ route('tagihan.index') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'terbit', name: 'terbit' },
                    { data: 'jatuh_tempo', name: 'jatuh_tempo' },
                    { data: 'klien_nama', name: 'klien_nama' },
                    { data: 'keterangan', name: 'keterangan' },
                    { data: 'total', name: 'total' },
                    { data: 'status', name: 'status' },
                    { data: 'user_nama', name: 'user_nama' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endsection

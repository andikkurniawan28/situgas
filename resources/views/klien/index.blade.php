@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h2 class="mb-3">Daftar {{ ucwords(str_replace('_', ' ', 'klien')) }}</h2>

                    <a href="{{ route('klien.create') }}" class="btn btn-primary mb-3">+ Tambah {{ ucwords(str_replace('_', ' ', 'klien')) }}</a>

                    <div class="card text-dark">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="klien-table" class="table table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>{{ ucwords(str_replace('_', ' ', 'level_klien')) }}</th>
                                            <th>Nama</th>
                                            <th>{{ ucwords(str_replace('_', ' ', 'perusahaan')) }}</th>
                                            <th>{{ ucwords(str_replace('_', ' ', 'bidang_usaha')) }}</th>
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
        </div> <!-- .container-fluid -->
    </main><!-- main -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#klien-table').DataTable({
                order: [
                    [0, 'asc']
                ],
                processing: true,
                serverSide: true,
                ajax: '{{ route('klien.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'level_klien.nama',
                        name: 'level_klien.nama'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'perusahaan',
                        name: 'perusahaan'
                    },
                    {
                        data: 'bidang_usaha',
                        name: 'bidang_usaha'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endsection

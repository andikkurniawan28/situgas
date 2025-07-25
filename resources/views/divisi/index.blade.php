@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h2 class="mb-3">Daftar {{ ucwords(str_replace('_', ' ', 'divisi')) }}</h2>

                    <a href="{{ route('divisi.create') }}" class="btn btn-primary mb-3">+ Tambah {{ ucwords(str_replace('_', ' ', 'divisi')) }}</a>

                    <div class="card text-dark">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="divisi-table" class="table table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama</th>
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
            $('#divisi-table').DataTable({
                order: [
                    [0, 'asc']
                ],
                processing: true,
                serverSide: true,
                ajax: '{{ route('divisi.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
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

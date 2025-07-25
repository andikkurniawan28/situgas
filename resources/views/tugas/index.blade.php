@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h2 class="mb-3">Daftar Tugas</h2>

                    <a href="{{ route('tugas.create') }}" class="btn btn-primary mb-3">
                        + Tambah Tugas
                    </a>

                    <div class="card text-dark">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tugas-table" class="table table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Judul</th>
                                            <th>Dibuat</th>
                                            <th>Didelegasikan</th>
                                            <th>Progress</th>
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
            $('#tugas-table').DataTable({
                order: [[0, 'desc']],
                processing: true,
                serverSide: true,
                ajax: '{{ route('tugas.index') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'judul', name: 'judul' },
                    { data: 'pembuat', name: 'pembuat' },
                    { data: 'delegasi', name: 'delegasi' },
                    { data: 'progress', name: 'progress' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endsection

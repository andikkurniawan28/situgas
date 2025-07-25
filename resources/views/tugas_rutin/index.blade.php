@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h2 class="mb-3">Daftar Tugas Rutin</h2>

                    <a href="{{ route('tugas_rutin.create') }}" class="btn btn-primary mb-3">
                        + Tambah Tugas Rutin
                    </a>

                    <div class="card text-dark">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tugas_rutin-table" class="table table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Jabatan</th>
                                            <th>Judul</th>
                                            <th>Keterangan</th>
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
            $('#tugas_rutin-table').DataTable({
                order: [[0, 'asc']],
                processing: true,
                serverSide: true,
                ajax: '{{ route('tugas_rutin.index') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'jabatan.nama', name: 'jabatan.nama' },
                    { data: 'judul', name: 'judul' },
                    { data: 'keterangan', name: 'keterangan' },
                    { data: 'progress', name: 'progress' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endsection

@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h2 class="mb-3">Daftar Tiket</h2>

                    <a href="{{ route('tiket.create') }}" class="btn btn-primary mb-3">
                        + Tambah Tiket
                    </a>

                    <div class="card text-dark">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tiket-table" class="table table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Judul</th>
                                            <th>Klien</th>
                                            <th>Jenis</th>
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
            $('#tiket-table').DataTable({
                order: [[0, 'desc']],
                processing: true,
                serverSide: true,
                ajax: '{{ route('tiket.index') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'judul', name: 'judul' },
                    { data: 'klien_nama', name: 'klien_nama' },
                    { data: 'jenis', name: 'jenis' },
                    { data: 'pembuat', name: 'pembuat' },
                    { data: 'delegasi', name: 'delegasi' },
                    { data: 'progress', name: 'progress' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endsection

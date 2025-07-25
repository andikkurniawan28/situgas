@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h2 class="mb-3">Daftar Produk</h2>

                    <a href="{{ route('produk.create') }}" class="btn btn-primary mb-3">
                        + Tambah Produk
                    </a>

                    <div class="card text-dark">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="produk-table" class="table table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Klien</th>
                                            <th>Judul</th>
                                            <th>Link Produk</th>
                                            <th>Status</th>
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
            $('#produk-table').DataTable({
                order: [[0, 'asc']],
                processing: true,
                serverSide: true,
                ajax: '{{ route('produk.index') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'klien.nama', name: 'klien.nama' },
                    { data: 'judul', name: 'judul' },
                    { data: 'link_produk', name: 'link_produk' },
                    { data: 'status_aktif', name: 'status_aktif' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endsection

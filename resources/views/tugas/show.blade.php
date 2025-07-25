@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <strong>Detail Tugas</strong>
                </div>
                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Judul</div>
                        <div class="col-md-9">{{ $tugas->judul }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Keterangan</div>
                        <div class="col-md-9">{!! nl2br(e($tugas->keterangan)) !!}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Dibuat Oleh</div>
                        <div class="col-md-9">
                            {{ $tugas->pembuat->nama }} ({{ $tugas->pembuat->jabatan->nama }})
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Didelegasikan Ke</div>
                        <div class="col-md-9">
                            {{ $tugas->delegasi->nama }} ({{ $tugas->delegasi->jabatan->nama }})
                        </div>
                    </div>

                    {{-- Gambar --}}
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Gambar 1</div>
                        <div class="col-md-9">
                            @if ($tugas->gambar1)
                                <img src="{{ asset('storage/' . $tugas->gambar1) }}" class="img-fluid rounded" width="300">
                            @else
                                <em>Tidak ada gambar</em>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Gambar 2</div>
                        <div class="col-md-9">
                            @if ($tugas->gambar2)
                                <img src="{{ asset('storage/' . $tugas->gambar2) }}" class="img-fluid rounded" width="300">
                            @else
                                <em>Tidak ada gambar</em>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Gambar 3</div>
                        <div class="col-md-9">
                            @if ($tugas->gambar3)
                                <img src="{{ asset('storage/' . $tugas->gambar3) }}" class="img-fluid rounded" width="300">
                            @else
                                <em>Tidak ada gambar</em>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('tugas.index') }}" class="btn btn-secondary">Kembali</a>
                        <a href="{{ route('tugas.edit', $tugas->id) }}" class="btn btn-primary">Edit</a>
                    </div>

                </div>
            </div>
        </div>
    </main>
@endsection

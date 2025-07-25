@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <strong>Detail Tiket</strong>
                </div>
                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Klien</div>
                        <div class="col-md-9">{{ $tiket->klien->nama }} ({{ $tiket->klien->perusahaan }})</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Jenis Tiket</div>
                        <div class="col-md-9">{{ $tiket->jenis_tiket->nama }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Judul</div>
                        <div class="col-md-9">{{ $tiket->judul }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Keterangan</div>
                        <div class="col-md-9">{!! nl2br(e($tiket->keterangan)) !!}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Dibuat Oleh</div>
                        <div class="col-md-9">
                            {{ $tiket->pembuat->nama }} ({{ $tiket->pembuat->jabatan->nama }})
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Didelegasikan Ke</div>
                        <div class="col-md-9">
                            {{ $tiket->delegasi->nama }} ({{ $tiket->delegasi->jabatan->nama }})
                        </div>
                    </div>

                    {{-- Gambar --}}
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Gambar 1</div>
                        <div class="col-md-9">
                            @if ($tiket->gambar1)
                                <img src="{{ asset('storage/' . $tiket->gambar1) }}" class="img-fluid rounded" width="300">
                            @else
                                <em>Tidak ada gambar</em>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Gambar 2</div>
                        <div class="col-md-9">
                            @if ($tiket->gambar2)
                                <img src="{{ asset('storage/' . $tiket->gambar2) }}" class="img-fluid rounded" width="300">
                            @else
                                <em>Tidak ada gambar</em>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Gambar 3</div>
                        <div class="col-md-9">
                            @if ($tiket->gambar3)
                                <img src="{{ asset('storage/' . $tiket->gambar3) }}" class="img-fluid rounded" width="300">
                            @else
                                <em>Tidak ada gambar</em>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('tiket.index') }}" class="btn btn-secondary">Kembali</a>
                        <a href="{{ route('tiket.edit', $tiket->id) }}" class="btn btn-primary">Edit</a>
                    </div>

                </div>
            </div>
        </div>
    </main>
@endsection

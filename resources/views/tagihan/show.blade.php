@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <strong>Detail Tagihan</strong>
                </div>
                <div class="card-body">

                    <!-- Klien -->
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Klien</div>
                        <div class="col-md-9">{{ $tagihan->klien->nama }} ({{ $tagihan->klien->perusahaan }})</div>
                    </div>

                    <!-- Keterangan -->
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Keterangan</div>
                        <div class="col-md-9">{!! nl2br(e($tagihan->keterangan)) !!}</div>
                    </div>

                    <!-- Total -->
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Total</div>
                        <div class="col-md-9">Rp {{ number_format($tagihan->total, 0, ',', '.') }}</div>
                    </div>

                    <!-- Status -->
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Status Pembayaran</div>
                        <div class="col-md-9">
                            @if ($tagihan->lunas)
                                <span class="badge bg-success text-white">Lunas</span>
                            @else
                                <span class="badge bg-warning text-dark">Belum Lunas</span>
                            @endif
                        </div>
                    </div>

                    <!-- Tanggal Buat dan Update -->
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Dibuat pada</div>
                        <div class="col-md-9">{{ $tagihan->created_at->format('d M Y H:i') }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Terakhir diperbarui</div>
                        <div class="col-md-9">{{ $tagihan->updated_at->format('d M Y H:i') }}</div>
                    </div>

                    <!-- Tombol -->
                    <div class="mt-4">
                        <a href="{{ route('tagihan.index') }}" class="btn btn-secondary">Kembali</a>
                        <a href="{{ route('tagihan.edit', $tagihan->id) }}" class="btn btn-primary">Edit</a>
                    </div>

                </div>
            </div>
        </div>
    </main>
@endsection

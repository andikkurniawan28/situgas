@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <strong>Detail Pelunasan</strong>
                </div>
                <div class="card-body">

                    <!-- Tagihan -->
                    <div class="form-group">
                        <label>Tagihan</label>
                        <p class="form-control-plaintext">
                            #{{ $pelunasan->tagihan->id }} - {{ $pelunasan->tagihan->keterangan }}
                        </p>
                    </div>

                    <!-- Akun -->
                    <div class="form-group mt-3">
                        <label>Akun</label>
                        <p class="form-control-plaintext">
                            {{ $pelunasan->akun->nama }}
                        </p>
                    </div>

                    <!-- Total -->
                    <div class="form-group mt-3">
                        <label>Total Pelunasan (Rp)</label>
                        <p class="form-control-plaintext">
                            Rp {{ number_format($pelunasan->total, 0, ',', '.') }}
                        </p>
                    </div>

                    <!-- Tanggal Dibuat -->
                    <div class="form-group mt-3">
                        <label>Tanggal Dibuat</label>
                        <p class="form-control-plaintext">
                            {{ $pelunasan->created_at->format('d-m-Y H:i') }}
                        </p>
                    </div>

                    <!-- Dibuat Oleh -->
                    <div class="form-group mt-3">
                        <label>Dibuat Oleh</label>
                        <p class="form-control-plaintext">
                            {{ $pelunasan->user->nama ?? '-' }}
                        </p>
                    </div>

                    <!-- Tombol -->
                    <a href="{{ route('pelunasan.index') }}" class="btn btn-secondary mt-4">Kembali</a>
                </div>
            </div>
        </div>
    </main>
@endsection

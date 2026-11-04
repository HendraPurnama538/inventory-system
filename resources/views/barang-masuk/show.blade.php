@extends('layouts.app')
@section('title', 'Detail Barang Masuk')
@section('content')
<div class="page-header fade-in-up">
    <h1 class="page-title">Detail Transaksi Masuk</h1>
    <a href="{{ route('barang-masuk.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>
<div class="row justify-content-center fade-in-up">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-arrow-down-circle-fill text-success me-2"></i>Detail Barang Masuk</span>
                <span class="badge bg-success">Masuk</span>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4 text-muted">No. Referensi</dt>
                    <dd class="col-sm-8">{{ $barangMasuk->no_referensi ?? '-' }}</dd>
                    <dt class="col-sm-4 text-muted">Tanggal</dt>
                    <dd class="col-sm-8">{{ $barangMasuk->tanggal_masuk->locale('id')->isoFormat('dddd, D MMMM Y') }}</dd>
                    <dt class="col-sm-4 text-muted">Barang</dt>
                    <dd class="col-sm-8 fw-semibold">{{ $barangMasuk->barang->nama_barang ?? '-' }}</dd>
                    <dt class="col-sm-4 text-muted">Kode Barang</dt>
                    <dd class="col-sm-8"><span class="badge bg-primary-subtle text-primary">{{ $barangMasuk->barang->kode_barang ?? '-' }}</span></dd>
                    <dt class="col-sm-4 text-muted">Jumlah</dt>
                    <dd class="col-sm-8 fw-semibold text-success">+{{ $barangMasuk->jumlah }} {{ $barangMasuk->barang->satuan ?? '' }}</dd>
                    <dt class="col-sm-4 text-muted">Harga Beli</dt>
                    <dd class="col-sm-8">Rp {{ number_format($barangMasuk->harga_beli, 0, ',', '.') }}</dd>
                    <dt class="col-sm-4 text-muted">Total Harga</dt>
                    <dd class="col-sm-8 fw-bold fs-5 text-success">Rp {{ number_format($barangMasuk->total_harga, 0, ',', '.') }}</dd>
                    <dt class="col-sm-4 text-muted">Admin</dt>
                    <dd class="col-sm-8">{{ $barangMasuk->user->name ?? '-' }}</dd>
                    <dt class="col-sm-4 text-muted">Keterangan</dt>
                    <dd class="col-sm-8">{{ $barangMasuk->keterangan ?? '-' }}</dd>
                    <dt class="col-sm-4 text-muted">Dicatat Pada</dt>
                    <dd class="col-sm-8 text-muted" style="font-size:.85rem;">{{ $barangMasuk->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection

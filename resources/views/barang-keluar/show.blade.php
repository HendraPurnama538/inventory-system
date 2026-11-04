@extends('layouts.app')
@section('title', 'Detail Barang Keluar')
@section('content')
<div class="page-header fade-in-up">
    <h1 class="page-title">Detail Transaksi Keluar</h1>
    <a href="{{ route('barang-keluar.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>
<div class="row justify-content-center fade-in-up">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-arrow-up-circle-fill text-danger me-2"></i>Detail Barang Keluar</span>
                <span class="badge bg-danger">Keluar</span>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4 text-muted">No. Referensi</dt>
                    <dd class="col-sm-8">{{ $barangKeluar->no_referensi ?? '-' }}</dd>
                    <dt class="col-sm-4 text-muted">Tanggal</dt>
                    <dd class="col-sm-8">{{ $barangKeluar->tanggal_keluar->locale('id')->isoFormat('dddd, D MMMM Y') }}</dd>
                    <dt class="col-sm-4 text-muted">Barang</dt>
                    <dd class="col-sm-8 fw-semibold">{{ $barangKeluar->barang->nama_barang ?? '-' }}</dd>
                    <dt class="col-sm-4 text-muted">Kode Barang</dt>
                    <dd class="col-sm-8"><span class="badge bg-primary-subtle text-primary">{{ $barangKeluar->barang->kode_barang ?? '-' }}</span></dd>
                    <dt class="col-sm-4 text-muted">Jumlah</dt>
                    <dd class="col-sm-8 fw-semibold text-danger">-{{ $barangKeluar->jumlah }} {{ $barangKeluar->barang->satuan ?? '' }}</dd>
                    <dt class="col-sm-4 text-muted">Harga Jual</dt>
                    <dd class="col-sm-8">Rp {{ number_format($barangKeluar->harga_jual, 0, ',', '.') }}</dd>
                    <dt class="col-sm-4 text-muted">Total Harga</dt>
                    <dd class="col-sm-8 fw-bold fs-5 text-danger">Rp {{ number_format($barangKeluar->total_harga, 0, ',', '.') }}</dd>
                    <dt class="col-sm-4 text-muted">Admin</dt>
                    <dd class="col-sm-8">{{ $barangKeluar->user->name ?? '-' }}</dd>
                    <dt class="col-sm-4 text-muted">Keterangan</dt>
                    <dd class="col-sm-8">{{ $barangKeluar->keterangan ?? '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection

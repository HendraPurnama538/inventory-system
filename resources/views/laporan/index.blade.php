@extends('layouts.app')
@section('title', 'Laporan & Export')
@section('breadcrumb')
    <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')
<div class="page-header fade-in-up">
    <div>
        <h1 class="page-title">Laporan & Export</h1>
        <p class="page-subtitle">Download laporan dalam format PDF atau Excel</p>
    </div>
</div>

<div class="row g-3 fade-in-up">

    {{-- Export Barang --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-box-seam me-2 text-primary"></i>Laporan Data Barang
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">
                    Export seluruh data master barang beserta informasi stok, harga, kategori, dan supplier.
                </p>
                <form method="GET">
                    <div class="mb-3">
                        <label class="form-label">Filter Kategori</label>
                        <select name="kategori_id" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach(\App\Models\Kategori::orderBy('nama_kategori')->get() as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" formaction="{{ route('laporan.pdf.barang') }}"
                                class="btn btn-danger">
                            <i class="bi bi-file-earmark-pdf me-2"></i>Export PDF
                        </button>
                        <button type="submit" formaction="{{ route('laporan.excel.barang') }}"
                                class="btn btn-success">
                            <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Export Barang Masuk --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-arrow-down-circle text-success me-2"></i>Laporan Barang Masuk
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">
                    Export laporan transaksi penerimaan barang berdasarkan rentang tanggal.
                </p>
                <form method="GET">
                    <div class="mb-2">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" name="dari" class="form-control"
                               value="{{ now()->startOfMonth()->toDateString() }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="sampai" class="form-control"
                               value="{{ now()->toDateString() }}">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" formaction="{{ route('laporan.pdf.masuk') }}"
                                class="btn btn-danger">
                            <i class="bi bi-file-earmark-pdf me-2"></i>Export PDF
                        </button>
                        <button type="submit" formaction="{{ route('laporan.excel.masuk') }}"
                                class="btn btn-success">
                            <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Export Barang Keluar --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-arrow-up-circle text-danger me-2"></i>Laporan Barang Keluar
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">
                    Export laporan transaksi pengeluaran barang berdasarkan rentang tanggal.
                </p>
                <form method="GET">
                    <div class="mb-2">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" name="dari" class="form-control"
                               value="{{ now()->startOfMonth()->toDateString() }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="sampai" class="form-control"
                               value="{{ now()->toDateString() }}">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" formaction="{{ route('laporan.pdf.keluar') }}"
                                class="btn btn-danger">
                            <i class="bi bi-file-earmark-pdf me-2"></i>Export PDF
                        </button>
                        <button type="submit" formaction="{{ route('laporan.excel.keluar') }}"
                                class="btn btn-success">
                            <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

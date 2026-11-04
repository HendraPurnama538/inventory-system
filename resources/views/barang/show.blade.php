@extends('layouts.app')
@section('title', 'Detail Barang')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('barang.index') }}">Barang</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="page-header fade-in-up">
    <div>
        <h1 class="page-title">Detail Barang</h1>
        <p class="page-subtitle">{{ $barang->kode_barang }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('barang.edit', $barang) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="row g-3 fade-in-up">
    {{-- Info Barang --}}
    <div class="col-lg-4">
        <div class="card text-center">
            <div class="card-body">
                <img src="{{ $barang->gambar_url }}" alt="{{ $barang->nama_barang }}"
                     class="rounded-3 mb-3" style="width:100%; max-height:220px; object-fit:cover;">
                <h5 class="fw-bold mb-1">{{ $barang->nama_barang }}</h5>
                <div class="badge bg-primary-subtle text-primary mb-3">{{ $barang->kode_barang }}</div>

                <div class="d-flex justify-content-center gap-3 mb-3">
                    @if($barang->is_stok_menipis)
                        <div class="text-center">
                            <div class="fs-3 fw-bold text-danger">{{ $barang->stok }}</div>
                            <small class="text-muted">{{ $barang->satuan }}</small>
                            <div class="badge bg-danger mt-1">Stok Menipis!</div>
                        </div>
                    @else
                        <div class="text-center">
                            <div class="fs-3 fw-bold text-success">{{ $barang->stok }}</div>
                            <small class="text-muted">{{ $barang->satuan }}</small>
                            <div class="badge bg-success mt-1">Stok Aman</div>
                        </div>
                    @endif
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('barang-masuk.create') }}?barang_id={{ $barang->id }}"
                       class="btn btn-success btn-sm">
                        <i class="bi bi-arrow-down-circle me-1"></i>Catat Masuk
                    </a>
                    <a href="{{ route('barang-keluar.create') }}?barang_id={{ $barang->id }}"
                       class="btn btn-danger btn-sm">
                        <i class="bi bi-arrow-up-circle me-1"></i>Catat Keluar
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Info --}}
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header">Informasi Lengkap</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4 text-muted">Kode Barang</dt>
                    <dd class="col-sm-8 fw-semibold">{{ $barang->kode_barang }}</dd>

                    <dt class="col-sm-4 text-muted">Kategori</dt>
                    <dd class="col-sm-8">
                        <span class="badge bg-primary-subtle text-primary">
                            {{ $barang->kategori->nama_kategori ?? '-' }}
                        </span>
                    </dd>

                    <dt class="col-sm-4 text-muted">Supplier</dt>
                    <dd class="col-sm-8">{{ $barang->supplier->nama_supplier ?? '-' }}</dd>

                    <dt class="col-sm-4 text-muted">Satuan</dt>
                    <dd class="col-sm-8">{{ $barang->satuan }}</dd>

                    <dt class="col-sm-4 text-muted">Harga Beli</dt>
                    <dd class="col-sm-8 fw-semibold">Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</dd>

                    <dt class="col-sm-4 text-muted">Harga Jual</dt>
                    <dd class="col-sm-8 fw-semibold text-success">Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</dd>

                    <dt class="col-sm-4 text-muted">Stok Saat Ini</dt>
                    <dd class="col-sm-8">
                        {{ $barang->stok }} {{ $barang->satuan }}
                        <small class="text-muted">(min: {{ $barang->stok_minimal }})</small>
                    </dd>

                    <dt class="col-sm-4 text-muted">Nilai Stok</dt>
                    <dd class="col-sm-8 fw-semibold">
                        Rp {{ number_format($barang->stok * $barang->harga_beli, 0, ',', '.') }}
                    </dd>

                    @if($barang->keterangan)
                    <dt class="col-sm-4 text-muted">Keterangan</dt>
                    <dd class="col-sm-8">{{ $barang->keterangan }}</dd>
                    @endif
                </dl>
            </div>
        </div>

        {{-- Tab Riwayat --}}
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="riwayatTab">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tabMasuk">
                            <i class="bi bi-arrow-down-circle text-success me-1"></i>
                            Masuk ({{ $riwayatMasuk->count() }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tabKeluar">
                            <i class="bi bi-arrow-up-circle text-danger me-1"></i>
                            Keluar ({{ $riwayatKeluar->count() }})
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-0 tab-content">
                <div class="tab-pane fade show active" id="tabMasuk">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead><tr>
                                <th class="ps-3">Tanggal</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Harga Beli</th>
                                <th class="text-end pe-3">Total</th>
                            </tr></thead>
                            <tbody>
                                @forelse($riwayatMasuk as $m)
                                <tr>
                                    <td class="ps-3" style="font-size:.85rem;">
                                        {{ $m->tanggal_masuk->locale('id')->isoFormat('D MMM Y') }}
                                        <div class="text-muted" style="font-size:.75rem;">{{ $m->no_referensi ?? '-' }}</div>
                                    </td>
                                    <td class="text-center fw-semibold text-success">+{{ $m->jumlah }}</td>
                                    <td class="text-end" style="font-size:.85rem;">Rp {{ number_format($m->harga_beli, 0, ',', '.') }}</td>
                                    <td class="text-end pe-3 fw-semibold" style="font-size:.85rem;">Rp {{ number_format($m->total_harga, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-3 text-muted">Belum ada riwayat masuk</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="tabKeluar">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead><tr>
                                <th class="ps-3">Tanggal</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Harga Jual</th>
                                <th class="text-end pe-3">Total</th>
                            </tr></thead>
                            <tbody>
                                @forelse($riwayatKeluar as $k)
                                <tr>
                                    <td class="ps-3" style="font-size:.85rem;">
                                        {{ $k->tanggal_keluar->locale('id')->isoFormat('D MMM Y') }}
                                        <div class="text-muted" style="font-size:.75rem;">{{ $k->no_referensi ?? '-' }}</div>
                                    </td>
                                    <td class="text-center fw-semibold text-danger">-{{ $k->jumlah }}</td>
                                    <td class="text-end" style="font-size:.85rem;">Rp {{ number_format($k->harga_jual, 0, ',', '.') }}</td>
                                    <td class="text-end pe-3 fw-semibold" style="font-size:.85rem;">Rp {{ number_format($k->total_harga, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-3 text-muted">Belum ada riwayat keluar</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

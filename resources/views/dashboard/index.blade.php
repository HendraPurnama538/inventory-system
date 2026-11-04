@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@push('styles')
<style>
    .stat-card .card-body { padding: 1.25rem; }
    .chart-container { position: relative; height: 280px; }
    .transaction-badge { font-size: .7rem; padding: .25rem .5rem; }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header fade-in-up">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Selamat datang, {{ auth()->user()->name }} — {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
    </div>
    <a href="{{ route('barang-masuk.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Catat Barang Masuk
    </a>
</div>

{{-- ── Stat Cards ─────────────────────────────────────────────────── --}}
<div class="row g-3 mb-4 fade-in-up">

    <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="background: linear-gradient(135deg,#4f46e5,#7c3aed); color:#fff;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="mb-0 opacity-75" style="font-size:.8rem;">Total Barang</p>
                        <h2 class="mb-0 fw-bold">{{ number_format($totalBarang) }}</h2>
                    </div>
                    <div class="stat-icon" style="background:rgba(255,255,255,.15);">
                        <i class="bi bi-box-seam text-white"></i>
                    </div>
                </div>
                <a href="{{ route('barang.index') }}" class="text-white-50 text-decoration-none" style="font-size:.75rem;">
                    Lihat semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="background: linear-gradient(135deg,#0ea5e9,#0284c7); color:#fff;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="mb-0 opacity-75" style="font-size:.8rem;">Total Kategori</p>
                        <h2 class="mb-0 fw-bold">{{ number_format($totalKategori) }}</h2>
                    </div>
                    <div class="stat-icon" style="background:rgba(255,255,255,.15);">
                        <i class="bi bi-tag text-white"></i>
                    </div>
                </div>
                <a href="{{ route('kategori.index') }}" class="text-white-50 text-decoration-none" style="font-size:.75rem;">
                    Lihat semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="background: linear-gradient(135deg,#10b981,#059669); color:#fff;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="mb-0 opacity-75" style="font-size:.8rem;">Total Supplier</p>
                        <h2 class="mb-0 fw-bold">{{ number_format($totalSupplier) }}</h2>
                    </div>
                    <div class="stat-icon" style="background:rgba(255,255,255,.15);">
                        <i class="bi bi-truck text-white"></i>
                    </div>
                </div>
                <a href="{{ route('supplier.index') }}" class="text-white-50 text-decoration-none" style="font-size:.75rem;">
                    Lihat semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="background: linear-gradient(135deg,#f59e0b,#d97706); color:#fff;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="mb-0 opacity-75" style="font-size:.8rem;">Nilai Stok</p>
                        <h2 class="mb-0 fw-bold" style="font-size:1.1rem;">
                            Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}
                        </h2>
                    </div>
                    <div class="stat-icon" style="background:rgba(255,255,255,.15);">
                        <i class="bi bi-currency-dollar text-white"></i>
                    </div>
                </div>
                <span class="text-white-50" style="font-size:.75rem;">Total nilai inventaris</span>
            </div>
        </div>
    </div>

</div>

{{-- ── Transaksi Hari Ini ──────────────────────────────────────────── --}}
<div class="row g-3 mb-4 fade-in-up">
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body py-3">
                <div class="mb-2">
                    <i class="bi bi-arrow-down-circle-fill text-success fs-2"></i>
                </div>
                <h4 class="fw-bold text-success mb-0">{{ number_format($masukHariIni) }}</h4>
                <small class="text-muted">Masuk Hari Ini</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body py-3">
                <div class="mb-2">
                    <i class="bi bi-arrow-up-circle-fill text-danger fs-2"></i>
                </div>
                <h4 class="fw-bold text-danger mb-0">{{ number_format($keluarHariIni) }}</h4>
                <small class="text-muted">Keluar Hari Ini</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body py-3">
                <div class="mb-2">
                    <i class="bi bi-exclamation-triangle-fill text-warning fs-2"></i>
                </div>
                <h4 class="fw-bold text-warning mb-0">{{ $stokMenipis->count() }}</h4>
                <small class="text-muted">Stok Menipis</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100">
            <div class="card-body py-3 d-flex flex-column justify-content-center gap-2">
                <a href="{{ route('barang-masuk.create') }}" class="btn btn-success btn-sm w-100">
                    <i class="bi bi-plus-circle me-1"></i>Barang Masuk
                </a>
                <a href="{{ route('barang-keluar.create') }}" class="btn btn-danger btn-sm w-100">
                    <i class="bi bi-dash-circle me-1"></i>Barang Keluar
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ── Charts ──────────────────────────────────────────────────────── --}}
<div class="row g-3 mb-4 fade-in-up">

    {{-- Line Chart: Transaksi 7 Hari --}}
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-graph-up me-2 text-primary"></i>Transaksi 7 Hari Terakhir</span>
                <div class="d-flex gap-2" style="font-size:.75rem;">
                    <span class="badge bg-success-subtle text-success">● Masuk</span>
                    <span class="badge bg-danger-subtle text-danger">● Keluar</span>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="chartTransaksi"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Pie Chart: Distribusi Kategori --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-pie-chart me-2 text-primary"></i>Distribusi Kategori
            </div>
            <div class="card-body">
                <div class="chart-container" style="height:240px;">
                    <canvas id="chartKategori"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ── Baris 3: Stok Menipis + Transaksi Terbaru ──────────────────── --}}
<div class="row g-3 fade-in-up">

    {{-- Stok Menipis --}}
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
                <span><i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>Stok Menipis</span>
                <a href="{{ route('barang.index') }}" class="btn btn-sm btn-outline-primary" style="font-size:.75rem;">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body p-0">
                @if($stokMenipis->isEmpty())
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-check-circle-fill text-success fs-2 d-block mb-2"></i>
                        Semua stok dalam kondisi aman
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-3">Barang</th>
                                    <th class="text-center">Stok</th>
                                    <th class="text-center">Min.</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stokMenipis as $b)
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-semibold" style="font-size:.85rem;">{{ $b->nama_barang }}</div>
                                        <div class="text-muted" style="font-size:.75rem;">{{ $b->kategori->nama_kategori ?? '-' }}</div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger">{{ $b->stok }}</span>
                                    </td>
                                    <td class="text-center text-muted" style="font-size:.8rem;">{{ $b->stok_minimal }}</td>
                                    <td>
                                        <a href="{{ route('barang-masuk.create') }}" class="btn btn-xs btn-outline-success"
                                           style="font-size:.7rem; padding:.15rem .4rem; border-radius:6px;">
                                            <i class="bi bi-plus"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Transaksi Terbaru --}}
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-clock-history me-2 text-primary"></i>Transaksi Terbaru
            </div>
            <div class="card-body p-0">
                @if($transaksiTerbaru->isEmpty())
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>Belum ada transaksi
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-3">Barang</th>
                                    <th class="text-center">Tipe</th>
                                    <th class="text-center">Jml</th>
                                    <th class="text-end pe-3">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksiTerbaru as $t)
                                <tr>
                                    <td class="ps-3" style="font-size:.85rem;">
                                        {{ $t['barang']['nama_barang'] ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        @if($t['tipe'] === 'masuk')
                                            <span class="badge bg-success transaction-badge">Masuk</span>
                                        @else
                                            <span class="badge bg-danger transaction-badge">Keluar</span>
                                        @endif
                                    </td>
                                    <td class="text-center fw-semibold" style="font-size:.85rem;">
                                        {{ number_format($t['jumlah']) }}
                                    </td>
                                    <td class="text-end pe-3 text-muted" style="font-size:.78rem;">
                                        {{ \Carbon\Carbon::parse($t['tanggal'])->locale('id')->isoFormat('D MMM Y') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.plugins.legend.labels.usePointStyle = true;

    // ── Grafik Transaksi ─────────────────────────────────
    new Chart(document.getElementById('chartTransaksi'), {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [
                {
                    label: 'Barang Masuk',
                    data: @json($dataMasuk),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16,185,129,.1)',
                    tension: .4,
                    fill: true,
                    pointBackgroundColor: '#10b981',
                    pointRadius: 4,
                },
                {
                    label: 'Barang Keluar',
                    data: @json($dataKeluar),
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239,68,68,.1)',
                    tension: .4,
                    fill: true,
                    pointBackgroundColor: '#ef4444',
                    pointRadius: 4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'top', align: 'end' } },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,.05)' },
                    ticks: { stepSize: 1 }
                },
                x: { grid: { display: false } }
            }
        }
    });

    // ── Grafik Distribusi Kategori ───────────────────────
    const kategoriLabels = @json($distribusiKategori->pluck('nama_kategori'));
    const kategoriData   = @json($distribusiKategori->pluck('barangs_count'));
    const colors = ['#4f46e5','#0ea5e9','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899'];

    new Chart(document.getElementById('chartKategori'), {
        type: 'doughnut',
        data: {
            labels: kategoriLabels,
            datasets: [{
                data: kategoriData,
                backgroundColor: colors.slice(0, kategoriLabels.length),
                borderWidth: 2,
                borderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { padding: 12, font: { size: 11 } } }
            },
            cutout: '65%',
        }
    });
</script>
@endpush

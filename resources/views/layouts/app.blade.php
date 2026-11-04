<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Sistem Inventaris</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --navbar-height: 60px;
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --sidebar-bg: #1e1b4b;
            --sidebar-text: #a5b4fc;
            --sidebar-active: #4f46e5;
            --bg-body: #f1f5f9;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-body);
            color: #334155;
            min-height: 100vh;
        }

        /* ── Sidebar ─────────────────────────────────── */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            z-index: 1030;
            display: flex;
            flex-direction: column;
            transition: transform .3s ease;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex;
            align-items: center;
            gap: .75rem;
            text-decoration: none;
            color: #fff;
        }

        .sidebar-brand .brand-icon {
            width: 38px; height: 38px;
            background: var(--primary);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .sidebar-brand .brand-text {
            font-size: .9rem;
            font-weight: 700;
            line-height: 1.2;
            color: #fff;
        }

        .sidebar-brand .brand-text small {
            display: block;
            font-size: .7rem;
            font-weight: 400;
            color: var(--sidebar-text);
        }

        .sidebar-nav { padding: 1rem 0; flex: 1; }

        .nav-label {
            padding: .5rem 1.5rem .25rem;
            font-size: .65rem;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: rgba(165,180,252,.45);
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .55rem 1.5rem;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: .875rem;
            font-weight: 500;
            border-radius: 0;
            transition: all .2s;
            position: relative;
        }

        .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,.07);
        }

        .nav-link.active {
            color: #fff;
            background: rgba(79,70,229,.25);
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 3px;
            background: var(--primary);
            border-radius: 0 4px 4px 0;
        }

        .nav-link i { font-size: 1rem; width: 1.2rem; text-align: center; }

        /* ── Navbar ──────────────────────────────────── */
        .main-navbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--navbar-height);
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            z-index: 1020;
            gap: 1rem;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            padding: 1.5rem;
            min-height: calc(100vh - var(--navbar-height));
        }

        /* ── Cards ───────────────────────────────────── */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.06);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #f1f5f9;
            padding: 1rem 1.25rem;
            font-weight: 600;
        }

        .stat-card {
            border-radius: 12px;
            border: none;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0,0,0,.12);
        }

        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        /* ── Badges & Alert ──────────────────────────── */
        .badge { font-weight: 500; }

        /* ── Table ───────────────────────────────────── */
        .table { font-size: .875rem; }
        .table th { font-weight: 600; color: #64748b; font-size: .75rem; text-transform: uppercase; letter-spacing: .05em; }
        .table-hover tbody tr:hover { background: #f8fafc; }

        /* ── Buttons ─────────────────────────────────── */
        .btn { font-weight: 500; font-size: .875rem; border-radius: 8px; }
        .btn-sm { font-size: .8rem; }
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }

        /* ── Forms ───────────────────────────────────── */
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            font-size: .875rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79,70,229,.1);
        }
        .form-label { font-weight: 500; font-size: .875rem; color: #475569; }

        /* ── Page Header ─────────────────────────────── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: .75rem;
        }

        .page-title { font-size: 1.25rem; font-weight: 700; color: #1e293b; margin: 0; }
        .page-subtitle { font-size: .8rem; color: #64748b; margin: 0; }

        /* ── Responsive ──────────────────────────────── */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-navbar {
                left: 0;
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.5);
                z-index: 1029;
            }
            .sidebar-overlay.show {
                display: block;
            }
        }

        /* ── Animations ──────────────────────────────── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up { animation: fadeInUp .4s ease both; }

        /* ── Scrollbar ───────────────────────────────── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>

    @stack('styles')
</head>
<body>

{{-- Sidebar Overlay (mobile) --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>

{{-- ══════════════ SIDEBAR ══════════════ --}}
<aside class="sidebar" id="sidebar">

    {{-- Brand --}}
    <a href="{{ route('dashboard') }}" class="sidebar-brand">
        <div class="brand-icon">
            <i class="bi bi-boxes text-white"></i>
        </div>
        <div class="brand-text">
            Sistem Inventaris
            <small>Management System</small>
        </div>
    </a>

    {{-- Navigation --}}
    <nav class="sidebar-nav">

        <div class="nav-label">Main</div>

        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span>
        </a>

        <div class="nav-label mt-2">Master Data</div>

        <a href="{{ route('barang.index') }}"
           class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam-fill"></i>
            <span>Data Barang</span>
        </a>

        <a href="{{ route('kategori.index') }}"
           class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
            <i class="bi bi-tag-fill"></i>
            <span>Kategori</span>
        </a>

        <a href="{{ route('supplier.index') }}"
           class="nav-link {{ request()->routeIs('supplier.*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i>
            <span>Supplier</span>
        </a>

        <div class="nav-label mt-2">Transaksi</div>

        <a href="{{ route('barang-masuk.index') }}"
           class="nav-link {{ request()->routeIs('barang-masuk.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-down-circle-fill text-success"></i>
            <span>Barang Masuk</span>
        </a>

        <a href="{{ route('barang-keluar.index') }}"
           class="nav-link {{ request()->routeIs('barang-keluar.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-up-circle-fill text-danger"></i>
            <span>Barang Keluar</span>
        </a>

        <div class="nav-label mt-2">Laporan</div>

        <a href="{{ route('laporan.index') }}"
           class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-bar-graph-fill"></i>
            <span>Export Laporan</span>
        </a>

        <div class="nav-label mt-2">Akun</div>

        <a href="{{ route('profil.index') }}"
           class="nav-link {{ request()->routeIs('profil.*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i>
            <span>Profil</span>
        </a>

    </nav>

    {{-- Sidebar Footer --}}
    <div style="padding: 1rem 1.5rem; border-top: 1px solid rgba(255,255,255,.08);">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn w-100 text-start d-flex align-items-center gap-2"
                    style="color: var(--sidebar-text); background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.2); font-size: .85rem; border-radius: 8px;">
                <i class="bi bi-box-arrow-right text-danger"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>

</aside>

{{-- ══════════════ NAVBAR ══════════════ --}}
<nav class="main-navbar">

    {{-- Toggle sidebar (mobile) --}}
    <button class="btn btn-light btn-sm d-lg-none" id="sidebarToggle">
        <i class="bi bi-list fs-5"></i>
    </button>

    {{-- Page breadcrumb --}}
    <div class="flex-grow-1">
        <nav aria-label="breadcrumb" class="d-none d-md-block">
            <ol class="breadcrumb mb-0" style="font-size: .8rem;">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a>
                </li>
                @yield('breadcrumb')
            </ol>
        </nav>
    </div>

    {{-- Right actions --}}
    <div class="d-flex align-items-center gap-2">
        {{-- Stok menipis alert --}}
        @php
            $stokMenipisCount = \App\Models\Barang::stokMenipis()->count();
        @endphp
        @if($stokMenipisCount > 0)
        <a href="{{ route('barang.index') }}" class="btn btn-warning btn-sm position-relative">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span class="d-none d-md-inline ms-1">Stok Menipis</span>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                  style="font-size: .6rem;">{{ $stokMenipisCount }}</span>
        </a>
        @endif

        {{-- User dropdown --}}
        <div class="dropdown">
            <button class="btn btn-light btn-sm dropdown-toggle d-flex align-items-center gap-2"
                    data-bs-toggle="dropdown">
                <img src="{{ auth()->user()->avatar_url }}"
                     alt="Avatar" width="28" height="28"
                     class="rounded-circle object-fit-cover">
                <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="font-size: .875rem;">
                <li>
                    <a class="dropdown-item" href="{{ route('profil.index') }}">
                        <i class="bi bi-person me-2"></i>Profil Saya
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

</nav>

{{-- ══════════════ MAIN CONTENT ══════════════ --}}
<main class="main-content">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-3 fade-in-up" role="alert">
            <i class="bi bi-check-circle-fill flex-shrink-0"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-3 fade-in-up" role="alert">
            <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center gap-2 mb-3 fade-in-up" role="alert">
            <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
            <span>{{ session('warning') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')

</main>

{{-- Bootstrap 5 JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Sidebar toggle untuk mobile
    const sidebar        = document.getElementById('sidebar');
    const overlay        = document.getElementById('sidebarOverlay');
    const toggleBtn      = document.getElementById('sidebarToggle');

    function openSidebar() {
        sidebar.classList.add('show');
        overlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
        document.body.style.overflow = '';
    }

    toggleBtn?.addEventListener('click', openSidebar);
    overlay?.addEventListener('click', closeSidebar);

    // Auto-hide alert setelah 5 detik
    document.querySelectorAll('.alert').forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }, 5000);
    });
</script>

@stack('scripts')

</body>
</html>

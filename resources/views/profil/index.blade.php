@extends('layouts.app')
@section('title', 'Profil Admin')
@section('breadcrumb')
    <li class="breadcrumb-item active">Profil</li>
@endsection

@section('content')
<div class="page-header fade-in-up">
    <div>
        <h1 class="page-title">Profil Admin</h1>
        <p class="page-subtitle">Kelola informasi akun Anda</p>
    </div>
</div>

<div class="row g-3 fade-in-up">

    {{-- Avatar --}}
    <div class="col-lg-4">
        <div class="card text-center">
            <div class="card-body py-4">
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                     width="100" height="100"
                     class="rounded-circle mb-3 object-fit-cover"
                     style="border: 3px solid #4f46e5; padding: 3px;">
                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <p class="text-muted mb-3" style="font-size:.875rem;">{{ $user->email }}</p>
                <span class="badge bg-primary">Administrator</span>

                <hr>

                <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="mb-3 text-start">
                        <label class="form-label">Ganti Foto</label>
                        <input type="file" name="avatar" accept="image/*" class="form-control">
                        <div class="form-text">JPG, PNG, WebP — Maks. 1MB</div>
                        @error('avatar')
                            <div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Hidden fields to pass validation for other fields --}}
                    <input type="hidden" name="name"  value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    <input type="hidden" name="phone" value="{{ $user->phone }}">

                    <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                        <i class="bi bi-upload me-1"></i>Upload Foto
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Profil + Ganti Password --}}
    <div class="col-lg-8">

        {{-- Form Edit Profil --}}
        <div class="card mb-3">
            <div class="card-header"><i class="bi bi-person me-2 text-primary"></i>Informasi Profil</div>
            <div class="card-body">
                <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="phone"
                                   class="form-control"
                                   value="{{ old('phone', $user->phone) }}"
                                   placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Simpan Profil
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Form Ganti Password --}}
        <div class="card">
            <div class="card-header"><i class="bi bi-lock me-2 text-warning"></i>Ganti Password</div>
            <div class="card-body">
                <form method="POST" action="{{ route('profil.password') }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                            <input type="password" name="current_password"
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   autocomplete="current-password">
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   autocomplete="new-password">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation"
                                   class="form-control"
                                   autocomplete="new-password">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-key me-1"></i>Perbarui Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

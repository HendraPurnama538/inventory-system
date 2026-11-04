@extends('layouts.app')
@section('title', 'Tambah Supplier')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Supplier</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="page-header fade-in-up">
    <div>
        <h1 class="page-title">Tambah Supplier</h1>
        <p class="page-subtitle">Daftarkan supplier/pemasok baru</p>
    </div>
    <a href="{{ route('supplier.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row justify-content-center fade-in-up">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header"><i class="bi bi-truck me-2 text-primary"></i>Form Supplier</div>
            <div class="card-body">
                <form method="POST" action="{{ route('supplier.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Supplier <span class="text-danger">*</span></label>
                            <input type="text" name="nama_supplier"
                                   class="form-control @error('nama_supplier') is-invalid @enderror"
                                   value="{{ old('nama_supplier') }}" placeholder="PT. Maju Jaya">
                            @error('nama_supplier')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="telepon"
                                   class="form-control @error('telepon') is-invalid @enderror"
                                   value="{{ old('telepon') }}" placeholder="021-12345678">
                            @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="supplier@email.com">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" rows="2"
                                      class="form-control @error('alamat') is-invalid @enderror"
                                      placeholder="Alamat lengkap supplier...">{{ old('alamat') }}</textarea>
                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" rows="2"
                                      class="form-control">{{ old('keterangan') }}</textarea>
                        </div>
                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-check-lg me-1"></i>Simpan Supplier
                            </button>
                            <a href="{{ route('supplier.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

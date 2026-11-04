@extends('layouts.app')
@section('title', 'Edit Supplier')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Supplier</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="page-header fade-in-up">
    <div>
        <h1 class="page-title">Edit Supplier</h1>
        <p class="page-subtitle">{{ $supplier->nama_supplier }}</p>
    </div>
    <a href="{{ route('supplier.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row justify-content-center fade-in-up">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header"><i class="bi bi-pencil me-2 text-warning"></i>Edit: {{ $supplier->nama_supplier }}</div>
            <div class="card-body">
                <form method="POST" action="{{ route('supplier.update', $supplier) }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Supplier <span class="text-danger">*</span></label>
                            <input type="text" name="nama_supplier"
                                   class="form-control @error('nama_supplier') is-invalid @enderror"
                                   value="{{ old('nama_supplier', $supplier->nama_supplier) }}">
                            @error('nama_supplier')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="telepon"
                                   class="form-control"
                                   value="{{ old('telepon', $supplier->telepon) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $supplier->email) }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" rows="2" class="form-control">{{ old('alamat', $supplier->alamat) }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" rows="2" class="form-control">{{ old('keterangan', $supplier->keterangan) }}</textarea>
                        </div>
                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-warning flex-grow-1">
                                <i class="bi bi-save me-1"></i>Perbarui Supplier
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

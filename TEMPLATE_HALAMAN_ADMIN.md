# 📄 Template Halaman Admin

Template siap pakai untuk membuat halaman admin yang konsisten dan modern.

## 1. Template Index/List Page

```blade
@extends('layouts.app')
@section('title', 'Judul Halaman')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card page-header-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between text-white">
                        <div class="d-flex align-items-center">
                            <div class="page-header-icon">
                                <i class="fas fa-icon-name"></i>
                            </div>
                            <div>
                                <h3 class="page-header-title">Judul Halaman</h3>
                                <p class="page-header-subtitle">Deskripsi halaman</p>
                            </div>
                        </div>
                        <div class="text-right d-none d-md-block">
                            <a href="{{ route('route.create') }}" class="btn btn-light btn-modern">
                                <i class="fas fa-plus"></i> Tambah Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats (Optional) --}}
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stats-card gradient-blue">
                <div class="stats-icon">
                    <i class="fas fa-icon"></i>
                </div>
                <div class="stats-content">
                    <h3>{{ $total }}</h3>
                    <p>Label Stats</p>
                </div>
            </div>
        </div>
        <!-- Tambahkan stats card lainnya -->
    </div>

    {{-- Filter (Optional) --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="filter-box">
                <form method="GET">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cari</label>
                                <div class="search-box-modern">
                                    <i class="fas fa-search"></i>
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari..." value="{{ request('search') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary-modern btn-block">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="row">
        <div class="col-12">
            <div class="content-card">
                <div class="content-card-header">
                    <h5 class="content-card-title mb-0">
                        <i class="fas fa-list"></i> Daftar Data
                    </h5>
                </div>
                <div class="content-card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kolom 1</th>
                                    <th>Kolom 2</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $index => $item)
                                <tr>
                                    <td>{{ $data->firstItem() + $index }}</td>
                                    <td>{{ $item->field1 }}</td>
                                    <td>{{ $item->field2 }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('route.show', $item) }}" 
                                               class="btn btn-sm btn-info-modern">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('route.edit', $item) }}" 
                                               class="btn btn-sm btn-warning-modern">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger-modern btn-delete" 
                                                    data-id="{{ $item->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <i class="fas fa-inbox"></i>
                                            <h5>Tidak Ada Data</h5>
                                            <p>Belum ada data yang tersedia</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($data->hasPages())
                <div class="content-card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Menampilkan {{ $data->firstItem() }}–{{ $data->lastItem() }} dari {{ $data->total() }} data
                        </small>
                        {{ $data->links('pagination::bootstrap-4') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
```

## 2. Template Create/Edit Form

```blade
@extends('layouts.app')
@section('title', 'Form Data')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card page-header-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between text-white">
                        <div class="d-flex align-items-center">
                            <div class="page-header-icon">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div>
                                <h3 class="page-header-title">Form Data</h3>
                                <p class="page-header-subtitle">Tambah/Edit data</p>
                            </div>
                        </div>
                        <div class="text-right d-none d-md-block">
                            <a href="{{ route('route.index') }}" class="btn btn-light btn-modern">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('route.store') }}" method="POST" class="form-modern">
        @csrf
        
        <div class="row">
            <div class="col-lg-8">
                <div class="content-card">
                    <div class="content-card-header">
                        <h5 class="content-card-title mb-0">
                            <i class="fas fa-info-circle"></i> Informasi Data
                        </h5>
                    </div>
                    <div class="content-card-body">
                        <div class="form-group">
                            <label>Field 1 <span class="text-danger">*</span></label>
                            <input type="text" name="field1" 
                                   class="form-control @error('field1') is-invalid @enderror"
                                   placeholder="Masukkan field 1" 
                                   value="{{ old('field1') }}" required>
                            @error('field1')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Field 2</label>
                            <textarea name="field2" 
                                      class="form-control @error('field2') is-invalid @enderror"
                                      placeholder="Masukkan field 2">{{ old('field2') }}</textarea>
                            @error('field2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="content-card">
                    <div class="content-card-header">
                        <h5 class="content-card-title mb-0">
                            <i class="fas fa-cog"></i> Pengaturan
                        </h5>
                    </div>
                    <div class="content-card-body">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="aktif">Aktif</option>
                                <option value="tidak_aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="content-card">
                    <div class="content-card-body">
                        <button type="submit" class="btn btn-success-modern btn-block">
                            <i class="fas fa-save"></i> Simpan Data
                        </button>
                        <a href="{{ route('route.index') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
```

## 3. Template Detail/Show Page

```blade
@extends('layouts.app')
@section('title', 'Detail Data')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card page-header-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between text-white">
                        <div class="d-flex align-items-center">
                            <div class="page-header-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div>
                                <h3 class="page-header-title">Detail Data</h3>
                                <p class="page-header-subtitle">Informasi lengkap data</p>
                            </div>
                        </div>
                        <div class="text-right d-none d-md-block">
                            <a href="{{ route('route.edit', $data) }}" class="btn btn-warning btn-modern">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('route.index') }}" class="btn btn-light btn-modern ml-2">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="content-card">
                <div class="content-card-header">
                    <h5 class="content-card-title mb-0">
                        <i class="fas fa-info-circle"></i> Informasi Data
                    </h5>
                </div>
                <div class="content-card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%" class="font-weight-bold">Field 1</td>
                            <td>: {{ $data->field1 }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Field 2</td>
                            <td>: {{ $data->field2 }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Status</td>
                            <td>: 
                                @if($data->status === 'aktif')
                                    <span class="status-badge status-active">
                                        <i class="fas fa-check"></i> Aktif
                                    </span>
                                @else
                                    <span class="status-badge status-inactive">
                                        <i class="fas fa-times"></i> Tidak Aktif
                                    </span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="content-card">
                <div class="content-card-header">
                    <h5 class="content-card-title mb-0">
                        <i class="fas fa-clock"></i> Informasi Waktu
                    </h5>
                </div>
                <div class="content-card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Dibuat</small>
                        <strong>{{ $data->created_at->format('d M Y, H:i') }}</strong>
                    </div>
                    <div>
                        <small class="text-muted d-block">Diupdate</small>
                        <strong>{{ $data->updated_at->format('d M Y, H:i') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

## 🎨 Komponen yang Tersedia

### Icons Font Awesome
- `fa-store` - Toko/Koperasi
- `fa-users` - Anggota/User
- `fa-hand-holding-usd` - Bantuan
- `fa-calendar-alt` - Jadwal
- `fa-comments` - Chat
- `fa-newspaper` - Berita
- `fa-images` - Galeri
- `fa-chart-bar` - Laporan
- `fa-cog` - Pengaturan

### Gradient Classes
- `gradient-blue` - Biru
- `gradient-orange` - Orange
- `gradient-green` - Hijau
- `gradient-purple` - Ungu
- `gradient-pink` - Pink
- `gradient-cyan` - Cyan
- `gradient-teal` - Teal
- `gradient-red` - Merah

### Button Classes
- `btn-primary-modern` - Biru
- `btn-success-modern` - Hijau
- `btn-warning-modern` - Orange
- `btn-danger-modern` - Merah
- `btn-info-modern` - Cyan

---

**Gunakan template ini untuk membuat halaman admin yang konsisten!**

# 📘 Panduan Style Admin DISPERINDAGKOP Tolikara

Panduan lengkap untuk membuat halaman admin yang konsisten, rapi, dan menarik.

## 🎨 File CSS Custom

File CSS custom sudah dibuat di: `public/css/admin-style.css`

File ini sudah otomatis di-include di `resources/views/layouts/app.blade.php`

## 📋 Struktur Halaman Standard

### 1. Header Halaman dengan Gradient Biru

```blade
<div class="container-fluid">
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card page-header-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between text-white">
                        <div class="d-flex align-items-center">
                            <div class="page-header-icon">
                                <i class="fas fa-store"></i>
                            </div>
                            <div>
                                <h3 class="page-header-title">Data Koperasi</h3>
                                <p class="page-header-subtitle">Kelola data koperasi di Kabupaten Tolikara</p>
                            </div>
                        </div>
                        <div class="text-right d-none d-md-block">
                            <a href="{{ route('admin.koperasi.create') }}" class="btn btn-light btn-modern">
                                <i class="fas fa-plus"></i> Tambah Koperasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
```

### 2. Stats Cards dengan Gradient

```blade
{{-- Stats --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stats-card gradient-blue">
            <div class="stats-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="stats-content">
                <h3>{{ $totalKoperasi }}</h3>
                <p>Total Koperasi</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card gradient-orange">
            <div class="stats-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stats-content">
                <h3>{{ $pending }}</h3>
                <p>Menunggu Verifikasi</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card gradient-green">
            <div class="stats-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stats-content">
                <h3>{{ $verified }}</h3>
                <p>Terverifikasi</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card gradient-red">
            <div class="stats-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stats-content">
                <h3>{{ $rejected }}</h3>
                <p>Ditolak</p>
            </div>
        </div>
    </div>
</div>
```

### 3. Filter Box

```blade
{{-- Filter --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="filter-box">
            <form method="GET" action="{{ route('admin.koperasi.index') }}">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Cari</label>
                            <div class="search-box-modern">
                                <i class="fas fa-search"></i>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Nama koperasi..." value="{{ request('search') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Status Verifikasi</label>
                            <select name="status_verifikasi" class="form-control">
                                <option value="">Semua</option>
                                <option value="pending">Pending</option>
                                <option value="diverifikasi">Terverifikasi</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Distrik</label>
                            <select name="distrik" class="form-control">
                                <option value="">Semua Distrik</option>
                                @foreach($distrik as $d)
                                    <option value="{{ $d }}">{{ $d }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary-modern btn-block">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <a href="{{ route('admin.koperasi.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
```

### 4. Content Card dengan Table

```blade
{{-- Data Table --}}
<div class="row">
    <div class="col-12">
        <div class="content-card">
            <div class="content-card-header">
                <h5 class="content-card-title">
                    <i class="fas fa-list"></i> Daftar Koperasi
                </h5>
            </div>
            <div class="content-card-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Usaha</th>
                                <th>Pemilik</th>
                                <th>Distrik</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($koperasi as $index => $kop)
                            <tr>
                                <td>{{ $koperasi->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $kop->nama_usaha }}</strong><br>
                                    <small class="text-muted">{{ $kop->no_registrasi }}</small>
                                </td>
                                <td>{{ $kop->nama_pemilik }}</td>
                                <td>{{ $kop->distrik }}</td>
                                <td>
                                    @if($kop->status_verifikasi === 'diverifikasi')
                                        <span class="status-badge status-active">
                                            <i class="fas fa-check-circle"></i> Terverifikasi
                                        </span>
                                    @elseif($kop->status_verifikasi === 'pending')
                                        <span class="status-badge status-pending">
                                            <i class="fas fa-clock"></i> Pending
                                        </span>
                                    @else
                                        <span class="status-badge status-inactive">
                                            <i class="fas fa-times-circle"></i> Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.koperasi.show', $kop) }}" 
                                           class="btn btn-sm btn-info-modern" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.koperasi.edit', $kop) }}" 
                                           class="btn btn-sm btn-warning-modern" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger-modern" 
                                                onclick="confirmDelete({{ $kop->id }})" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <h5>Tidak Ada Data</h5>
                                        <p>Belum ada data koperasi yang tersedia</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Pagination --}}
@if($koperasi->hasPages())
<div class="row mt-3">
    <div class="col-12">
        <div class="d-flex justify-content-center">
            {{ $koperasi->links('pagination::bootstrap-4', ['class' => 'pagination-modern']) }}
        </div>
    </div>
</div>
@endif
```

### 5. Form Modern

```blade
<div class="content-card">
    <div class="content-card-header">
        <h5 class="content-card-title">
            <i class="fas fa-edit"></i> Form Data Koperasi
        </h5>
    </div>
    <div class="content-card-body">
        <form method="POST" action="{{ route('admin.koperasi.store') }}" class="form-modern">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Usaha <span class="text-danger">*</span></label>
                        <input type="text" name="nama_usaha" class="form-control @error('nama_usaha') is-invalid @enderror" 
                               placeholder="Masukkan nama usaha" value="{{ old('nama_usaha') }}" required>
                        @error('nama_usaha')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Pemilik <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pemilik" class="form-control @error('nama_pemilik') is-invalid @enderror" 
                               placeholder="Masukkan nama pemilik" value="{{ old('nama_pemilik') }}" required>
                        @error('nama_pemilik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                                  placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-success-modern">
                            <i class="fas fa-save"></i> Simpan Data
                        </button>
                        <a href="{{ route('admin.koperasi.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
```

### 6. Alert Modern

```blade
@if(session('success'))
<div class="alert alert-success-modern alert-dismissible fade show">
    <i class="fas fa-check-circle"></i>
    <span>{{ session('success') }}</span>
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger-modern alert-dismissible fade show">
    <i class="fas fa-exclamation-circle"></i>
    <span>{{ session('error') }}</span>
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
@endif
```

## 🎨 Gradient Colors Available

- `gradient-blue` - Biru (#3b82f6 → #2563eb)
- `gradient-orange` - Orange (#f59e0b → #d97706)
- `gradient-green` - Hijau (#10b981 → #059669)
- `gradient-purple` - Ungu (#667eea → #764ba2)
- `gradient-pink` - Pink (#f093fb → #f5576c)
- `gradient-cyan` - Cyan (#4facfe → #00f2fe)
- `gradient-teal` - Teal (#43e97b → #38f9d7)
- `gradient-red` - Merah (#ef4444 → #dc2626)

## 🔘 Button Classes

- `btn-primary-modern` - Button biru
- `btn-success-modern` - Button hijau
- `btn-warning-modern` - Button orange
- `btn-danger-modern` - Button merah
- `btn-info-modern` - Button cyan

## 📦 Badge Classes

- `badge-blue` - Badge biru
- `badge-orange` - Badge orange
- `badge-green` - Badge hijau
- `badge-red` - Badge merah
- `badge-purple` - Badge ungu

## ✅ Status Badge Classes

- `status-active` - Status aktif (hijau)
- `status-pending` - Status pending (kuning)
- `status-inactive` - Status tidak aktif (merah)

## 📝 Tips Penggunaan

1. **Selalu gunakan `page-header-card`** di awal setiap halaman
2. **Gunakan `stats-card`** untuk menampilkan statistik
3. **Gunakan `content-card`** untuk konten utama
4. **Gunakan `table-modern`** untuk tabel data
5. **Gunakan `form-modern`** untuk form input
6. **Gunakan `empty-state`** ketika tidak ada data
7. **Gunakan `action-buttons`** untuk group tombol aksi

## 🚀 Contoh Lengkap

Lihat file `resources/views/admin/dashboard/index.blade.php` untuk contoh implementasi lengkap.

---

**Dibuat untuk DISPERINDAGKOP Kabupaten Tolikara**

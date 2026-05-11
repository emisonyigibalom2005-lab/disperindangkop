# 🔐 Cara Implementasi Permission System

## 📋 Deskripsi
Sistem permission ini memastikan setiap role hanya bisa mengakses fitur sesuai izin yang diberikan Admin melalui halaman **Izin Akses**. Jika belum ada izin, user tidak bisa mengakses fitur tersebut.

---

## 🎯 Komponen yang Sudah Dibuat

### 1. **Middleware: CheckPermission**
- File: `app/Http/Middleware/CheckPermission.php`
- Fungsi: Cek izin sebelum akses route
- Admin selalu punya full access

### 2. **Helper Functions**
- File: `app/Helpers/PermissionHelper.php`
- Functions:
  - `can_access($module, $action)` - Cek izin umum
  - `can_view($module)` - Cek izin view
  - `can_create($module)` - Cek izin create
  - `can_edit($module)` - Cek izin edit
  - `can_delete($module)` - Cek izin delete
  - `can_export($module)` - Cek izin export
  - `can_approve($module)` - Cek izin approve
  - `get_user_permissions()` - Get semua izin user

### 3. **Blade Directives**
- `@canAccess('module', 'action')` - Cek izin umum
- `@canView('module')` - Cek izin view
- `@canCreate('module')` - Cek izin create
- `@canEdit('module')` - Cek izin edit
- `@canDelete('module')` - Cek izin delete
- `@canExport('module')` - Cek izin export
- `@canApprove('module')` - Cek izin approve

---

## 🔧 Cara Menggunakan

### A. Proteksi Route dengan Middleware

#### 1. **Single Permission Check**
```php
// Cek izin view
Route::get('/koperasi', [KoperasiController::class, 'index'])
    ->middleware(['auth', 'permission:koperasi,view']);

// Cek izin create
Route::get('/koperasi/create', [KoperasiController::class, 'create'])
    ->middleware(['auth', 'permission:koperasi,create']);

// Cek izin edit
Route::put('/koperasi/{id}', [KoperasiController::class, 'update'])
    ->middleware(['auth', 'permission:koperasi,edit']);

// Cek izin delete
Route::delete('/koperasi/{id}', [KoperasiController::class, 'destroy'])
    ->middleware(['auth', 'permission:koperasi,delete']);
```

#### 2. **Group Routes dengan Permission**
```php
Route::middleware(['auth', 'role:petugas'])->group(function () {
    // Semua route koperasi butuh izin view
    Route::middleware('permission:koperasi,view')->group(function () {
        Route::get('/koperasi', [KoperasiController::class, 'index']);
        Route::get('/koperasi/{id}', [KoperasiController::class, 'show']);
    });
    
    // Route create butuh izin create
    Route::middleware('permission:koperasi,create')->group(function () {
        Route::get('/koperasi/create', [KoperasiController::class, 'create']);
        Route::post('/koperasi', [KoperasiController::class, 'store']);
    });
    
    // Route edit butuh izin edit
    Route::middleware('permission:koperasi,edit')->group(function () {
        Route::get('/koperasi/{id}/edit', [KoperasiController::class, 'edit']);
        Route::put('/koperasi/{id}', [KoperasiController::class, 'update']);
    });
});
```

---

### B. Cek Permission di Controller

#### 1. **Di Method Controller**
```php
public function index()
{
    // Cek izin view
    if (!can_view('koperasi')) {
        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk melihat data koperasi');
    }
    
    $koperasi = Koperasi::all();
    return view('koperasi.index', compact('koperasi'));
}

public function create()
{
    // Cek izin create
    if (!can_create('koperasi')) {
        abort(403, 'Tidak ada izin untuk membuat koperasi baru');
    }
    
    return view('koperasi.create');
}

public function destroy($id)
{
    // Cek izin delete
    if (!can_delete('koperasi')) {
        return response()->json(['error' => 'Tidak ada izin hapus'], 403);
    }
    
    Koperasi::findOrFail($id)->delete();
    return redirect()->back()->with('success', 'Data berhasil dihapus');
}
```

#### 2. **Dengan Helper can_access**
```php
public function verifikasi($id)
{
    // Cek izin approve
    if (!can_access('koperasi', 'approve')) {
        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk verifikasi koperasi');
    }
    
    $koperasi = Koperasi::findOrFail($id);
    $koperasi->update(['status' => 'verified']);
    
    return redirect()->back()->with('success', 'Koperasi berhasil diverifikasi');
}

public function export()
{
    // Cek izin export
    if (!can_export('koperasi')) {
        abort(403, 'Tidak ada izin untuk export data');
    }
    
    return Excel::download(new KoperasiExport, 'koperasi.xlsx');
}
```

---

### C. Cek Permission di Blade View

#### 1. **Sembunyikan Tombol Berdasarkan Permission**
```blade
{{-- Tombol Tambah (Create) --}}
@canCreate('koperasi')
    <a href="{{ route('koperasi.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Koperasi
    </a>
@endcanCreate

{{-- Tombol Edit --}}
@canEdit('koperasi')
    <a href="{{ route('koperasi.edit', $koperasi->id) }}" class="btn btn-warning">
        <i class="fas fa-edit"></i> Edit
    </a>
@endcanEdit

{{-- Tombol Hapus --}}
@canDelete('koperasi')
    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $koperasi->id }})">
        <i class="fas fa-trash"></i> Hapus
    </button>
@endcanDelete

{{-- Tombol Export --}}
@canExport('koperasi')
    <a href="{{ route('koperasi.export') }}" class="btn btn-success">
        <i class="fas fa-download"></i> Export Excel
    </a>
@endcanExport

{{-- Tombol Verifikasi/Approve --}}
@canApprove('koperasi')
    <button type="button" class="btn btn-info" onclick="verifikasi({{ $koperasi->id }})">
        <i class="fas fa-check-circle"></i> Verifikasi
    </button>
@endcanApprove
```

#### 2. **Sembunyikan Menu Sidebar**
```blade
{{-- Menu Koperasi --}}
@canView('koperasi')
    <li class="nav-item">
        <a href="{{ route('koperasi.index') }}" class="nav-link">
            <i class="nav-icon fas fa-store"></i>
            <p>Manajemen Koperasi</p>
        </a>
    </li>
@endcanView

{{-- Menu Anggota --}}
@canView('anggota')
    <li class="nav-item">
        <a href="{{ route('anggota.index') }}" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Manajemen Anggota</p>
        </a>
    </li>
@endcanView

{{-- Menu Laporan --}}
@canView('laporan')
    <li class="nav-item">
        <a href="{{ route('laporan.index') }}" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>Laporan</p>
        </a>
    </li>
@endcanView
```

#### 3. **Sembunyikan Section/Card**
```blade
{{-- Card Statistik Koperasi --}}
@canView('koperasi')
    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-store"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Koperasi</span>
                <span class="info-box-number">{{ $totalKoperasi }}</span>
            </div>
        </div>
    </div>
@endcanView

{{-- Tabel Data --}}
@canView('anggota')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Anggota</h3>
        </div>
        <div class="card-body">
            <table class="table">
                {{-- Table content --}}
            </table>
        </div>
    </div>
@endcanView
```

#### 4. **Kombinasi Multiple Permissions**
```blade
{{-- Tampilkan jika bisa view ATAU edit --}}
@if(can_view('koperasi') || can_edit('koperasi'))
    <div class="card">
        {{-- Content --}}
    </div>
@endif

{{-- Tampilkan jika bisa view DAN edit --}}
@if(can_view('koperasi') && can_edit('koperasi'))
    <div class="action-buttons">
        {{-- Buttons --}}
    </div>
@endif

{{-- Nested permissions --}}
@canView('koperasi')
    <div class="koperasi-list">
        @foreach($koperasi as $item)
            <div class="item">
                <h4>{{ $item->nama }}</h4>
                
                @canEdit('koperasi')
                    <a href="{{ route('koperasi.edit', $item->id) }}">Edit</a>
                @endcanEdit
                
                @canDelete('koperasi')
                    <button onclick="delete({{ $item->id }})">Hapus</button>
                @endcanDelete
            </div>
        @endforeach
    </div>
@endcanView
```

---

### D. Cek Permission di JavaScript

#### 1. **Pass Permission ke JavaScript**
```blade
<script>
    const permissions = {
        canView: {{ can_view('koperasi') ? 'true' : 'false' }},
        canCreate: {{ can_create('koperasi') ? 'true' : 'false' }},
        canEdit: {{ can_edit('koperasi') ? 'true' : 'false' }},
        canDelete: {{ can_delete('koperasi') ? 'true' : 'false' }},
        canExport: {{ can_export('koperasi') ? 'true' : 'false' }},
    };

    function confirmDelete(id) {
        if (!permissions.canDelete) {
            alert('Anda tidak memiliki izin untuk menghapus data');
            return;
        }
        
        // Lanjutkan proses delete
        Swal.fire({
            title: 'Hapus Data?',
            text: 'Data akan dihapus permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit delete form
            }
        });
    }
</script>
```

---

## 📝 Daftar Module Names

Gunakan nama module ini saat implementasi permission:

| Module Name | Keterangan |
|-------------|------------|
| `koperasi` | Manajemen Koperasi |
| `anggota` | Manajemen Anggota |
| `bantuan` | Distribusi Bantuan |
| `berita` | Berita & Artikel |
| `pengumuman` | Pengumuman |
| `galeri` | Galeri Kegiatan |
| `jadwal` | Jadwal Kegiatan |
| `pelatihan` | Pelatihan |
| `laporan` | Laporan |
| `user` | Manajemen User |
| `setting` | Pengaturan Sistem |
| `chat` | Chat & Pesan |
| `kontak` | Kontak Masuk |
| `struktur` | Struktur Organisasi |
| `halaman_statis` | Halaman Statis |

---

## 🎯 Contoh Implementasi Lengkap

### Contoh 1: Halaman Index Koperasi
```blade
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="row mb-3">
        <div class="col-12">
            <h1>Manajemen Koperasi</h1>
            
            {{-- Tombol Tambah hanya muncul jika ada izin create --}}
            @canCreate('koperasi')
                <a href="{{ route('koperasi.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Koperasi
                </a>
            @endcanCreate
            
            {{-- Tombol Export hanya muncul jika ada izin export --}}
            @canExport('koperasi')
                <a href="{{ route('koperasi.export') }}" class="btn btn-success">
                    <i class="fas fa-download"></i> Export Excel
                </a>
            @endcanExport
        </div>
    </div>

    {{-- Tabel Data --}}
    @canView('koperasi')
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Koperasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($koperasi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->status }}</td>
                            <td>
                                {{-- Tombol Detail selalu muncul jika bisa view --}}
                                <a href="{{ route('koperasi.show', $item->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                {{-- Tombol Edit hanya muncul jika ada izin edit --}}
                                @canEdit('koperasi')
                                    <a href="{{ route('koperasi.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcanEdit
                                
                                {{-- Tombol Hapus hanya muncul jika ada izin delete --}}
                                @canDelete('koperasi')
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endcanDelete
                                
                                {{-- Tombol Verifikasi hanya muncul jika ada izin approve --}}
                                @canApprove('koperasi')
                                    @if($item->status == 'pending')
                                        <button class="btn btn-sm btn-success" onclick="verifikasi({{ $item->id }})">
                                            <i class="fas fa-check"></i> Verifikasi
                                        </button>
                                    @endif
                                @endcanApprove
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        {{-- Pesan jika tidak ada izin view --}}
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            Anda tidak memiliki izin untuk melihat data koperasi. Hubungi Administrator.
        </div>
    @endcanView
</div>
@endsection
```

### Contoh 2: Controller dengan Permission Check
```php
<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Koperasi;
use Illuminate\Http\Request;

class KoperasiController extends Controller
{
    public function index()
    {
        // Cek izin view
        if (!can_view('koperasi')) {
            return redirect()->route('petugas.dashboard')
                ->with('error', 'Anda tidak memiliki izin untuk melihat data koperasi');
        }

        $koperasi = Koperasi::paginate(10);
        return view('petugas.koperasi.index', compact('koperasi'));
    }

    public function create()
    {
        // Cek izin create
        if (!can_create('koperasi')) {
            abort(403, 'Tidak ada izin untuk membuat koperasi baru');
        }

        return view('petugas.koperasi.create');
    }

    public function store(Request $request)
    {
        // Cek izin create
        if (!can_create('koperasi')) {
            return redirect()->back()
                ->with('error', 'Tidak ada izin untuk membuat koperasi');
        }

        // Validasi dan simpan data
        $validated = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
        ]);

        Koperasi::create($validated);

        return redirect()->route('petugas.koperasi.index')
            ->with('success', 'Koperasi berhasil ditambahkan');
    }

    public function edit($id)
    {
        // Cek izin edit
        if (!can_edit('koperasi')) {
            abort(403, 'Tidak ada izin untuk mengedit koperasi');
        }

        $koperasi = Koperasi::findOrFail($id);
        return view('petugas.koperasi.edit', compact('koperasi'));
    }

    public function update(Request $request, $id)
    {
        // Cek izin edit
        if (!can_edit('koperasi')) {
            return redirect()->back()
                ->with('error', 'Tidak ada izin untuk mengedit koperasi');
        }

        $koperasi = Koperasi::findOrFail($id);
        $koperasi->update($request->all());

        return redirect()->route('petugas.koperasi.index')
            ->with('success', 'Koperasi berhasil diupdate');
    }

    public function destroy($id)
    {
        // Cek izin delete
        if (!can_delete('koperasi')) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada izin untuk menghapus koperasi'
            ], 403);
        }

        Koperasi::findOrFail($id)->delete();

        return redirect()->route('petugas.koperasi.index')
            ->with('success', 'Koperasi berhasil dihapus');
    }

    public function verifikasi($id)
    {
        // Cek izin approve
        if (!can_approve('koperasi')) {
            return redirect()->back()
                ->with('error', 'Tidak ada izin untuk verifikasi koperasi');
        }

        $koperasi = Koperasi::findOrFail($id);
        $koperasi->update(['status' => 'verified']);

        return redirect()->back()
            ->with('success', 'Koperasi berhasil diverifikasi');
    }

    public function export()
    {
        // Cek izin export
        if (!can_export('koperasi')) {
            abort(403, 'Tidak ada izin untuk export data');
        }

        return Excel::download(new KoperasiExport, 'koperasi.xlsx');
    }
}
```

---

## ⚠️ Catatan Penting

1. **Admin Selalu Full Access**
   - Role admin tidak perlu dicek permission
   - Admin otomatis punya semua izin

2. **Default Behavior**
   - Jika belum ada permission di database, user tidak bisa akses
   - Admin harus set permission dulu di halaman Izin Akses

3. **Middleware vs Helper**
   - Middleware: Proteksi di level route (lebih aman)
   - Helper: Cek di controller/view (lebih fleksibel)
   - Gunakan keduanya untuk keamanan maksimal

4. **Performance**
   - Permission dicache per request
   - Tidak perlu khawatir query berulang

5. **Testing**
   - Selalu test dengan login sebagai role yang berbeda
   - Pastikan tombol/menu tersembunyi jika tidak ada izin
   - Test juga akses langsung via URL

---

## 🚀 Langkah Implementasi

1. **Set Permission di Admin**
   - Login sebagai Admin
   - Buka menu Izin Akses
   - Atur permission untuk setiap role

2. **Proteksi Route**
   - Tambahkan middleware `permission:module,action` di routes

3. **Cek di Controller**
   - Gunakan helper `can_*()` di awal method

4. **Sembunyikan UI**
   - Gunakan `@can*` directive di Blade

5. **Test**
   - Login sebagai role yang berbeda
   - Coba akses fitur yang tidak ada izinnya
   - Pastikan redirect dengan pesan error

---

**Dibuat:** 17 April 2026  
**Versi:** 1.0  
**Status:** ✅ Siap Digunakan

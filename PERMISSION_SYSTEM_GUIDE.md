# 🛡️ Panduan Sistem Izin Akses (Permission System)

## 📋 Daftar Isi
1. [Pengenalan](#pengenalan)
2. [Cara Menggunakan](#cara-menggunakan)
3. [Mengelola Izin di Admin Panel](#mengelola-izin-di-admin-panel)
4. [Implementasi di Controller](#implementasi-di-controller)
5. [Implementasi di View (Blade)](#implementasi-di-view-blade)
6. [Helper Functions](#helper-functions)
7. [Middleware](#middleware)
8. [Role dan Module](#role-dan-module)

---

## 🎯 Pengenalan

Sistem Izin Akses memungkinkan **Administrator** untuk mengontrol akses setiap role pengguna (Petugas, Pimpinan, Anggota Koperasi) terhadap fitur-fitur sistem. Setiap role dapat diberikan izin untuk:

- ✅ **View (Lihat)** - Melihat dan membaca data
- ✅ **Create (Tambah)** - Menambahkan data baru
- ✅ **Edit (Ubah)** - Mengubah data yang ada
- ✅ **Delete (Hapus)** - Menghapus data
- ✅ **Export (Ekspor)** - Mengekspor data ke Excel/PDF
- ✅ **Approve (Setujui)** - Menyetujui/verifikasi data

---

## 🚀 Cara Menggunakan

### 1. Mengelola Izin di Admin Panel

#### Langkah 1: Akses Menu Izin Akses
1. Login sebagai **Administrator**
2. Buka menu **Sistem** → **Izin Akses**
3. Anda akan melihat daftar semua role dengan ringkasan izin mereka

#### Langkah 2: Kelola Izin untuk Role Tertentu
1. Klik tombol **"Kelola Izin"** pada role yang ingin diatur
2. Anda akan melihat daftar semua modul sistem
3. Untuk setiap modul, centang izin yang ingin diberikan:
   - ☑️ Lihat
   - ☑️ Tambah
   - ☑️ Ubah
   - ☑️ Hapus
   - ☑️ Ekspor
   - ☑️ Setujui

#### Langkah 3: Simpan Perubahan
1. Klik tombol **"Simpan Perubahan"**
2. Izin akan langsung diterapkan untuk semua user dengan role tersebut

#### Fitur Tambahan:
- **Set Default**: Mengembalikan izin ke pengaturan default
- **Pilih Semua Izin**: Memberikan semua izin untuk semua modul
- **Hapus Semua Pilihan**: Menghapus semua izin yang dipilih
- **Reset**: Menghapus semua izin untuk role tersebut

---

## 💻 Implementasi di Controller

### Menggunakan Middleware

Tambahkan middleware `permission` pada route atau constructor controller:

```php
// Di routes/web.php
Route::middleware(['auth', 'permission:anggota,view'])->group(function () {
    Route::get('/anggota', [AnggotaController::class, 'index']);
});

Route::middleware(['auth', 'permission:anggota,create'])->group(function () {
    Route::get('/anggota/create', [AnggotaController::class, 'create']);
    Route::post('/anggota', [AnggotaController::class, 'store']);
});

Route::middleware(['auth', 'permission:anggota,edit'])->group(function () {
    Route::get('/anggota/{id}/edit', [AnggotaController::class, 'edit']);
    Route::put('/anggota/{id}', [AnggotaController::class, 'update']);
});

Route::middleware(['auth', 'permission:anggota,delete'])->group(function () {
    Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy']);
});
```

### Menggunakan Helper Function di Controller

```php
<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        // Cek izin view
        if (!can_view('anggota')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk melihat data anggota.');
        }
        
        $anggota = Anggota::all();
        return view('petugas.anggota.index', compact('anggota'));
    }
    
    public function create()
    {
        // Cek izin create
        if (!can_create('anggota')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menambah anggota.');
        }
        
        return view('petugas.anggota.create');
    }
    
    public function store(Request $request)
    {
        // Cek izin create
        if (!can_create('anggota')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menambah anggota.');
        }
        
        // Proses penyimpanan data
        // ...
    }
    
    public function edit($id)
    {
        // Cek izin edit
        if (!can_edit('anggota')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengubah data anggota.');
        }
        
        $anggota = Anggota::findOrFail($id);
        return view('petugas.anggota.edit', compact('anggota'));
    }
    
    public function update(Request $request, $id)
    {
        // Cek izin edit
        if (!can_edit('anggota')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengubah data anggota.');
        }
        
        // Proses update data
        // ...
    }
    
    public function destroy($id)
    {
        // Cek izin delete
        if (!can_delete('anggota')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus anggota.');
        }
        
        // Proses hapus data
        // ...
    }
    
    public function export()
    {
        // Cek izin export
        if (!can_export('anggota')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengekspor data anggota.');
        }
        
        // Proses export
        // ...
    }
}
```

---

## 🎨 Implementasi di View (Blade)

### Menyembunyikan Tombol Berdasarkan Izin

```blade
{{-- Tombol Tambah --}}
@if(can_create('anggota'))
<a href="{{ route('petugas.anggota.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Tambah Anggota
</a>
@endif

{{-- Tombol Edit --}}
@if(can_edit('anggota'))
<a href="{{ route('petugas.anggota.edit', $anggota->id) }}" class="btn btn-warning">
    <i class="fas fa-edit"></i> Edit
</a>
@endif

{{-- Tombol Hapus --}}
@if(can_delete('anggota'))
<form action="{{ route('petugas.anggota.destroy', $anggota->id) }}" method="POST" style="display:inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
        <i class="fas fa-trash"></i> Hapus
    </button>
</form>
@endif

{{-- Tombol Export --}}
@if(can_export('anggota'))
<button type="button" class="btn btn-success" onclick="exportData()">
    <i class="fas fa-file-excel"></i> Export Excel
</button>
@endif

{{-- Tombol Approve --}}
@if(can_approve('anggota'))
<button type="button" class="btn btn-info" onclick="approveData({{ $anggota->id }})">
    <i class="fas fa-check-circle"></i> Setujui
</button>
@endif
```

### Menyembunyikan Menu Berdasarkan Izin

```blade
{{-- Di sidebar --}}
@if(can_view('anggota'))
<li class="nav-item">
    <a href="{{ route('petugas.anggota.index') }}" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>Data Anggota</p>
    </a>
</li>
@endif

@if(can_view('koperasi'))
<li class="nav-item">
    <a href="{{ route('petugas.koperasi.index') }}" class="nav-link">
        <i class="nav-icon fas fa-store"></i>
        <p>Data Koperasi</p>
    </a>
</li>
@endif
```

### Menampilkan Pesan Jika Tidak Ada Izin

```blade
@if(!can_view('anggota'))
<div class="alert alert-warning">
    <i class="fas fa-exclamation-triangle"></i>
    Anda tidak memiliki izin untuk melihat data anggota. Hubungi Administrator untuk mendapatkan akses.
</div>
@else
    {{-- Tampilkan data anggota --}}
    <table class="table">
        {{-- ... --}}
    </table>
@endif
```

---

## 🔧 Helper Functions

Sistem menyediakan helper functions yang dapat digunakan di mana saja:

### 1. `can_access($module, $action)`
Cek apakah user memiliki izin untuk aksi tertentu pada modul.

```php
if (can_access('anggota', 'view')) {
    // User dapat melihat data anggota
}
```

### 2. `can_view($module)`
Cek izin untuk melihat data.

```php
if (can_view('anggota')) {
    // User dapat melihat data anggota
}
```

### 3. `can_create($module)`
Cek izin untuk menambah data.

```php
if (can_create('anggota')) {
    // User dapat menambah anggota
}
```

### 4. `can_edit($module)`
Cek izin untuk mengubah data.

```php
if (can_edit('anggota')) {
    // User dapat mengubah data anggota
}
```

### 5. `can_delete($module)`
Cek izin untuk menghapus data.

```php
if (can_delete('anggota')) {
    // User dapat menghapus anggota
}
```

### 6. `can_export($module)`
Cek izin untuk mengekspor data.

```php
if (can_export('anggota')) {
    // User dapat mengekspor data anggota
}
```

### 7. `can_approve($module)`
Cek izin untuk menyetujui data.

```php
if (can_approve('anggota')) {
    // User dapat menyetujui anggota
}
```

### 8. `get_user_permissions()`
Mendapatkan semua izin user saat ini.

```php
$permissions = get_user_permissions();
foreach ($permissions as $module => $perms) {
    echo "Module: $module\n";
    echo "Can View: " . ($perms['can_view'] ? 'Yes' : 'No') . "\n";
    echo "Can Create: " . ($perms['can_create'] ? 'Yes' : 'No') . "\n";
    // ...
}
```

---

## 🛡️ Middleware

### CheckPermission Middleware

Middleware ini otomatis memeriksa izin sebelum mengakses route.

#### Cara Menggunakan:

```php
// Format: permission:module,action
Route::middleware(['auth', 'permission:anggota,view'])->group(function () {
    // Routes yang memerlukan izin view untuk modul anggota
});

Route::middleware(['auth', 'permission:koperasi,create'])->group(function () {
    // Routes yang memerlukan izin create untuk modul koperasi
});

Route::middleware(['auth', 'permission:bantuan,edit'])->group(function () {
    // Routes yang memerlukan izin edit untuk modul bantuan
});

Route::middleware(['auth', 'permission:berita,delete'])->group(function () {
    // Routes yang memerlukan izin delete untuk modul berita
});
```

#### Catatan Penting:
- **Admin** selalu memiliki akses penuh ke semua fitur
- Jika user tidak memiliki izin, akan diredirect dengan pesan error
- Middleware harus ditambahkan setelah middleware `auth`

---

## 📊 Role dan Module

### Daftar Role:
1. **admin** - Administrator (Full Access)
2. **petugas** - Petugas Dinas
3. **pimpinan** - Pimpinan/Kepala Dinas
4. **koperasi** - Pengelola Koperasi
5. **anggota** - Anggota Koperasi

### Daftar Module:
1. **koperasi** - Manajemen Koperasi
2. **anggota** - Manajemen Anggota
3. **bantuan** - Distribusi Bantuan
4. **berita** - Berita & Artikel
5. **pengumuman** - Pengumuman
6. **galeri** - Galeri Kegiatan
7. **jadwal** - Jadwal Kegiatan
8. **pelatihan** - Pelatihan
9. **laporan** - Laporan
10. **user** - Manajemen User
11. **setting** - Pengaturan Sistem
12. **chat** - Chat & Pesan
13. **kontak** - Kontak Masuk
14. **struktur** - Struktur Organisasi
15. **halaman_statis** - Halaman Statis

---

## 🎯 Contoh Penggunaan Lengkap

### Contoh 1: Controller dengan Semua Izin

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
        if (!can_view('koperasi')) {
            abort(403, 'Tidak memiliki izin untuk melihat data koperasi');
        }
        
        $koperasi = Koperasi::all();
        return view('petugas.koperasi.index', compact('koperasi'));
    }
    
    public function create()
    {
        if (!can_create('koperasi')) {
            return redirect()->route('petugas.koperasi.index')
                ->with('error', 'Tidak memiliki izin untuk menambah koperasi');
        }
        
        return view('petugas.koperasi.create');
    }
    
    public function store(Request $request)
    {
        if (!can_create('koperasi')) {
            return redirect()->route('petugas.koperasi.index')
                ->with('error', 'Tidak memiliki izin untuk menambah koperasi');
        }
        
        // Validasi dan simpan data
        $validated = $request->validate([
            'nama_usaha' => 'required',
            // ...
        ]);
        
        Koperasi::create($validated);
        
        return redirect()->route('petugas.koperasi.index')
            ->with('success', 'Koperasi berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        if (!can_edit('koperasi')) {
            return redirect()->route('petugas.koperasi.index')
                ->with('error', 'Tidak memiliki izin untuk mengubah data koperasi');
        }
        
        $koperasi = Koperasi::findOrFail($id);
        return view('petugas.koperasi.edit', compact('koperasi'));
    }
    
    public function update(Request $request, $id)
    {
        if (!can_edit('koperasi')) {
            return redirect()->route('petugas.koperasi.index')
                ->with('error', 'Tidak memiliki izin untuk mengubah data koperasi');
        }
        
        $koperasi = Koperasi::findOrFail($id);
        
        // Validasi dan update data
        $validated = $request->validate([
            'nama_usaha' => 'required',
            // ...
        ]);
        
        $koperasi->update($validated);
        
        return redirect()->route('petugas.koperasi.index')
            ->with('success', 'Koperasi berhasil diperbarui');
    }
    
    public function destroy($id)
    {
        if (!can_delete('koperasi')) {
            return redirect()->route('petugas.koperasi.index')
                ->with('error', 'Tidak memiliki izin untuk menghapus koperasi');
        }
        
        $koperasi = Koperasi::findOrFail($id);
        $koperasi->delete();
        
        return redirect()->route('petugas.koperasi.index')
            ->with('success', 'Koperasi berhasil dihapus');
    }
    
    public function export()
    {
        if (!can_export('koperasi')) {
            return redirect()->route('petugas.koperasi.index')
                ->with('error', 'Tidak memiliki izin untuk mengekspor data koperasi');
        }
        
        // Proses export ke Excel
        // ...
    }
}
```

### Contoh 2: View dengan Semua Tombol Aksi

```blade
@extends('layouts.app')
@section('title', 'Data Koperasi')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h1>Data Koperasi</h1>
            
            {{-- Tombol Tambah hanya muncul jika ada izin create --}}
            @if(can_create('koperasi'))
            <a href="{{ route('petugas.koperasi.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Koperasi
            </a>
            @endif
            
            {{-- Tombol Export hanya muncul jika ada izin export --}}
            @if(can_export('koperasi'))
            <a href="{{ route('petugas.koperasi.export') }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            @endif
        </div>
    </div>
    
    @if(can_view('koperasi'))
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Koperasi</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($koperasi as $k)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $k->nama_usaha }}</td>
                        <td>{{ $k->alamat }}</td>
                        <td>{{ $k->status }}</td>
                        <td>
                            {{-- Tombol Detail --}}
                            <a href="{{ route('petugas.koperasi.show', $k->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            {{-- Tombol Edit hanya muncul jika ada izin edit --}}
                            @if(can_edit('koperasi'))
                            <a href="{{ route('petugas.koperasi.edit', $k->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endif
                            
                            {{-- Tombol Hapus hanya muncul jika ada izin delete --}}
                            @if(can_delete('koperasi'))
                            <form action="{{ route('petugas.koperasi.destroy', $k->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                            
                            {{-- Tombol Approve hanya muncul jika ada izin approve --}}
                            @if(can_approve('koperasi') && $k->status === 'Pending')
                            <button type="button" class="btn btn-sm btn-success" onclick="approve({{ $k->id }})">
                                <i class="fas fa-check-circle"></i> Setujui
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i>
        Anda tidak memiliki izin untuk melihat data koperasi. Hubungi Administrator untuk mendapatkan akses.
    </div>
    @endif
</div>
@endsection
```

---

## ✅ Checklist Implementasi

Saat menambahkan fitur baru, pastikan untuk:

- [ ] Tambahkan module baru di `RolePermission::$modules` jika diperlukan
- [ ] Tambahkan pengecekan izin di controller menggunakan helper functions
- [ ] Tambahkan middleware `permission` pada routes
- [ ] Sembunyikan tombol/menu di view berdasarkan izin
- [ ] Set izin default untuk setiap role di `IzinAksesController::getDefaultPermissions()`
- [ ] Test dengan berbagai role untuk memastikan izin berfungsi dengan benar

---

## 🔒 Keamanan

### Best Practices:
1. **Selalu cek izin di controller**, jangan hanya di view
2. **Gunakan middleware** untuk proteksi route
3. **Admin tetap memiliki akses penuh** ke semua fitur
4. **Redirect dengan pesan error** yang jelas jika tidak ada izin
5. **Log aktivitas** user untuk audit trail

---

## 📞 Bantuan

Jika mengalami masalah dengan sistem izin akses:

1. Pastikan migration `role_permissions` sudah dijalankan
2. Pastikan helper functions sudah di-load di `composer.json`
3. Pastikan middleware `CheckPermission` sudah terdaftar di `Kernel.php`
4. Cek apakah role dan module sudah terdaftar dengan benar
5. Hubungi tim development untuk bantuan lebih lanjut

---

**Dibuat oleh:** Tim Development Disperindagkop Tolikara  
**Terakhir Diperbarui:** 19 April 2026  
**Versi:** 1.0.0

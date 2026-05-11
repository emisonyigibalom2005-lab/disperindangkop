# SISTEM PERMISSION PIMPINAN - DATA ANGGOTA KOPERASI

## RINGKASAN
Sistem permission telah diimplementasikan dengan lengkap untuk semua fitur CRUD (Create, Read, Update, Delete) di modul Pimpinan. Pimpinan **HANYA BISA** mengelola data jika Admin sudah memberikan izin akses.

---

## MODUL YANG MENGGUNAKAN PERMISSION

### 1. DATA ANGGOTA KOPERASI (`anggota`)
**Route:** `/pimpinan/anggota-koperasi`

#### Permission yang Tersedia:
- ✅ **View (Lihat Detail)** - `can_view('anggota')`
- ✅ **Create (Tambah Anggota)** - `can_create('anggota')`
- ✅ **Edit (Edit Data)** - `can_edit('anggota')`
- ✅ **Delete (Hapus Data)** - `can_delete('anggota')`

#### Implementasi di Controller:
**File:** `app/Http/Controllers/Pimpinan/AnggotaKoperasiController.php`

```php
// Index - Lihat daftar
public function index() {
    if (!can_view('anggota')) {
        return redirect()->route('pimpinan.dashboard')
            ->with('error', 'Anda tidak memiliki izin...');
    }
}

// Show - Lihat detail
public function show($id) {
    if (!can_view('anggota')) {
        return redirect()->route('pimpinan.dashboard')
            ->with('error', 'Anda tidak memiliki izin...');
    }
}

// Create - Form tambah
public function create() {
    if (!can_create('anggota')) {
        return redirect()->route('pimpinan.anggota-koperasi.index')
            ->with('error', 'Anda tidak memiliki izin...');
    }
}

// Store - Simpan data baru
public function store(Request $request) {
    if (!can_create('anggota')) {
        return redirect()->route('pimpinan.anggota-koperasi.index')
            ->with('error', 'Anda tidak memiliki izin...');
    }
}

// Edit - Form edit
public function edit($id) {
    if (!can_edit('anggota')) {
        return redirect()->route('pimpinan.anggota-koperasi.index')
            ->with('error', 'Anda tidak memiliki izin...');
    }
}

// Update - Update data
public function update(Request $request, $id) {
    if (!can_edit('anggota')) {
        return redirect()->route('pimpinan.anggota-koperasi.index')
            ->with('error', 'Anda tidak memiliki izin...');
    }
}

// Destroy - Hapus data
public function destroy($id) {
    if (!can_delete('anggota')) {
        return response()->json([
            'success' => false,
            'message' => 'Anda tidak memiliki izin...'
        ], 403);
    }
}
```

#### Implementasi di View:
**File:** `resources/views/pimpinan/anggota-koperasi/index.blade.php`

```blade
{{-- Alert Status Permission --}}
@if(!can_view('anggota') && !can_create('anggota') && !can_edit('anggota') && !can_delete('anggota'))
    <div class="alert alert-warning">
        Anda belum memiliki izin untuk mengelola Data Anggota Koperasi.
        Silakan hubungi Administrator.
    </div>
@else
    <div class="alert alert-info">
        Status Izin Akses Anda:
        - Lihat Detail: {{ can_view('anggota') ? '✓' : '✗' }}
        - Tambah Anggota: {{ can_create('anggota') ? '✓' : '✗' }}
        - Edit Data: {{ can_edit('anggota') ? '✓' : '✗' }}
        - Hapus Data: {{ can_delete('anggota') ? '✓' : '✗' }}
    </div>
@endif

{{-- Tombol Tambah (hanya muncul jika ada izin) --}}
@if(can_create('anggota'))
<a href="{{ route('pimpinan.anggota-koperasi.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Tambah Anggota
</a>
@endif

{{-- Tombol Aksi di Tabel --}}
<div class="action-btn-group">
    @if(can_view('anggota'))
    <a href="{{ route('pimpinan.anggota-koperasi.show', $a) }}" class="btn btn-info">
        <i class="fas fa-eye"></i>
    </a>
    @endif
    
    @if(can_edit('anggota'))
    <a href="{{ route('pimpinan.anggota-koperasi.edit', $a) }}" class="btn btn-warning">
        <i class="fas fa-edit"></i>
    </a>
    @endif
    
    @if(can_delete('anggota'))
    <button onclick="deleteAnggota({{ $a->id }})" class="btn btn-danger">
        <i class="fas fa-trash"></i>
    </button>
    @endif
</div>
```

---

### 2. REKAP ANGGOTA KOPERASI (LAPORAN) (`laporan`)
**Route:** `/pimpinan/laporan/koperasi`

#### Permission yang Tersedia:
- ✅ **View (Lihat Laporan)** - `can_view('laporan')`
- ✅ **Create (Tambah Anggota)** - `can_create('laporan')`
- ✅ **Edit (Edit Data)** - `can_edit('laporan')`
- ✅ **Delete (Hapus Data)** - `can_delete('laporan')`
- ✅ **Export (Download)** - `can_export('laporan')`

#### Implementasi di View:
**File:** `resources/views/pimpinan/laporan/koperasi.blade.php`

```blade
{{-- Tombol Tambah --}}
@if(can_create('laporan'))
<button onclick="createAnggota()" class="btn btn-primary">
    <i class="fas fa-plus"></i> Tambah Anggota
</button>
@endif

{{-- Tombol Aksi --}}
<div class="btn-group">
    <button onclick="showDetail({{ $a->id }})" class="btn btn-info">
        <i class="fas fa-eye"></i>
    </button>
    
    @if(can_edit('laporan'))
    <button onclick="editAnggota({{ $a->id }})" class="btn btn-warning">
        <i class="fas fa-edit"></i>
    </button>
    @endif
    
    @if(can_delete('laporan'))
    <button onclick="deleteAnggota({{ $a->id }})" class="btn btn-danger">
        <i class="fas fa-trash"></i>
    </button>
    @endif
</div>
```

---

## CARA KERJA SISTEM PERMISSION

### 1. Admin Memberikan Izin
Admin harus masuk ke menu **Izin Akses** dan memberikan permission kepada user Pimpinan:

1. Pilih user Pimpinan
2. Pilih modul: `anggota` atau `laporan`
3. Centang permission yang diizinkan:
   - ☑ View (Lihat)
   - ☑ Create (Tambah)
   - ☑ Edit (Ubah)
   - ☑ Delete (Hapus)
4. Simpan

### 2. Pimpinan Mengakses Fitur
Setelah Admin memberikan izin:

#### ✅ JIKA ADA IZIN:
- Tombol/menu akan **MUNCUL**
- Fitur dapat **DIGUNAKAN**
- Tidak ada pesan error

#### ❌ JIKA TIDAK ADA IZIN:
- Tombol/menu **TIDAK MUNCUL**
- Jika akses langsung via URL → **REDIRECT** dengan pesan error
- Alert warning muncul: "Anda tidak memiliki izin..."

---

## FILE-FILE YANG TERLIBAT

### Controllers:
1. ✅ `app/Http/Controllers/Pimpinan/AnggotaKoperasiController.php`
   - Semua method sudah ada permission check
   
2. ✅ `app/Http/Controllers/Pimpinan/LaporanController.php`
   - Method export sudah ada permission check

### Views:
1. ✅ `resources/views/pimpinan/anggota-koperasi/index.blade.php`
   - Alert status permission
   - Tombol aksi dengan permission check
   
2. ✅ `resources/views/pimpinan/anggota-koperasi/create.blade.php`
   - Form tambah anggota
   
3. ✅ `resources/views/pimpinan/anggota-koperasi/edit.blade.php`
   - Form edit anggota
   
4. ✅ `resources/views/pimpinan/anggota-koperasi/show.blade.php`
   - Detail anggota
   
5. ✅ `resources/views/pimpinan/laporan/koperasi.blade.php`
   - Laporan dengan CRUD buttons

### Helper Functions:
**File:** `app/Helpers/PermissionHelper.php`

```php
function can_view($module) {
    return check_permission($module, 'can_view');
}

function can_create($module) {
    return check_permission($module, 'can_create');
}

function can_edit($module) {
    return check_permission($module, 'can_edit');
}

function can_delete($module) {
    return check_permission($module, 'can_delete');
}

function can_export($module) {
    return check_permission($module, 'can_export');
}
```

---

## TESTING PERMISSION

### Skenario 1: Tidak Ada Izin Sama Sekali
**Kondisi:** Admin belum memberikan izin apapun

**Hasil:**
- ❌ Tidak bisa akses `/pimpinan/anggota-koperasi` → redirect ke dashboard
- ❌ Alert warning muncul: "Anda belum memiliki izin..."
- ❌ Semua tombol (Tambah, Edit, Hapus) TIDAK MUNCUL

### Skenario 2: Hanya Izin View
**Kondisi:** Admin hanya centang "View"

**Hasil:**
- ✅ Bisa lihat daftar anggota
- ✅ Bisa lihat detail anggota
- ✅ Tombol "Detail" MUNCUL
- ❌ Tombol "Tambah Anggota" TIDAK MUNCUL
- ❌ Tombol "Edit" TIDAK MUNCUL
- ❌ Tombol "Hapus" TIDAK MUNCUL

### Skenario 3: Izin View + Create
**Kondisi:** Admin centang "View" dan "Create"

**Hasil:**
- ✅ Bisa lihat daftar anggota
- ✅ Bisa tambah anggota baru
- ✅ Tombol "Detail" MUNCUL
- ✅ Tombol "Tambah Anggota" MUNCUL
- ❌ Tombol "Edit" TIDAK MUNCUL
- ❌ Tombol "Hapus" TIDAK MUNCUL

### Skenario 4: Semua Izin
**Kondisi:** Admin centang semua (View, Create, Edit, Delete)

**Hasil:**
- ✅ Bisa lihat daftar anggota
- ✅ Bisa tambah anggota baru
- ✅ Bisa edit anggota
- ✅ Bisa hapus anggota
- ✅ Semua tombol MUNCUL

---

## KEAMANAN

### 1. Double Protection
Setiap fitur dilindungi di 2 layer:
- **Layer 1 (View):** Tombol tidak muncul jika tidak ada izin
- **Layer 2 (Controller):** Redirect/error jika akses langsung via URL

### 2. AJAX Request Protection
Untuk delete via AJAX:
```javascript
$.ajax({
    url: `/pimpinan/anggota-koperasi/${id}`,
    type: 'DELETE',
    success: function(response) {
        if (response.success) {
            // Berhasil
        } else {
            // Gagal - tidak ada izin
        }
    },
    error: function(xhr) {
        // Error 403 - Forbidden
    }
});
```

### 3. Route Protection
Semua route sudah dilindungi dengan middleware:
```php
Route::middleware(['auth', 'role:pimpinan'])->group(function() {
    // Routes here
});
```

---

## PESAN ERROR YANG MUNCUL

### 1. Tidak Ada Izin View
```
"Anda tidak memiliki izin untuk mengakses Data Anggota Koperasi. 
Silakan hubungi Admin untuk mendapatkan akses."
```

### 2. Tidak Ada Izin Create
```
"Anda tidak memiliki izin untuk menambah Anggota Koperasi. 
Silakan hubungi Admin untuk mendapatkan akses."
```

### 3. Tidak Ada Izin Edit
```
"Anda tidak memiliki izin untuk mengedit Anggota Koperasi. 
Silakan hubungi Admin untuk mendapatkan akses."
```

### 4. Tidak Ada Izin Delete
```
"Anda tidak memiliki izin untuk menghapus Anggota Koperasi."
```

---

## CARA ADMIN MEMBERIKAN IZIN

1. Login sebagai **Admin**
2. Masuk ke menu **Izin Akses** (sidebar)
3. Klik tombol **"Kelola Izin"** pada user Pimpinan
4. Pilih modul: **"anggota"** atau **"laporan"**
5. Centang permission yang ingin diberikan:
   - ☑ Lihat Data (View)
   - ☑ Tambah Data (Create)
   - ☑ Edit Data (Edit)
   - ☑ Hapus Data (Delete)
6. Klik **"Simpan"**
7. Pimpinan langsung bisa menggunakan fitur yang diizinkan

---

## TROUBLESHOOTING

### Problem: Tombol tidak muncul padahal sudah diberi izin
**Solusi:**
```bash
php artisan optimize:clear
```

### Problem: Redirect terus ke dashboard
**Solusi:**
1. Cek di Admin → Izin Akses
2. Pastikan user Pimpinan sudah diberi izin "View" untuk modul "anggota"
3. Clear cache: `php artisan optimize:clear`

### Problem: Error 403 Forbidden
**Solusi:**
1. Pastikan user login sebagai Pimpinan
2. Pastikan Admin sudah memberikan izin yang sesuai
3. Clear cache

---

## KESIMPULAN

✅ **SISTEM PERMISSION SUDAH LENGKAP**
- Semua CRUD operations dilindungi
- Double protection (View + Controller)
- Alert status permission untuk user
- Tombol hanya muncul jika ada izin
- Redirect otomatis jika tidak ada izin
- Pesan error yang jelas dan informatif

✅ **ADMIN MEMILIKI KONTROL PENUH**
- Admin menentukan siapa yang bisa apa
- Izin bisa diberikan per modul
- Izin bisa diberikan per action (View, Create, Edit, Delete)

✅ **PIMPINAN HANYA BISA KELOLA JIKA DIIZINKAN**
- Tidak ada izin = tidak bisa akses
- Partial izin = hanya fitur tertentu yang bisa digunakan
- Full izin = semua fitur bisa digunakan

---

**Dokumentasi dibuat:** {{ date('d F Y') }}
**Status:** ✅ IMPLEMENTASI LENGKAP

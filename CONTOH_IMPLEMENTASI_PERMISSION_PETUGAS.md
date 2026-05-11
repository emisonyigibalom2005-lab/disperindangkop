# ✅ Contoh Implementasi Permission System - Petugas Pengumuman

## 📋 Yang Sudah Diimplementasikan

### **File yang Diupdate:**
1. `app/Http/Controllers/Petugas/PengumumanController.php`
2. `resources/views/petugas/pengumuman/index-table.blade.php`

---

## 🔧 Implementasi di Controller

### **1. Method Index (View Permission)**
```php
public function index(Request $request)
{
    // Cek izin view
    if (!can_view('pengumuman')) {
        return redirect()->route('petugas.dashboard')
            ->with('error', 'Anda tidak memiliki izin untuk melihat pengumuman. Hubungi Administrator untuk mendapatkan akses.');
    }
    
    // Lanjutkan logic...
}
```

### **2. Method Create (Create Permission)**
```php
public function create()
{
    // Cek izin create
    if (!can_create('pengumuman')) {
        return redirect()->route('petugas.pengumuman.index')
            ->with('error', 'Anda tidak memiliki izin untuk membuat pengumuman. Hubungi Administrator untuk mendapatkan akses.');
    }
    
    return view('petugas.pengumuman.create');
}
```

### **3. Method Store (Create Permission)**
```php
public function store(Request $request)
{
    // Cek izin create
    if (!can_create('pengumuman')) {
        return redirect()->route('petugas.pengumuman.index')
            ->with('error', 'Anda tidak memiliki izin untuk membuat pengumuman.');
    }
    
    // Validasi dan simpan...
}
```

### **4. Method Edit (Edit Permission)**
```php
public function edit($id)
{
    // Cek izin edit
    if (!can_edit('pengumuman')) {
        return redirect()->route('petugas.pengumuman.index')
            ->with('error', 'Anda tidak memiliki izin untuk mengedit pengumuman. Hubungi Administrator untuk mendapatkan akses.');
    }
    
    $pengumuman = Pengumuman::findOrFail($id);
    return view('petugas.pengumuman.edit', compact('pengumuman'));
}
```

### **5. Method Update (Edit Permission)**
```php
public function update(Request $request, $id)
{
    // Cek izin edit
    if (!can_edit('pengumuman')) {
        return redirect()->route('petugas.pengumuman.index')
            ->with('error', 'Anda tidak memiliki izin untuk mengedit pengumuman.');
    }
    
    // Update data...
}
```

### **6. Method Destroy (Delete Permission)**
```php
public function destroy($id)
{
    // Cek izin delete
    if (!can_delete('pengumuman')) {
        return redirect()->route('petugas.pengumuman.index')
            ->with('error', 'Anda tidak memiliki izin untuk menghapus pengumuman. Hubungi Administrator untuk mendapatkan akses.');
    }
    
    // Hapus data...
}
```

---

## 🎨 Implementasi di View (Blade)

### **1. Tombol "Buat Pengumuman" (Create Permission)**
```blade
@canCreate('pengumuman')
    <a href="{{ route('petugas.pengumuman.create') }}" class="btn btn-light mb-2">
        <i class="fas fa-plus mr-2"></i>Buat Pengumuman
    </a>
@else
    <button class="btn btn-light mb-2 disabled" disabled title="Tidak ada izin membuat pengumuman">
        <i class="fas fa-lock mr-2"></i>Buat Pengumuman
    </button>
@endcanCreate
```

**Hasil:**
- ✅ Jika ada izin create → Tombol aktif dan bisa diklik
- ❌ Jika tidak ada izin → Tombol disabled dengan icon lock

### **2. Tombol Detail (View Permission)**
```blade
@canView('pengumuman')
    <a href="{{ route('petugas.pengumuman.show', $item->id) }}" 
       class="btn btn-sm btn-outline-primary" 
       title="Lihat Detail">
        <i class="fas fa-eye"></i>
    </a>
@endcanView
```

**Hasil:**
- ✅ Jika ada izin view → Tombol tampil
- ❌ Jika tidak ada izin → Tombol tidak tampil

### **3. Tombol Edit (Edit Permission)**
```blade
@canEdit('pengumuman')
    <a href="{{ route('petugas.pengumuman.edit', $item->id) }}" 
       class="btn btn-sm btn-outline-warning" 
       title="Edit">
        <i class="fas fa-edit"></i>
    </a>
@endcanEdit
```

**Hasil:**
- ✅ Jika ada izin edit → Tombol tampil
- ❌ Jika tidak ada izin → Tombol tidak tampil

### **4. Tombol Hapus (Delete Permission)**
```blade
@canDelete('pengumuman')
    <form action="{{ route('petugas.pengumuman.destroy', $item->id) }}" 
          method="POST" 
          style="display:inline" 
          onsubmit="return confirm('Yakin ingin menghapus?')">
        @csrf
        @method('DELETE')
        <button type="submit" 
                class="btn btn-sm btn-outline-danger" 
                title="Hapus">
            <i class="fas fa-trash"></i>
        </button>
    </form>
@endcanDelete
```

**Hasil:**
- ✅ Jika ada izin delete → Tombol tampil
- ❌ Jika tidak ada izin → Tombol tidak tampil

---

## 🎯 Alur Kerja Permission

### **Skenario 1: Petugas dengan Full Access**
```
Admin Set Permission:
✅ View: ON
✅ Create: ON
✅ Edit: ON
✅ Delete: ON

Hasil di Halaman Petugas:
✅ Bisa lihat daftar pengumuman
✅ Tombol "Buat Pengumuman" aktif
✅ Tombol "Detail" tampil
✅ Tombol "Edit" tampil
✅ Tombol "Hapus" tampil
```

### **Skenario 2: Petugas dengan View Only**
```
Admin Set Permission:
✅ View: ON
❌ Create: OFF
❌ Edit: OFF
❌ Delete: OFF

Hasil di Halaman Petugas:
✅ Bisa lihat daftar pengumuman
❌ Tombol "Buat Pengumuman" disabled (icon lock)
✅ Tombol "Detail" tampil
❌ Tombol "Edit" tidak tampil
❌ Tombol "Hapus" tidak tampil
```

### **Skenario 3: Petugas Tanpa Izin Sama Sekali**
```
Admin Set Permission:
❌ View: OFF
❌ Create: OFF
❌ Edit: OFF
❌ Delete: OFF

Hasil:
❌ Redirect ke dashboard dengan pesan error:
   "Anda tidak memiliki izin untuk melihat pengumuman. 
    Hubungi Administrator untuk mendapatkan akses."
```

### **Skenario 4: Petugas dengan View + Create**
```
Admin Set Permission:
✅ View: ON
✅ Create: ON
❌ Edit: OFF
❌ Delete: OFF

Hasil di Halaman Petugas:
✅ Bisa lihat daftar pengumuman
✅ Tombol "Buat Pengumuman" aktif
✅ Bisa buat pengumuman baru
✅ Tombol "Detail" tampil
❌ Tombol "Edit" tidak tampil
❌ Tombol "Hapus" tidak tampil
```

---

## 📝 Cara Admin Memberikan Izin

### **Langkah-langkah:**

1. **Login sebagai Admin**
   - Buka browser
   - Login dengan akun Admin

2. **Buka Menu Izin Akses**
   - Klik menu "PENGATURAN" di sidebar
   - Klik "Izin Akses"

3. **Pilih Role Petugas**
   - Cari card "Petugas"
   - Klik tombol "Kelola Izin Akses"

4. **Atur Permission untuk Pengumuman**
   - Cari baris "Pengumuman"
   - Centang checkbox sesuai kebutuhan:
     - ✅ **View**: Agar bisa lihat daftar
     - ✅ **Create**: Agar bisa buat baru
     - ✅ **Edit**: Agar bisa edit
     - ✅ **Delete**: Agar bisa hapus

5. **Simpan Perubahan**
   - Klik tombol "Simpan Perubahan" (hijau)
   - Konfirmasi di popup
   - Tunggu notifikasi sukses

6. **Test dengan Login Petugas**
   - Logout dari Admin
   - Login sebagai Petugas
   - Buka menu Pengumuman
   - Cek apakah tombol sesuai izin yang diberikan

---

## 🚀 Cara Implementasi untuk Module Lain

### **Contoh: Koperasi**

#### **1. Update Controller**
```php
// app/Http/Controllers/Petugas/KoperasiController.php

public function index()
{
    if (!can_view('koperasi')) {
        return redirect()->route('petugas.dashboard')
            ->with('error', 'Tidak ada izin untuk melihat koperasi');
    }
    // ...
}

public function create()
{
    if (!can_create('koperasi')) {
        return redirect()->back()
            ->with('error', 'Tidak ada izin untuk membuat koperasi');
    }
    // ...
}

public function edit($id)
{
    if (!can_edit('koperasi')) {
        return redirect()->back()
            ->with('error', 'Tidak ada izin untuk mengedit koperasi');
    }
    // ...
}

public function destroy($id)
{
    if (!can_delete('koperasi')) {
        return redirect()->back()
            ->with('error', 'Tidak ada izin untuk menghapus koperasi');
    }
    // ...
}
```

#### **2. Update View**
```blade
{{-- Tombol Tambah --}}
@canCreate('koperasi')
    <a href="{{ route('petugas.koperasi.create') }}" class="btn btn-primary">
        Tambah Koperasi
    </a>
@endcanCreate

{{-- Tombol Edit --}}
@canEdit('koperasi')
    <a href="{{ route('petugas.koperasi.edit', $item->id) }}" class="btn btn-warning">
        Edit
    </a>
@endcanEdit

{{-- Tombol Hapus --}}
@canDelete('koperasi')
    <button onclick="confirmDelete({{ $item->id }})" class="btn btn-danger">
        Hapus
    </button>
@endcanDelete
```

---

## ⚠️ Catatan Penting

1. **Admin Selalu Full Access**
   - Role admin tidak perlu dicek permission
   - Admin otomatis bisa semua aksi

2. **Pesan Error yang Jelas**
   - Selalu berikan pesan error yang informatif
   - Arahkan user untuk hubungi Administrator

3. **UI Adaptation**
   - Tombol yang tidak ada izin sebaiknya disembunyikan
   - Atau tampilkan disabled dengan icon lock

4. **Double Protection**
   - Cek di controller (security)
   - Cek di view (UX)
   - Jangan hanya salah satu

5. **Testing**
   - Selalu test dengan login sebagai role yang berbeda
   - Test semua skenario permission

---

## 📊 Checklist Implementasi

Untuk setiap module, pastikan:

- [ ] Controller index ada `can_view()` check
- [ ] Controller create ada `can_create()` check
- [ ] Controller store ada `can_create()` check
- [ ] Controller edit ada `can_edit()` check
- [ ] Controller update ada `can_edit()` check
- [ ] Controller destroy ada `can_delete()` check
- [ ] View tombol create pakai `@canCreate`
- [ ] View tombol edit pakai `@canEdit`
- [ ] View tombol delete pakai `@canDelete`
- [ ] Pesan error informatif
- [ ] Test dengan berbagai role

---

**Status:** ✅ Implementasi Selesai untuk Petugas Pengumuman  
**Next:** Terapkan pattern yang sama untuk module lain

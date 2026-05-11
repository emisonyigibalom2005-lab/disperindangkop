# TROUBLESHOOTING - PERMISSION REKAP BANTUAN

## MASALAH: Tombol Edit, Hapus, Create Tidak Muncul Padahal Sudah Diberi Izin

### ✅ SOLUSI YANG SUDAH DITERAPKAN:

1. **File View Sudah Diperbaiki**
   - File: `resources/views/pimpinan/laporan/bantuan.blade.php`
   - Tombol sekarang menggunakan variable `$canView`, `$canCreate`, `$canEdit`, `$canDelete`
   - Ditambahkan logging untuk debugging

2. **Cache Sudah Dibersihkan**
   - Command: `php artisan optimize:clear`
   - Semua cache (config, view, route) sudah dibersihkan

---

## 🔍 CARA CEK PERMISSION

### 1. Cek di Database
Buka database dan jalankan query ini:

```sql
-- Cek permission untuk user pimpinan
SELECT rp.*, u.name, u.role 
FROM role_permissions rp
JOIN users u ON u.role = rp.role
WHERE u.id = [ID_USER_PIMPINAN]
AND rp.module = 'laporan';
```

**Hasil yang diharapkan:**
```
role: pimpinan
module: laporan
can_view: 1
can_create: 1
can_edit: 1
can_delete: 1
```

### 2. Cek di Log File
Buka file: `storage/logs/laravel.log`

Cari baris dengan text: `Bantuan Page`

**Contoh log yang benar:**
```
[2025-01-XX] local.INFO: Bantuan Page - User: Nama Pimpinan
[2025-01-XX] local.INFO: Bantuan Page - Role: pimpinan
[2025-01-XX] local.INFO: Bantuan Page - can_view: YES
[2025-01-XX] local.INFO: Bantuan Page - can_create: YES
[2025-01-XX] local.INFO: Bantuan Page - can_edit: YES
[2025-01-XX] local.INFO: Bantuan Page - can_delete: YES
```

**Jika log menunjukkan NO:**
- Berarti permission belum tersimpan di database
- Perlu set ulang permission dari Admin

---

## 📋 LANGKAH-LANGKAH TROUBLESHOOTING

### STEP 1: Verifikasi User Login
1. Login sebagai **Pimpinan**
2. Buka halaman: `/pimpinan/laporan/bantuan`
3. Lihat alert di bagian atas halaman
4. Pastikan ada alert **BIRU** (bukan kuning)
5. Lihat status permission:
   - ✓ = Ada izin (hijau)
   - ✗ = Tidak ada izin (abu-abu)

### STEP 2: Cek Permission di Admin
1. Logout dari Pimpinan
2. Login sebagai **Admin**
3. Buka menu **Izin Akses**
4. Cari user Pimpinan
5. Klik **"Kelola Izin"**
6. Pilih modul **"laporan"**
7. Pastikan semua checkbox tercentang:
   - ☑ Lihat Data (can_view)
   - ☑ Tambah Data (can_create)
   - ☑ Edit Data (can_edit)
   - ☑ Hapus Data (can_delete)
8. Klik **"Simpan"**

### STEP 3: Clear Cache
Jalankan command ini di terminal:
```bash
php artisan optimize:clear
```

### STEP 4: Test Ulang
1. Logout dari Admin
2. Login kembali sebagai **Pimpinan**
3. Buka halaman: `/pimpinan/laporan/bantuan`
4. Refresh halaman (Ctrl+F5)
5. Cek apakah tombol sudah muncul

---

## 🎯 EXPECTED RESULT (Hasil yang Diharapkan)

### Jika SEMUA Permission Diberikan:

**Alert Status:**
```
✓ Lihat Detail (hijau, bold)
✓ Tambah Bantuan (hijau, bold)
✓ Edit Data (hijau, bold)
✓ Hapus Data (hijau, bold)
```

**Tombol di Header:**
```
[Tambah Program] ← Tombol biru, bisa diklik
```

**Tombol di Tabel (Kolom Aksi):**
```
[👁 Detail] [✏ Edit] [🗑 Hapus]
```

### Jika TIDAK ADA Permission:

**Alert Status:**
```
⚠ Akses Terbatas
Anda belum memiliki izin untuk mengelola Laporan Bantuan.
```

**Tombol di Header:**
```
[🔒 Tidak Ada Izin Tambah] ← Badge abu-abu
```

**Tombol di Tabel:**
```
[🔒 Tidak Ada Akses] ← Badge abu-abu
```

---

## 🔧 JIKA MASIH BELUM MUNCUL

### Opsi 1: Reset Permission Manual di Database

```sql
-- Hapus permission lama
DELETE FROM role_permissions 
WHERE role = 'pimpinan' AND module = 'laporan';

-- Insert permission baru
INSERT INTO role_permissions (role, module, can_view, can_create, can_edit, can_delete, can_export, can_approve, created_at, updated_at)
VALUES ('pimpinan', 'laporan', 1, 1, 1, 1, 0, 0, NOW(), NOW());
```

### Opsi 2: Cek Model RolePermission

File: `app/Models/RolePermission.php`

Pastikan method `hasPermission` ada:
```php
public static function hasPermission($role, $module, $action = 'view')
{
    $permission = self::where('role', $role)
        ->where('module', $module)
        ->first();
    
    if (!$permission) {
        return false;
    }
    
    $field = 'can_' . $action;
    return $permission->$field == 1;
}
```

### Opsi 3: Test Permission Function

Buat route test di `routes/web.php`:
```php
Route::get('/test-permission', function() {
    if (!auth()->check()) {
        return 'Not logged in';
    }
    
    return [
        'user' => auth()->user()->name,
        'role' => auth()->user()->role,
        'can_view' => can_view('laporan') ? 'YES' : 'NO',
        'can_create' => can_create('laporan') ? 'YES' : 'NO',
        'can_edit' => can_edit('laporan') ? 'YES' : 'NO',
        'can_delete' => can_delete('laporan') ? 'YES' : 'NO',
    ];
});
```

Akses: `http://localhost/test-permission`

**Hasil yang diharapkan:**
```json
{
  "user": "Nama Pimpinan",
  "role": "pimpinan",
  "can_view": "YES",
  "can_create": "YES",
  "can_edit": "YES",
  "can_delete": "YES"
}
```

---

## 📞 CHECKLIST FINAL

Sebelum menghubungi support, pastikan sudah:

- [ ] Login sebagai Pimpinan (bukan Admin)
- [ ] Permission sudah di-set di menu Izin Akses
- [ ] Semua checkbox tercentang (View, Create, Edit, Delete)
- [ ] Sudah klik tombol "Simpan"
- [ ] Sudah jalankan `php artisan optimize:clear`
- [ ] Sudah logout dan login ulang
- [ ] Sudah refresh halaman (Ctrl+F5)
- [ ] Sudah cek log file di `storage/logs/laravel.log`
- [ ] Sudah cek database table `role_permissions`

---

## 🎉 JIKA SUDAH BERHASIL

Anda akan melihat:

1. **Alert Biru** dengan status permission
2. **Tombol "Tambah Program"** di header (jika ada izin create)
3. **Tombol Detail** di setiap row (jika ada izin view)
4. **Tombol Edit** di setiap row (jika ada izin edit)
5. **Tombol Hapus** di setiap row (jika ada izin delete)

Semua tombol akan **BERFUNGSI** dan tidak ada error.

---

**Dokumentasi dibuat:** {{ date('d F Y, H:i') }}
**Status:** ✅ TROUBLESHOOTING GUIDE LENGKAP

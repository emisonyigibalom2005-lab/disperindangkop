# Update Petugas Controllers - Permission Checks

## Controllers yang Sudah Diupdate:
✅ AnggotaKoperasiController.php
✅ KoperasiController.php

## Controllers yang Perlu Diupdate:

### 1. BantuanController.php
Module: `bantuan`
Methods:
- index() - can_view('bantuan')
- show() - can_view('bantuan')
- create() - can_create('bantuan')
- store() - can_create('bantuan')
- edit() - can_edit('bantuan')
- update() - can_edit('bantuan')
- destroy() - can_delete('bantuan')

### 2. BeritaController.php
Module: `berita`
Methods:
- index() - can_view('berita')
- show() - can_view('berita')
- create() - can_create('berita')
- store() - can_create('berita')
- edit() - can_edit('berita')
- update() - can_edit('berita')
- destroy() - can_delete('berita')

### 3. PengumumanController.php
Module: `pengumuman`
Methods:
- index() - can_view('pengumuman')
- show() - can_view('pengumuman')
- create() - can_create('pengumuman')
- store() - can_create('pengumuman')
- edit() - can_edit('pengumuman')
- update() - can_edit('pengumuman')
- destroy() - can_delete('pengumuman')

### 4. JadwalController.php
Module: `jadwal`
Methods:
- index() - can_view('jadwal')
- show() - can_view('jadwal')
- create() - can_create('jadwal')
- store() - can_create('jadwal')
- edit() - can_edit('jadwal')
- update() - can_edit('jadwal')
- destroy() - can_delete('jadwal')

### 5. GaleriController.php
Module: `galeri`
Methods:
- index() - can_view('galeri')
- show() - can_view('galeri')
- create() - can_create('galeri')
- store() - can_create('galeri')
- edit() - can_edit('galeri')
- update() - can_edit('galeri')
- destroy() - can_delete('galeri')

### 6. PelatihanController.php
Module: `pelatihan`
Methods:
- index() - can_view('pelatihan')
- show() - can_view('pelatihan')
- create() - can_create('pelatihan')
- store() - can_create('pelatihan')
- edit() - can_edit('pelatihan')
- update() - can_edit('pelatihan')
- destroy() - can_delete('pelatihan')

### 7. LaporanController.php
Module: `laporan`
Methods:
- index() - can_view('laporan')
- export() - can_export('laporan')

### 8. UserController.php
Module: `user`
Methods:
- index() - can_view('user')
- show() - can_view('user')
- create() - can_create('user')
- store() - can_create('user')
- edit() - can_edit('user')
- update() - can_edit('user')
- destroy() - can_delete('user')

### 9. ChatController.php
Module: `chat`
Methods:
- index() - can_view('chat')
- store() - can_create('chat')

### 10. KontakController.php (Already has permission check)
Module: `kontak`
✅ Already implemented

### 11. StrukturController.php
Module: `struktur`
Methods:
- index() - can_view('struktur')
- create() - can_create('struktur')
- store() - can_create('struktur')
- edit() - can_edit('struktur')
- update() - can_edit('struktur')
- destroy() - can_delete('struktur')

### 12. HalamanStatisController.php
Module: `halaman_statis`
Methods:
- index() - can_view('halaman_statis')
- create() - can_create('halaman_statis')
- store() - can_create('halaman_statis')
- edit() - can_edit('halaman_statis')
- update() - can_edit('halaman_statis')
- destroy() - can_delete('halaman_statis')

## Template Permission Check:

```php
// For index/show methods
if (!can_view('module_name')) {
    return redirect()->route('petugas.dashboard')
        ->with('error', 'Anda tidak memiliki izin untuk melihat data ini. Hubungi Administrator untuk mendapatkan akses.');
}

// For create method
if (!can_create('module_name')) {
    return redirect()->route('petugas.module.index')
        ->with('error', 'Anda tidak memiliki izin untuk menambah data. Hubungi Administrator untuk mendapatkan akses.');
}

// For store method
if (!can_create('module_name')) {
    return redirect()->route('petugas.module.index')
        ->with('error', 'Anda tidak memiliki izin untuk menambah data.');
}

// For edit method
if (!can_edit('module_name')) {
    return redirect()->route('petugas.module.index')
        ->with('error', 'Anda tidak memiliki izin untuk mengubah data. Hubungi Administrator untuk mendapatkan akses.');
}

// For update method
if (!can_edit('module_name')) {
    return redirect()->route('petugas.module.index')
        ->with('error', 'Anda tidak memiliki izin untuk mengubah data.');
}

// For destroy method
if (!can_delete('module_name')) {
    return redirect()->route('petugas.module.index')
        ->with('error', 'Anda tidak memiliki izin untuk menghapus data. Hubungi Administrator untuk mendapatkan akses.');
}

// For export method
if (!can_export('module_name')) {
    return redirect()->route('petugas.module.index')
        ->with('error', 'Anda tidak memiliki izin untuk mengekspor data. Hubungi Administrator untuk mendapatkan akses.');
}
```

## Cara Implementasi:

1. Buka setiap controller
2. Tambahkan permission check di awal setiap method
3. Gunakan module name yang sesuai
4. Redirect ke dashboard atau index dengan pesan error yang jelas
5. Test dengan user Petugas yang belum diberi izin

## Testing:

1. Login sebagai Admin
2. Buka menu Izin Akses
3. Pilih role "Petugas"
4. Hapus semua izin untuk modul tertentu
5. Login sebagai Petugas
6. Coba akses fitur yang izinnya sudah dihapus
7. Harus muncul pesan error dan redirect

## Notes:

- Admin selalu memiliki full access (tidak perlu cek izin)
- Petugas harus mendapat izin dari Admin untuk setiap modul
- Pesan error harus jelas dan informatif
- Redirect ke halaman yang sesuai (dashboard atau index)

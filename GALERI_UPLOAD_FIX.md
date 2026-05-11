# Perbaikan Upload Galeri - Dokumentasi

## Masalah yang Ditemukan
Saat upload foto di halaman galeri, terjadi error dan foto tidak bisa disimpan ke database.

## Penyebab Masalah
1. **Kolom Database Hilang**: Tabel `galeri` tidak memiliki kolom yang dibutuhkan oleh controller:
   - `kategori` (untuk kategori foto)
   - `urutan` (untuk urutan tampilan)
   - `is_active` (untuk status aktif/nonaktif)

2. **Validasi Controller**: Controller membutuhkan kolom-kolom tersebut tetapi tidak ada di database

## Solusi yang Diterapkan

### 1. Migration Database
Dibuat migration baru untuk menambahkan kolom yang hilang:
```
database/migrations/2026_04_12_000000_add_missing_columns_to_galeri_table.php
```

Kolom yang ditambahkan:
- `kategori` (string, default: 'kegiatan')
- `urutan` (integer, default: 0)
- `is_active` (boolean, default: true)

Migration sudah dijalankan dan berhasil (Batch 15).

### 2. Controller Update
File: `app/Http/Controllers/Admin/GaleriController.php`

**Perubahan pada method `store()`:**
- Menghapus validasi `judul` dan `deskripsi` (tidak required)
- Auto-generate `judul` dari nama file atau timestamp
- Auto-generate `urutan` dari max urutan + 1
- Set default `kategori` = 'kegiatan'
- Set default `is_active` = true
- Hanya field `foto` yang required

### 3. Model Update
File: `app/Models/Galeri.php`

Menambahkan kolom ke `$fillable`:
```php
protected $fillable = ['tipe','judul','deskripsi','foto','kategori','urutan','is_active'];
```

### 4. View Update - Create Page
File: `resources/views/admin/galeri/create.blade.php`

**Perubahan:**
- Removed: Pilihan tipe (foto/video)
- Removed: Input field judul
- Removed: Input field deskripsi
- Added: Hidden input `<input type="hidden" name="tipe" value="foto">`
- Simplified: Hanya upload area untuk foto
- Improved: Preview foto yang lebih besar dan menarik
- Enhanced: Drag & drop support
- Added: File size validation (max 2MB)
- Added: Loading state saat submit

**Fitur Upload:**
- Klik area upload atau drag & drop file
- Preview foto sebelum upload
- Validasi ukuran file (max 2MB)
- Validasi format (JPG, PNG, GIF)
- Button remove preview
- Loading indicator saat menyimpan

### 5. View Update - Edit Page
File: `resources/views/admin/galeri/edit.blade.php`

**Perubahan:**
- Updated: Extends dari `layouts.app` (bukan `layouts.admin`)
- Added: Modern header dengan gradient blue
- Added: Preview foto saat ini
- Added: Upload area untuk foto baru
- Added: Preview foto baru sebelum save
- Improved: Form styling dengan `form-modern` classes
- Enhanced: Better UX dengan info boxes
- Added: Loading state saat submit

## Cara Menggunakan

### Upload Foto Baru
1. Buka menu **Galeri** di admin panel
2. Klik tombol **Tambah Foto**
3. Klik area upload atau drag & drop foto
4. Preview foto akan muncul
5. Klik **Simpan Galeri**
6. Foto akan tersimpan dengan judul auto-generate dari nama file

### Edit Foto
1. Buka menu **Galeri** di admin panel
2. Hover pada foto yang ingin diedit
3. Klik icon **Edit** (pensil)
4. Ubah judul atau deskripsi (opsional)
5. Upload foto baru jika ingin mengganti (opsional)
6. Klik **Simpan Perubahan**

## Struktur Database Galeri

Tabel: `galeri`

| Kolom | Tipe | Default | Keterangan |
|-------|------|---------|------------|
| id | bigint | auto | Primary key |
| tipe | enum | foto | foto atau video |
| judul | string | - | Judul foto |
| foto | string | - | Path file foto |
| deskripsi | text | null | Deskripsi (opsional) |
| kategori | string | kegiatan | Kategori foto |
| urutan | integer | 0 | Urutan tampilan |
| is_active | boolean | true | Status aktif |
| created_by | bigint | null | User yang upload |
| created_at | timestamp | - | Waktu dibuat |
| updated_at | timestamp | - | Waktu diupdate |

## Testing

Untuk test upload foto:
1. Pastikan folder `storage/app/public/galeri` ada dan writable
2. Jalankan `php artisan storage:link` jika belum
3. Upload foto dengan ukuran < 2MB
4. Cek di database apakah data tersimpan
5. Cek di folder `storage/app/public/galeri` apakah file tersimpan

## Catatan Penting

1. **Ukuran File**: Maksimal 2MB per foto
2. **Format**: JPG, JPEG, PNG, GIF
3. **Judul**: Auto-generate dari nama file (tanpa extension)
4. **Kategori**: Default 'kegiatan', bisa diubah di edit page
5. **Urutan**: Auto-increment dari urutan terakhir
6. **Status**: Default aktif (is_active = true)

## File yang Dimodifikasi

1. ✅ `database/migrations/2026_04_12_000000_add_missing_columns_to_galeri_table.php` (NEW)
2. ✅ `app/Http/Controllers/Admin/GaleriController.php` (UPDATED)
3. ✅ `app/Models/Galeri.php` (UPDATED)
4. ✅ `resources/views/admin/galeri/create.blade.php` (UPDATED)
5. ✅ `resources/views/admin/galeri/edit.blade.php` (UPDATED)
6. ✅ `resources/views/admin/galeri/index.blade.php` (ALREADY MODERN)

## Status
✅ **SELESAI** - Upload galeri sudah berfungsi dengan baik dan tampilan sudah modern sesuai dashboard admin.

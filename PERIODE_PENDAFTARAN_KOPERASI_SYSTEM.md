# 🎯 Sistem Periode Pendaftaran Koperasi

## 📋 Ringkasan

Sistem periode pendaftaran koperasi memungkinkan admin untuk mengontrol kapan petugas bisa mendaftarkan koperasi baru. Petugas hanya bisa mendaftarkan koperasi jika admin sudah membuka periode pendaftaran.

---

## ✨ Fitur Utama

### 1. **Admin**
- ✅ Membuat periode pendaftaran baru
- ✅ Mengatur tanggal mulai dan selesai
- ✅ Mengatur kuota pendaftaran (optional)
- ✅ Mengaktifkan/menonaktifkan periode
- ✅ Melihat jumlah pendaftar per periode
- ✅ Mengedit dan menghapus periode

### 2. **Petugas**
- ✅ Hanya bisa daftar koperasi jika periode aktif
- ✅ Melihat informasi periode yang sedang berlangsung
- ✅ Mendapat notifikasi jika periode ditutup
- ✅ Mendapat notifikasi jika kuota penuh

---

## 📁 File yang Dibuat/Dimodifikasi

### 1. **Migration**
```
database/migrations/2026_04_16_070000_create_periode_pendaftaran_koperasi_table.php
```
- Tabel `periode_pendaftaran_koperasi`
- Kolom `periode_pendaftaran_koperasi_id` di tabel `koperasi`

### 2. **Model**
```
app/Models/PeriodePendaftaranKoperasi.php (BARU)
app/Models/Koperasi.php (UPDATE)
```

### 3. **Controller**
```
app/Http/Controllers/Admin/PeriodePendaftaranKoperasiController.php (BARU)
app/Http/Controllers/Petugas/KoperasiController.php (UPDATE)
```

### 4. **Routes** (Perlu ditambahkan)
```php
// routes/web.php

// Admin - Periode Pendaftaran Koperasi
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('periode-pendaftaran-koperasi', PeriodePendaftaranKoperasiController::class);
    Route::post('periode-pendaftaran-koperasi/{periodePendaftaranKoperasi}/toggle', 
        [PeriodePendaftaranKoperasiController::class, 'toggleStatus'])
        ->name('periode-pendaftaran-koperasi.toggle');
});
```

---

## 🗄️ Struktur Database

### Tabel: `periode_pendaftaran_koperasi`

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| nama_periode | string | Nama periode (contoh: "Pendaftaran Koperasi 2026 Semester 1") |
| deskripsi | text | Deskripsi periode (optional) |
| tanggal_mulai | date | Tanggal mulai pendaftaran |
| tanggal_selesai | date | Tanggal selesai pendaftaran |
| is_active | boolean | Status aktif/tidak (hanya 1 yang bisa aktif) |
| kuota | integer | Kuota maksimal pendaftar (optional) |
| created_by | bigint | User yang membuat periode |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

### Update Tabel: `koperasi`

Menambahkan kolom:
- `periode_pendaftaran_koperasi_id` (bigint, nullable, foreign key)

---

## 🎯 Cara Kerja

### 1. **Admin Membuka Periode**
```
1. Admin login
2. Masuk ke menu "Periode Pendaftaran Koperasi"
3. Klik "Tambah Periode Baru"
4. Isi form:
   - Nama Periode
   - Deskripsi (optional)
   - Tanggal Mulai
   - Tanggal Selesai
   - Kuota (optional)
   - Status Aktif (checkbox)
5. Simpan
```

### 2. **Petugas Mendaftar Koperasi**
```
1. Petugas login
2. Masuk ke menu "Data Koperasi"
3. Klik "Daftar Koperasi Baru"

SKENARIO A: Periode Aktif
- Form pendaftaran ditampilkan
- Info periode ditampilkan di atas form
- Petugas bisa mengisi dan submit

SKENARIO B: Periode Ditutup
- Redirect ke halaman index
- Pesan error: "Pendaftaran koperasi baru sedang ditutup"
- Tombol "Daftar Baru" disabled/hidden

SKENARIO C: Kuota Penuh
- Redirect ke halaman index
- Pesan error: "Kuota pendaftaran periode ini sudah penuh"
```

### 3. **Validasi Otomatis**
```php
// Di controller petugas
$periodeAktif = PeriodePendaftaranKoperasi::getPeriodeAktif();

if (!$periodeAktif) {
    return redirect()->back()->with('error', 'Pendaftaran ditutup');
}

if ($periodeAktif->isKuotaPenuh()) {
    return redirect()->back()->with('error', 'Kuota penuh');
}
```

---

## 📊 Status Periode

| Status | Kondisi | Badge |
|--------|---------|-------|
| **Berlangsung** | is_active = true, tanggal hari ini antara mulai-selesai | 🟢 Success |
| **Belum Dimulai** | is_active = true, tanggal hari ini < tanggal_mulai | 🔵 Info |
| **Selesai** | is_active = true, tanggal hari ini > tanggal_selesai | ⚫ Secondary |
| **Tidak Aktif** | is_active = false | 🔴 Danger |

---

## 🔧 Method Helper di Model

### PeriodePendaftaranKoperasi

```php
// Static Methods
PeriodePendaftaranKoperasi::getPeriodeAktif()
// Return: Periode yang sedang berlangsung atau null

PeriodePendaftaranKoperasi::isPendaftaranTerbuka()
// Return: true jika ada periode aktif dan kuota belum penuh

// Instance Methods
$periode->isBerlangsung()
// Return: true jika periode sedang berlangsung

$periode->isKuotaPenuh()
// Return: true jika kuota sudah penuh

// Attributes
$periode->status
// Return: 'Berlangsung', 'Belum Dimulai', 'Selesai', 'Tidak Aktif'

$periode->status_badge
// Return: HTML badge dengan warna sesuai status

$periode->jumlah_pendaftar
// Return: Jumlah koperasi yang terdaftar di periode ini

$periode->sisa_kuota
// Return: Sisa kuota atau null jika tidak ada kuota
```

---

## 🎨 View yang Perlu Dibuat

### 1. **Admin - Index** (`resources/views/admin/periode-pendaftaran-koperasi/index.blade.php`)
- Tabel list periode
- Tombol tambah periode
- Tombol edit, hapus, toggle status
- Info jumlah pendaftar per periode

### 2. **Admin - Create** (`resources/views/admin/periode-pendaftaran-koperasi/create.blade.php`)
- Form tambah periode
- Field: nama, deskripsi, tanggal mulai/selesai, kuota, is_active

### 3. **Admin - Edit** (`resources/views/admin/periode-pendaftaran-koperasi/edit.blade.php`)
- Form edit periode
- Sama seperti create tapi dengan data existing

### 4. **Petugas - Create (UPDATE)** (`resources/views/petugas/koperasi/create.blade.php`)
- Tambahkan info box periode aktif di atas form
- Tampilkan: nama periode, tanggal, sisa kuota

---

## 🚀 Langkah Implementasi

### 1. ✅ Migration (SELESAI)
```bash
php artisan migrate
```

### 2. ✅ Model (SELESAI)
- PeriodePendaftaranKoperasi
- Update Koperasi

### 3. ✅ Controller (SELESAI)
- Admin: PeriodePendaftaranKoperasiController
- Petugas: Update KoperasiController

### 4. ⏳ Routes (PERLU DITAMBAHKAN)
```php
Route::resource('periode-pendaftaran-koperasi', PeriodePendaftaranKoperasiController::class);
Route::post('periode-pendaftaran-koperasi/{periodePendaftaranKoperasi}/toggle', ...);
```

### 5. ⏳ Views (PERLU DIBUAT)
- admin/periode-pendaftaran-koperasi/index.blade.php
- admin/periode-pendaftaran-koperasi/create.blade.php
- admin/periode-pendaftaran-koperasi/edit.blade.php
- Update: petugas/koperasi/create.blade.php

### 6. ⏳ Menu Sidebar (PERLU DITAMBAHKAN)
Tambahkan menu di sidebar admin:
```html
<li class="nav-item">
    <a href="{{ route('admin.periode-pendaftaran-koperasi.index') }}" class="nav-link">
        <i class="nav-icon fas fa-calendar-check"></i>
        <p>Periode Pendaftaran Koperasi</p>
    </a>
</li>
```

---

## 📝 Contoh Data

### Periode Pendaftaran
```
Nama: Pendaftaran Koperasi 2026 Semester 1
Deskripsi: Periode pendaftaran koperasi baru untuk semester 1 tahun 2026
Tanggal Mulai: 2026-01-01
Tanggal Selesai: 2026-06-30
Kuota: 100
Status: Aktif
```

### Koperasi Terdaftar
```
Nama Usaha: Koperasi Simpan Pinjam Sejahtera
No Registrasi: KOPERASI-2026-0001
Periode: Pendaftaran Koperasi 2026 Semester 1
Status: Pending Verifikasi
```

---

## 🔒 Keamanan

### Validasi di Controller
- ✅ Cek periode aktif sebelum create
- ✅ Cek kuota sebelum create
- ✅ Hanya 1 periode yang bisa aktif
- ✅ Tanggal selesai harus >= tanggal mulai

### Authorization
- ✅ Hanya admin yang bisa kelola periode
- ✅ Petugas hanya bisa daftar koperasi
- ✅ Activity log untuk semua aksi

---

## 🎉 Keuntungan Sistem

1. **Kontrol Terpusat**: Admin mengontrol kapan pendaftaran dibuka/ditutup
2. **Kuota Terkontrol**: Bisa membatasi jumlah pendaftar per periode
3. **Tracking**: Mudah melihat koperasi yang terdaftar per periode
4. **Fleksibel**: Bisa membuat multiple periode untuk tahun berbeda
5. **User Friendly**: Petugas mendapat notifikasi jelas jika tidak bisa daftar

---

**Dibuat pada**: 16 April 2026  
**Status**: ✅ Backend Selesai, ⏳ Frontend Perlu Dibuat  
**Migration**: ✅ Berhasil dijalankan

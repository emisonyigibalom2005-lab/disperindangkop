# 🎯 Sistem Pendaftaran Anggota oleh Petugas

## 📋 Ringkasan

Sistem ini memungkinkan petugas untuk mendaftarkan anggota koperasi baru melalui dashboard petugas. Pendaftaran hanya bisa dilakukan jika admin sudah membuka periode pendaftaran anggota.

---

## ✨ Fitur Utama

### 1. **Dashboard Petugas**
- ✅ Card "Pendaftaran Anggota Baru" di bagian Aksi Cepat
- ✅ Card "Pendaftaran Koperasi Baru" di bagian Aksi Cepat
- ✅ Klik card → Langsung ke form pendaftaran

### 2. **Validasi Periode**
- ✅ Cek periode pendaftaran aktif
- ✅ Cek kuota pendaftaran
- ✅ Redirect dengan pesan error jika ditutup/penuh

### 3. **Form Pendaftaran**
- ✅ Data pribadi anggota
- ✅ Pilih koperasi (yang sudah diverifikasi)
- ✅ Upload foto KTP & selfie KTP
- ✅ Simpanan pokok & wajib

### 4. **Data Masuk ke Admin**
- ✅ Semua data anggota masuk ke database
- ✅ Admin bisa lihat & verifikasi
- ✅ Activity log tercatat

---

## 📁 File yang Sudah Dibuat

### 1. **Controller Petugas**
```
app/Http/Controllers/Petugas/AnggotaController.php (BARU)
```

**Methods**:
- `index()` - List anggota
- `create()` - Form pendaftaran (cek periode)
- `store()` - Simpan data (validasi periode)
- `show()` - Detail anggota
- `edit()` - Form edit
- `update()` - Update data
- `destroy()` - Hapus data

### 2. **Model Update**
```
app/Models/Anggota.php (UPDATE)
```
- Tambah field: `no_ktp`, `nama_lengkap`, `alamat`, `foto_ktp`, `status_verifikasi`, `status_keanggotaan`, `pekerjaan`, `nama_ibu_kandung`

### 3. **Dashboard Update**
```
resources/views/petugas/dashboard.blade.php (UPDATE)
```
- Tambah section "Aksi Cepat"
- Card "Pendaftaran Anggota Baru"
- Card "Pendaftaran Koperasi Baru"

---

## 🗄️ Field Form Pendaftaran Anggota

### Data Wajib (*)
| Field | Type | Description |
|-------|------|-------------|
| koperasi_id * | select | Pilih koperasi yang sudah diverifikasi |
| no_ktp * | string(16) | Nomor KTP (16 digit, unique) |
| nama_lengkap * | string | Nama lengkap sesuai KTP |
| tempat_lahir * | string | Tempat lahir |
| tanggal_lahir * | date | Tanggal lahir |
| jenis_kelamin * | L/P | Jenis kelamin |
| alamat * | text | Alamat lengkap |

### Data Optional
| Field | Type | Description |
|-------|------|-------------|
| no_hp | string | Nomor HP/WA |
| email | email | Email |
| pekerjaan | string | Pekerjaan |
| pendidikan_terakhir | string | Pendidikan terakhir |
| nama_ibu_kandung | string | Nama ibu kandung |
| simpanan_pokok | numeric | Simpanan pokok (Rp) |
| simpanan_wajib | numeric | Simpanan wajib (Rp) |
| foto_ktp | image | Foto KTP (jpg/png, max 2MB) |
| foto_selfie_ktp | image | Foto selfie dengan KTP (jpg/png, max 2MB) |

### Data Auto-Generated
- `no_anggota` - Format: AG202604XXXX
- `periode_pendaftaran_id` - ID periode aktif
- `tanggal_bergabung` - Tanggal hari ini
- `status_verifikasi` - Default: menunggu_verifikasi
- `status_keanggotaan` - Default: aktif
- `created_by` - ID petugas yang mendaftar

---

## 🎯 Alur Kerja

### 1. **Admin Membuka Periode Pendaftaran Anggota**
```
1. Admin login
2. Menu "Periode Pendaftaran" (yang sudah ada)
3. Buat periode baru atau aktifkan periode
4. Set tanggal mulai & selesai
5. Set kuota (optional)
6. Aktifkan periode
```

### 2. **Petugas Mendaftar Anggota**
```
1. Petugas login
2. Dashboard → Klik card "Pendaftaran Anggota Baru"

SKENARIO A: Periode Aktif
- Form pendaftaran ditampilkan
- Info periode ditampilkan di atas form
- Petugas isi form & submit
- Data tersimpan dengan status "menunggu_verifikasi"

SKENARIO B: Periode Ditutup
- Redirect ke dashboard
- Pesan error: "Pendaftaran anggota baru sedang ditutup"

SKENARIO C: Kuota Penuh
- Redirect ke dashboard
- Pesan error: "Kuota pendaftaran periode ini sudah penuh"
```

### 3. **Admin Verifikasi Anggota**
```
1. Admin login
2. Menu "Data Anggota"
3. Lihat anggota dengan status "menunggu_verifikasi"
4. Klik detail anggota
5. Verifikasi atau tolak
6. Status berubah menjadi "diverifikasi" atau "ditolak"
```

---

## 🔧 Routes yang Perlu Ditambahkan

```php
// routes/web.php

// Petugas - Anggota
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::resource('anggota', AnggotaController::class);
});
```

---

## 📊 Status Anggota

| Status Verifikasi | Keterangan |
|-------------------|------------|
| menunggu_verifikasi | Baru didaftarkan, menunggu verifikasi admin |
| diverifikasi | Sudah diverifikasi admin, anggota aktif |
| ditolak | Ditolak admin, perlu perbaikan data |

| Status Keanggotaan | Keterangan |
|--------------------|------------|
| aktif | Anggota aktif |
| tidak_aktif | Anggota tidak aktif/keluar |

---

## 🎨 Tampilan Dashboard Petugas

### Quick Action Cards
```
┌─────────────────────────────────────┐
│  👤 Pendaftaran Anggota Baru        │
│  Daftarkan anggota koperasi baru    │
│  ke dalam sistem                    │
└─────────────────────────────────────┘

┌─────────────────────────────────────┐
│  🏪 Pendaftaran Koperasi Baru       │
│  Daftarkan koperasi baru ke dalam   │
│  sistem                             │
└─────────────────────────────────────┘
```

### Styling
- **Card Anggota**: Gradient ungu (#8b5cf6 → #7c3aed)
- **Card Koperasi**: Gradient pink (#ec4899 → #db2777)
- **Hover Effect**: translateY(-5px) + shadow
- **Border**: 2px solid transparent → #1a3a6e saat hover

---

## 🔒 Validasi & Keamanan

### Validasi Controller
```php
// Cek periode aktif
$periodeAktif = PeriodePendaftaran::getPeriodeAktif();
if (!$periodeAktif) {
    return redirect()->back()->with('error', 'Pendaftaran ditutup');
}

// Cek kuota
if ($periodeAktif->isKuotaPenuh()) {
    return redirect()->back()->with('error', 'Kuota penuh');
}

// Validasi data
$validated = $request->validate([
    'no_ktp' => 'required|string|size:16|unique:anggotas,no_ktp',
    'nama_lengkap' => 'required|string|max:255',
    // ... dst
]);
```

### Authorization
- ✅ Hanya petugas yang bisa akses
- ✅ Middleware: `auth`, `role:petugas`
- ✅ Activity log semua aksi

### Upload File
- ✅ Validasi: image, mimes:jpeg,jpg,png, max:2048 (2MB)
- ✅ Storage: `storage/anggota/ktp/` dan `storage/anggota/selfie/`
- ✅ Hapus file lama saat update

---

## 📝 Contoh Data

### Anggota Terdaftar
```
No Anggota: AG202604001
Nama: John Doe
No KTP: 9401234567890123
Koperasi: Koperasi Simpan Pinjam Sejahtera
Periode: Pendaftaran Anggota 2026 Semester 1
Status Verifikasi: Menunggu Verifikasi
Status Keanggotaan: Aktif
Didaftarkan oleh: Petugas Dinas (ID: 2)
Tanggal Bergabung: 2026-04-16
```

---

## 🚀 Langkah Implementasi

### 1. ✅ Controller (SELESAI)
- PetugasAnggotaController dengan CRUD lengkap

### 2. ✅ Model (SELESAI)
- Update Anggota dengan field tambahan

### 3. ⏳ Routes (PERLU DITAMBAHKAN)
```php
Route::resource('anggota', AnggotaController::class);
```

### 4. ⏳ Views (PERLU DIBUAT)
- `petugas/anggota/index.blade.php` - List anggota
- `petugas/anggota/create.blade.php` - Form pendaftaran
- `petugas/anggota/show.blade.php` - Detail anggota
- `petugas/anggota/edit.blade.php` - Form edit

### 5. ⏳ Dashboard (PERLU UPDATE)
- Tambah section "Aksi Cepat"
- Tambah card "Pendaftaran Anggota Baru"

### 6. ⏳ Sidebar Menu (PERLU DITAMBAHKAN)
```html
<li class="nav-item">
    <a href="{{ route('petugas.anggota.index') }}" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>Data Anggota</p>
    </a>
</li>
```

---

## 🎉 Keuntungan Sistem

1. **Efisiensi**: Petugas bisa daftar anggota langsung dari dashboard
2. **Kontrol**: Admin tetap kontrol melalui periode pendaftaran
3. **Tracking**: Semua pendaftaran tercatat dengan periode & petugas
4. **Validasi**: Data tervalidasi sebelum masuk database
5. **User Friendly**: Interface yang mudah digunakan

---

## 📸 Screenshot (Konsep)

### Dashboard Petugas
```
┌────────────────────────────────────────────────┐
│  AKSI CEPAT                                    │
├────────────────────────────────────────────────┤
│  [👤 Pendaftaran Anggota]  [🏪 Pendaftaran    │
│   Daftarkan anggota baru    Koperasi Baru]    │
└────────────────────────────────────────────────┘
```

### Form Pendaftaran
```
┌────────────────────────────────────────────────┐
│  PENDAFTARAN ANGGOTA BARU                      │
├────────────────────────────────────────────────┤
│  ℹ️ Periode: Pendaftaran 2026 Semester 1       │
│     Tanggal: 01 Jan - 30 Jun 2026             │
│     Sisa Kuota: 85 dari 100                   │
├────────────────────────────────────────────────┤
│  [Form fields...]                              │
│  - Pilih Koperasi                              │
│  - No KTP                                      │
│  - Nama Lengkap                                │
│  - dst...                                      │
├────────────────────────────────────────────────┤
│  [💾 Simpan Data]  [← Kembali]                │
└────────────────────────────────────────────────┘
```

---

**Dibuat pada**: 16 April 2026  
**Status**: ✅ Backend Selesai, ⏳ Frontend Perlu Dibuat  
**Controller**: ✅ Lengkap dengan validasi periode

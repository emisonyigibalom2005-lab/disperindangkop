# CARA AKTIFKAN TOMBOL HAPUS - REKAP BANTUAN

## 🎯 MASALAH
Dari screenshot terlihat:
- ✅ Lihat Detail (sudah aktif)
- ❌ Tambah Bantuan (belum aktif)
- ❌ Edit Data (belum aktif)
- ❌ Hapus Data (belum aktif)

**Tombol yang tidak diizinkan tidak akan tampil di tabel.**

---

## 📋 LANGKAH-LANGKAH UNTUK ADMIN

### STEP 1: Login sebagai Admin
1. Buka browser
2. Akses aplikasi
3. Login dengan akun **Admin**

### STEP 2: Buka Menu Izin Akses
1. Di sidebar kiri, cari menu **"Izin Akses"**
2. Klik menu tersebut
3. Akan muncul daftar user

### STEP 3: Cari User Pimpinan
1. Cari user dengan role **"Pimpinan"**
2. Lihat kolom **"Aksi"**
3. Klik tombol **"Kelola Izin"** atau **"Edit"**

### STEP 4: Pilih Modul "laporan"
1. Akan muncul form/modal izin akses
2. Cari dropdown atau pilihan **"Modul"**
3. Pilih **"laporan"** dari dropdown

### STEP 5: Centang Semua Permission
Centang **SEMUA** checkbox berikut:

```
☑ Lihat Data (can_view)
☑ Tambah Data (can_create)
☑ Edit Data (can_edit)
☑ Hapus Data (can_delete)      ← PENTING! Ini yang perlu dicentang
☐ Export Data (can_export)      ← Optional
☐ Approve Data (can_approve)    ← Optional
```

**PENTING:** Pastikan checkbox **"Hapus Data"** TERCENTANG!

### STEP 6: Simpan
1. Klik tombol **"Simpan"** atau **"Update"**
2. Tunggu notifikasi sukses
3. Tutup modal/form

### STEP 7: Verifikasi di Database (Optional)
Buka database dan jalankan query:

```sql
SELECT * FROM role_permissions 
WHERE role = 'pimpinan' 
AND module = 'laporan';
```

**Hasil yang diharapkan:**
```
role: pimpinan
module: laporan
can_view: 1
can_create: 1
can_edit: 1
can_delete: 1      ← Harus bernilai 1
can_export: 0 atau 1
can_approve: 0 atau 1
```

---

## 🔄 LANGKAH-LANGKAH UNTUK PIMPINAN

Setelah Admin memberikan izin:

### STEP 1: Logout
1. Klik menu profile/user di pojok kanan atas
2. Klik **"Logout"**

### STEP 2: Login Ulang
1. Login kembali dengan akun **Pimpinan**
2. Masukkan username dan password

### STEP 3: Clear Cache Browser
Tekan tombol keyboard:
- **Windows:** `Ctrl + Shift + Delete`
- **Mac:** `Cmd + Shift + Delete`

Atau refresh paksa:
- **Windows:** `Ctrl + F5`
- **Mac:** `Cmd + Shift + R`

### STEP 4: Buka Halaman Bantuan
1. Klik menu **"Laporan"** di sidebar
2. Klik **"Rekap Bantuan"**
3. URL: `/pimpinan/laporan/bantuan`

### STEP 5: Cek Alert Status
Lihat alert di bagian atas halaman.

**Hasil yang diharapkan:**
```
✅ Status Izin Akses Anda

✓ Lihat Detail      (hijau, tebal)
✓ Tambah Bantuan    (hijau, tebal)
✓ Edit Data         (hijau, tebal)
✓ Hapus Data        (hijau, tebal)  ← Harus hijau!

ℹ️ Tombol yang tidak diizinkan tidak akan tampil di tabel.
```

### STEP 6: Cek Tombol di Tabel
Lihat kolom **"Aksi"** di tabel.

**Hasil yang diharapkan:**
```
[👁️] [✏️] [🗑️]
```

Semua 3 tombol harus muncul:
- 👁️ = Detail (biru)
- ✏️ = Edit (kuning)
- 🗑️ = Hapus (merah)

### STEP 7: Test Tombol Hapus
1. Klik tombol **Hapus** (icon tempat sampah merah)
2. **Hasil yang diharapkan:**
   - Muncul popup SweetAlert
   - Judul: "Hapus Program Bantuan?"
   - Text: "Data program bantuan akan dihapus permanen dari sistem!"
   - Ada 2 tombol: "Ya, Hapus!" dan "Batal"

3. Klik **"Batal"** untuk test (jangan hapus data asli)

---

## 🔍 TROUBLESHOOTING

### Problem 1: Checkbox "Hapus Data" Tidak Ada
**Solusi:**
1. Pastikan menggunakan modul **"laporan"** (bukan modul lain)
2. Cek apakah form izin akses sudah update
3. Refresh halaman admin

### Problem 2: Sudah Centang Tapi Masih ✗
**Solusi:**
1. Pastikan sudah klik tombol **"Simpan"**
2. Tunggu notifikasi sukses
3. Logout dan login ulang sebagai Pimpinan
4. Clear cache browser (Ctrl+F5)

### Problem 3: Tombol Hapus Masih Tidak Muncul
**Solusi:**
1. Cek log file: `storage/logs/laravel.log`
2. Cari baris: `Bantuan Page - can_delete`
3. Jika masih `NO`, berarti permission belum tersimpan
4. Set ulang dari Admin

### Problem 4: Error Saat Klik Hapus
**Solusi:**
1. Cek apakah program bantuan sudah memiliki penerima
2. Program yang sudah ada penerima **TIDAK BISA DIHAPUS**
3. Pesan error: "Program bantuan tidak dapat dihapus karena sudah memiliki penerima."

---

## 🗄️ MANUAL FIX VIA DATABASE (Jika Diperlukan)

Jika cara di atas tidak berhasil, bisa set manual via database:

### Query 1: Cek Permission Saat Ini
```sql
SELECT * FROM role_permissions 
WHERE role = 'pimpinan' AND module = 'laporan';
```

### Query 2: Update Permission (Jika Sudah Ada)
```sql
UPDATE role_permissions 
SET can_view = 1,
    can_create = 1,
    can_edit = 1,
    can_delete = 1,
    updated_at = NOW()
WHERE role = 'pimpinan' 
AND module = 'laporan';
```

### Query 3: Insert Permission (Jika Belum Ada)
```sql
INSERT INTO role_permissions 
(role, module, can_view, can_create, can_edit, can_delete, can_export, can_approve, created_at, updated_at)
VALUES 
('pimpinan', 'laporan', 1, 1, 1, 1, 0, 0, NOW(), NOW());
```

### Query 4: Verifikasi
```sql
SELECT 
    role,
    module,
    can_view,
    can_create,
    can_edit,
    can_delete
FROM role_permissions 
WHERE role = 'pimpinan' AND module = 'laporan';
```

**Hasil yang diharapkan:**
```
role       | module  | can_view | can_create | can_edit | can_delete
-----------|---------|----------|------------|----------|------------
pimpinan   | laporan | 1        | 1          | 1        | 1
```

Setelah update database, jalankan:
```bash
php artisan optimize:clear
```

---

## ✅ CHECKLIST FINAL

Sebelum menghubungi support, pastikan:

**Untuk Admin:**
- [ ] Sudah login sebagai Admin
- [ ] Sudah buka menu Izin Akses
- [ ] Sudah pilih user Pimpinan
- [ ] Sudah pilih modul "laporan"
- [ ] Sudah centang checkbox "Hapus Data"
- [ ] Sudah klik tombol "Simpan"
- [ ] Sudah lihat notifikasi sukses

**Untuk Pimpinan:**
- [ ] Sudah logout dan login ulang
- [ ] Sudah clear cache browser (Ctrl+F5)
- [ ] Sudah buka halaman `/pimpinan/laporan/bantuan`
- [ ] Sudah cek alert status (harus ada ✓ hijau untuk Hapus Data)
- [ ] Sudah cek tombol di tabel (harus ada icon tempat sampah merah)
- [ ] Sudah test klik tombol hapus (harus muncul popup konfirmasi)

---

## 🎉 HASIL AKHIR YANG DIHARAPKAN

### Alert Status:
```
🛡️ Status Izin Akses Anda

✓ Lihat Detail      (hijau, tebal)
✓ Tambah Bantuan    (hijau, tebal)
✓ Edit Data         (hijau, tebal)
✓ Hapus Data        (hijau, tebal)  ← HARUS HIJAU!
```

### Tombol di Header:
```
[+ Tambah Program]  ← Tombol biru
```

### Tombol di Tabel:
```
[👁️ Detail] [✏️ Edit] [🗑️ Hapus]  ← Semua 3 tombol muncul
```

### Fungsi Hapus:
1. Klik tombol Hapus
2. Popup konfirmasi muncul
3. Klik "Ya, Hapus!"
4. Data terhapus
5. Halaman refresh otomatis
6. Notifikasi sukses muncul

---

**Dokumentasi dibuat:** {{ date('d F Y, H:i') }}
**Status:** ✅ PANDUAN LENGKAP AKTIFKAN HAPUS

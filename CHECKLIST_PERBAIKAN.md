# ✅ Checklist Perbaikan - Kartu & Sertifikat

## 🎯 Langkah-Langkah yang Harus Dilakukan

### 1. Clear Cache Laravel (WAJIB!)

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

**Status:** [ ] Selesai

---

### 2. Test Akses Halaman

**URL:** `http://127.0.0.1:8000/admin/kartu-sertifikat`

**Checklist:**
- [ ] Halaman load tanpa error
- [ ] Tidak ada error Ignition
- [ ] Header "Kartu & Sertifikat" terlihat
- [ ] Kedua tab (Anggota & Koperasi) terlihat

---

### 3. Test Tab Anggota

**Checklist:**
- [ ] Tab "Anggota" aktif secara default
- [ ] Daftar anggota ditampilkan dalam bentuk kartu
- [ ] Setiap kartu menampilkan:
  - [ ] Nama anggota
  - [ ] No. Anggota
  - [ ] NIK
  - [ ] Distrik
  - [ ] Nama Koperasi (atau "-" jika tidak ada)
  - [ ] Status (Aktif/Pending)
  - [ ] 3 tombol download (Kartu, Sertifikat, Dokumen)

---

### 4. Test Pencarian Anggota

**Checklist:**
- [ ] Input pencarian terlihat
- [ ] Masukkan nama anggota → Klik "Cari"
- [ ] Hasil pencarian sesuai
- [ ] Klik "Reset" → Filter dihapus
- [ ] Masukkan no. anggota → Klik "Cari"
- [ ] Hasil pencarian sesuai

---

### 5. Test Download Anggota

**Pilih salah satu anggota, lalu test:**

**Kartu Anggota:**
- [ ] Klik tombol "Kartu" (biru)
- [ ] File PDF terdownload
- [ ] Nama file: `Kartu_Anggota_[Nama].pdf`
- [ ] Ukuran kartu: 85.6mm x 53.98mm (ukuran kartu standar)
- [ ] Isi kartu lengkap (foto, nama, no. anggota, dll)

**Sertifikat:**
- [ ] Klik tombol "Sertifikat" (oranye)
- [ ] File PDF terdownload
- [ ] Nama file: `Sertifikat_[Nama].pdf`
- [ ] Ukuran: A4 Landscape
- [ ] Isi sertifikat lengkap

**Dokumen Word:**
- [ ] Klik tombol "Dokumen" (hijau)
- [ ] File Word terdownload
- [ ] Nama file: `Dokumen_Anggota_[Nama]_[No_Anggota].doc`
- [ ] Isi dokumen lengkap dengan semua data anggota

---

### 6. Test Tab Koperasi

**Checklist:**
- [ ] Klik tab "Koperasi"
- [ ] Konten berubah ke daftar koperasi
- [ ] Tab "Koperasi" menjadi aktif (warna gradient)
- [ ] Daftar koperasi ditampilkan dalam bentuk kartu
- [ ] Setiap kartu menampilkan:
  - [ ] Nama koperasi
  - [ ] No. Registrasi
  - [ ] Nama pemilik
  - [ ] Jenis usaha
  - [ ] Distrik
  - [ ] Status (Aktif/Pending)
  - [ ] 3 tombol download (Kartu, Sertifikat, Dokumen)

---

### 7. Test Pencarian Koperasi

**Checklist:**
- [ ] Input pencarian terlihat
- [ ] Masukkan nama koperasi → Klik "Cari"
- [ ] Hasil pencarian sesuai
- [ ] Tetap di tab Koperasi setelah search
- [ ] Klik "Reset" → Filter dihapus
- [ ] Masukkan no. registrasi → Klik "Cari"
- [ ] Hasil pencarian sesuai

---

### 8. Test Download Koperasi

**Pilih salah satu koperasi, lalu test:**

**Kartu Koperasi:**
- [ ] Klik tombol "Kartu" (biru)
- [ ] File PDF terdownload
- [ ] Nama file: `Kartu_Koperasi_[Nama].pdf`
- [ ] Isi kartu lengkap

**Sertifikat:**
- [ ] Klik tombol "Sertifikat" (oranye)
- [ ] File PDF terdownload
- [ ] Nama file: `Sertifikat_Koperasi_[Nama].pdf`
- [ ] Isi sertifikat lengkap

**Dokumen Word:**
- [ ] Klik tombol "Dokumen" (hijau)
- [ ] File Word terdownload
- [ ] Nama file: `Dokumen_Koperasi_[Nama]_[No_Registrasi].doc`
- [ ] Isi dokumen lengkap dengan semua data koperasi

---

### 9. Test Pagination (Jika Ada)

**Tab Anggota:**
- [ ] Jika data > 12 item, pagination muncul
- [ ] Klik halaman berikutnya
- [ ] Data berubah sesuai halaman
- [ ] Filter pencarian tetap aktif
- [ ] Tetap di tab Anggota

**Tab Koperasi:**
- [ ] Pindah ke tab Koperasi
- [ ] Jika data > 12 item, pagination muncul
- [ ] Klik halaman berikutnya
- [ ] Data berubah sesuai halaman
- [ ] Filter pencarian tetap aktif
- [ ] Tetap di tab Koperasi

---

### 10. Test Empty State

**Jika tidak ada data:**
- [ ] Pesan "Belum Ada Data Anggota" muncul (untuk tab Anggota)
- [ ] Pesan "Belum Ada Data Koperasi" muncul (untuk tab Koperasi)
- [ ] Icon dan pesan terlihat dengan jelas
- [ ] Tidak ada error

---

### 11. Test Responsiveness

**Desktop:**
- [ ] Layout rapi di layar besar
- [ ] Kartu tersusun dalam grid 3-4 kolom

**Tablet:**
- [ ] Layout menyesuaikan di layar sedang
- [ ] Kartu tersusun dalam grid 2 kolom

**Mobile:**
- [ ] Layout menyesuaikan di layar kecil
- [ ] Kartu tersusun dalam 1 kolom
- [ ] Tombol download tetap terlihat

---

### 12. Test Browser Compatibility

**Chrome:**
- [ ] Halaman load dengan baik
- [ ] Semua fitur berfungsi

**Firefox:**
- [ ] Halaman load dengan baik
- [ ] Semua fitur berfungsi

**Edge:**
- [ ] Halaman load dengan baik
- [ ] Semua fitur berfungsi

---

### 13. Test Error Handling

**Test 1: Akses tanpa login**
- [ ] Redirect ke halaman login

**Test 2: Akses dengan role bukan admin**
- [ ] Mendapat error 403 atau redirect

**Test 3: Download dengan ID tidak valid**
- [ ] Mendapat error 404 atau pesan error yang jelas

---

### 14. Verifikasi File yang Diubah

**Controller:**
- [ ] `app/Http/Controllers/Admin/AnggotaController.php` sudah diupdate
- [ ] Method `kartuSertifikatList()` memiliki try-catch

**View:**
- [ ] `resources/views/admin/anggota/kartu-sertifikat-list.blade.php` sudah diupdate
- [ ] Menggunakan `optional()` helper untuk relasi koperasi
- [ ] JavaScript sudah diperbaiki

**View Dokumen:**
- [ ] `resources/views/admin/anggota/dokumen.blade.php` sudah diupdate
- [ ] Menggunakan `optional()` helper untuk relasi koperasi

---

### 15. Verifikasi Routes

**Check di `routes/web.php`:**
- [ ] Route `admin.kartu-sertifikat` ada
- [ ] Route `admin.anggota.download-kartu` ada
- [ ] Route `admin.anggota.download-sertifikat` ada
- [ ] Route `admin.anggota.download-dokumen` ada
- [ ] Route `admin.koperasi.download-kartu` ada
- [ ] Route `admin.koperasi.download-sertifikat` ada
- [ ] Route `admin.koperasi.download-dokumen` ada

---

## 🎉 Hasil Akhir

**Jika semua checklist di atas sudah ✅:**

### ✅ Fitur Berhasil Diperbaiki!

**Yang Berfungsi:**
- ✅ Halaman load tanpa error
- ✅ Tab switching berfungsi sempurna
- ✅ Pencarian anggota dan koperasi berfungsi
- ✅ Download semua jenis dokumen berfungsi
- ✅ Pagination mempertahankan filter
- ✅ Error handling yang proper
- ✅ User experience yang baik

---

## 🚨 Jika Ada yang Gagal

### Troubleshooting

**Halaman masih error:**
1. Clear cache lagi
2. Restart server: `php artisan serve`
3. Clear browser cache
4. Check log: `storage/logs/laravel.log`

**Tab tidak berpindah:**
1. Buka Developer Tools (F12)
2. Check Console untuk JavaScript error
3. Pastikan jQuery loaded (jika digunakan)

**Download tidak berfungsi:**
1. Check routes dengan: `php artisan route:list | grep download`
2. Pastikan controller method ada
3. Check permission folder storage

**Pagination tidak mempertahankan filter:**
1. Pastikan menggunakan `appends()` di view
2. Check query string di URL

---

## 📞 Bantuan

**Jika masih ada masalah:**
1. Lihat file `SOLUSI_ERROR_IGNITION.md` untuk detail lengkap
2. Lihat file `PERBAIKAN_KARTU_SERTIFIKAT.md` untuk dokumentasi teknis
3. Check log file di `storage/logs/laravel.log`

---

**Tanggal:** 16 April 2026  
**Status:** Ready for Testing ✅

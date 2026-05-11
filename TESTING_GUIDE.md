# 🧪 PANDUAN TESTING - Kartu & Sertifikat

## ✅ Semua Template Sudah Siap!

Dokumen ini berisi panduan lengkap untuk testing semua fitur kartu dan sertifikat.

---

## 🚀 PERSIAPAN TESTING

### Step 1: Clear Cache (WAJIB!)
```bash
php artisan view:clear
php artisan cache:clear
php artisan config:clear
```

### Step 2: Pastikan Server Running
```bash
php artisan serve
```

### Step 3: Login sebagai Admin
```
URL: http://127.0.0.1:8000/login
Username: admin@example.com (atau sesuai data Anda)
Password: (password admin Anda)
```

---

## 📋 CHECKLIST TESTING

### ✅ 1. AKSES HALAMAN KARTU & SERTIFIKAT

**URL:** `http://127.0.0.1:8000/admin/kartu-sertifikat`

**Yang Harus Dicek:**
- [ ] Halaman terbuka tanpa error
- [ ] Ada 2 tab: "Anggota" dan "Koperasi"
- [ ] Tab Anggota menampilkan list anggota
- [ ] Tab Koperasi menampilkan list koperasi
- [ ] Search box berfungsi
- [ ] Pagination berfungsi

**Jika Error:**
- Clear cache lagi
- Cek file log: `storage/logs/laravel.log`
- Pastikan route ada di `routes/web.php`

---

### ✅ 2. TESTING KARTU ANGGOTA

**Langkah:**
1. Buka tab "Anggota"
2. Pilih salah satu anggota
3. Klik tombol **"Kartu"** (biru)

**Yang Harus Dicek:**
- [ ] PDF ter-download otomatis
- [ ] Nama file: `Kartu_Anggota_[Nama].pdf`
- [ ] Ukuran kartu: 85.6mm x 53.98mm (landscape)
- [ ] **2 Logo** muncul di header (kiri & kanan)
- [ ] Header: "KABUPATEN TOLIKARA" + "KARTU ANGGOTA KOPERASI"
- [ ] **Foto anggota** muncul di kiri (jika ada)
- [ ] Data lengkap di kanan:
  - NIK
  - Nama (UPPERCASE)
  - Tempat/Tgl Lahir
  - Jenis Kelamin
  - Alamat
  - Distrik
  - Koperasi
- [ ] Footer: No. Anggota + Masa berlaku
- [ ] Background gradient biru
- [ ] Layout seperti KTP

**Jika Logo Tidak Muncul:**
- Logo menggunakan SVG inline, seharusnya selalu muncul
- Cek browser PDF viewer (coba buka dengan Adobe Reader)

**Jika Foto Tidak Muncul:**
- Pastikan anggota punya foto
- Cek path foto di database
- Cek folder `storage/app/public/anggota/`

---

### ✅ 3. TESTING SERTIFIKAT ANGGOTA

**Langkah:**
1. Buka tab "Anggota"
2. Pilih salah satu anggota
3. Klik tombol **"Sertifikat"** (oranye)

**Yang Harus Dicek:**
- [ ] PDF ter-download otomatis
- [ ] Nama file: `Sertifikat_[Nama].pdf`
- [ ] Ukuran: A4 Portrait (210mm x 297mm)
- [ ] **Kop surat** dengan 2 logo (70px) di atas
- [ ] Header lengkap:
  - PEMERINTAH KABUPATEN TOLIKARA
  - DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI
  - Alamat lengkap
  - Email & Telepon
- [ ] Border emas tebal (8px)
- [ ] Border dalam biru (3px)
- [ ] Judul "SERTIFIKAT" besar (42pt)
- [ ] Subtitle "Keanggotaan Koperasi"
- [ ] Nama penerima warna emas italic (28pt)
- [ ] Detail box dengan data lengkap:
  - No. Anggota
  - NIK
  - Tempat, Tanggal Lahir
  - Alamat
  - Koperasi
- [ ] **Medali emas** di tengah
- [ ] 2 kolom tanda tangan (Ketua & Kepala Dinas)
- [ ] Watermark "KOPERASI" di background
- [ ] Tanggal cetak
- [ ] **SEMUA DALAM 1 HALAMAN**

**Jika Multi Halaman:**
- Cek ukuran font (mungkin terlalu besar)
- Cek padding/margin
- Pastikan `setPaper('a4', 'portrait')` di controller

---

### ✅ 4. TESTING DOKUMEN WORD ANGGOTA

**Langkah:**
1. Buka tab "Anggota"
2. Pilih salah satu anggota
3. Klik tombol **"Dokumen"** (hijau)

**Yang Harus Dicek:**
- [ ] File .doc ter-download otomatis
- [ ] Nama file: `Dokumen_Anggota_[Nama]_[No_Anggota].doc`
- [ ] Bisa dibuka di Microsoft Word
- [ ] **Kop surat** dengan logo (80px)
- [ ] Header lengkap instansi
- [ ] Foto anggota (jika ada)
- [ ] Badge status berwarna
- [ ] 7 Bagian data lengkap:
  1. Data Pribadi
  2. Informasi Kontak
  3. Alamat
  4. Data Usaha
  5. Data Keuangan & Perbankan
  6. Data Ahli Waris
  7. Status Keanggotaan
- [ ] Tanda tangan Ketua Koperasi
- [ ] Tanggal cetak
- [ ] Format rapi dan terstruktur

**Jika Tidak Bisa Dibuka:**
- Coba buka dengan LibreOffice atau Google Docs
- Format .doc kompatibel dengan semua word processor

---

### ✅ 5. TESTING KARTU KOPERASI

**Langkah:**
1. Buka tab "Koperasi"
2. Pilih salah satu koperasi
3. Klik tombol **"Kartu"** (biru)

**Yang Harus Dicek:**
- [ ] PDF ter-download otomatis
- [ ] Nama file: `Kartu_Koperasi_[Nama_Usaha].pdf`
- [ ] Ukuran kartu: 85.6mm x 53.98mm (landscape)
- [ ] **2 Logo** muncul di header (kiri & kanan)
- [ ] Header: "KABUPATEN TOLIKARA" + "KARTU KOPERASI"
- [ ] Data lengkap:
  - No. Registrasi
  - Nama Koperasi (UPPERCASE)
  - Pemilik (UPPERCASE)
  - No. KTP
  - Jenis Usaha
  - Kategori
  - Alamat
  - Distrik
  - No. Telp
- [ ] Footer: Status + Masa berlaku
- [ ] Background gradient hijau
- [ ] Layout rapi seperti kartu identitas

---

### ✅ 6. TESTING SERTIFIKAT KOPERASI

**Langkah:**
1. Buka tab "Koperasi"
2. Pilih salah satu koperasi
3. Klik tombol **"Sertifikat"** (oranye)

**Yang Harus Dicek:**
- [ ] PDF ter-download otomatis
- [ ] Nama file: `Sertifikat_Koperasi_[Nama_Usaha].pdf`
- [ ] Ukuran: A4 Portrait (210mm x 297mm)
- [ ] **Kop surat** dengan 2 logo (70px)
- [ ] Header lengkap sama dengan sertifikat anggota
- [ ] Border emas (8px) + hijau (3px)
- [ ] Judul "SERTIFIKAT" besar (42pt)
- [ ] Subtitle "Registrasi Koperasi"
- [ ] Nama koperasi warna emas italic (28pt)
- [ ] Detail box dengan data lengkap:
  - No. Registrasi
  - Pemilik
  - Jenis Usaha
  - Kategori
  - Alamat
- [ ] **Medali emas** di tengah
- [ ] 2 kolom tanda tangan (Pemilik & Kepala Dinas)
- [ ] Watermark "KOPERASI"
- [ ] Tanggal cetak
- [ ] **SEMUA DALAM 1 HALAMAN**

---

### ✅ 7. TESTING DOKUMEN WORD KOPERASI

**Langkah:**
1. Buka tab "Koperasi"
2. Pilih salah satu koperasi
3. Klik tombol **"Dokumen"** (hijau)

**Yang Harus Dicek:**
- [ ] File .doc ter-download otomatis
- [ ] Nama file: `Dokumen_Koperasi_[Nama_Usaha]_[No_Registrasi].doc`
- [ ] Bisa dibuka di Microsoft Word
- [ ] **Kop surat** dengan logo (80px)
- [ ] Header lengkap instansi
- [ ] Badge status berwarna
- [ ] 5 Bagian data lengkap:
  1. Data Registrasi
  2. Data Pemilik
  3. Alamat Usaha
  4. Data Usaha
  5. Status Verifikasi
- [ ] Tanda tangan Kepala Dinas
- [ ] Tanggal cetak
- [ ] Format rapi dan terstruktur

---

## 🎨 TESTING VISUAL

### Kartu (KTP Style):
**Cek:**
- [ ] Logo jelas dan tidak pecah
- [ ] Foto proporsional (tidak stretched)
- [ ] Text tidak terpotong
- [ ] Warna gradient menarik
- [ ] Border dan shadow terlihat
- [ ] Ukuran sesuai kartu standar

### Sertifikat (1 Halaman):
**Cek:**
- [ ] Logo di kop surat jelas
- [ ] Border emas terlihat tebal
- [ ] Border dalam berwarna terlihat
- [ ] Medali emas di tengah
- [ ] Watermark tidak mengganggu text
- [ ] Typography profesional
- [ ] Semua dalam 1 halaman (tidak terpotong)

### Dokumen Word:
**Cek:**
- [ ] Logo di kop surat jelas
- [ ] Badge status berwarna
- [ ] Table rapi dan terstruktur
- [ ] Section title dengan background warna
- [ ] Spacing antar section cukup
- [ ] Bisa diedit di Word

---

## 🖨️ TESTING CETAK

### Kartu:
1. Buka PDF kartu
2. Print preview
3. **Cek:**
   - [ ] Ukuran: 85.6mm x 53.98mm
   - [ ] Orientation: Landscape
   - [ ] Warna tercetak dengan baik
   - [ ] Logo tidak pecah
   - [ ] Text jelas terbaca

### Sertifikat:
1. Buka PDF sertifikat
2. Print preview
3. **Cek:**
   - [ ] Ukuran: A4 (210mm x 297mm)
   - [ ] Orientation: Portrait
   - [ ] Border emas tercetak
   - [ ] Warna gradient tercetak
   - [ ] Semua dalam 1 halaman
   - [ ] Tidak ada yang terpotong

### Dokumen Word:
1. Buka file .doc
2. Print preview
3. **Cek:**
   - [ ] Format tetap rapi
   - [ ] Logo tercetak
   - [ ] Badge warna tercetak
   - [ ] Table tidak pecah antar halaman

---

## 🔧 TROUBLESHOOTING

### Error: "Class 'Barryvdh\DomPDF\Facade\Pdf' not found"
**Solusi:**
```bash
composer require barryvdh/laravel-dompdf
php artisan config:clear
```

### Error: "View not found"
**Solusi:**
```bash
php artisan view:clear
# Pastikan file blade ada di folder yang benar
```

### Logo Tidak Muncul di PDF
**Solusi:**
- Logo menggunakan SVG inline, seharusnya selalu muncul
- Coba buka PDF dengan Adobe Reader
- Cek apakah SVG code ada di template

### Foto Tidak Muncul di Kartu
**Solusi:**
```bash
# Pastikan storage link ada
php artisan storage:link

# Cek permission folder
chmod -R 775 storage/app/public
```

### Sertifikat Multi Halaman
**Solusi:**
- Cek controller: `setPaper('a4', 'portrait')`
- Kurangi font size jika perlu
- Kurangi padding/margin

### Download Tidak Jalan
**Solusi:**
- Clear browser cache
- Coba browser lain
- Cek browser setting (allow downloads)
- Cek file log: `storage/logs/laravel.log`

---

## 📊 TESTING MATRIX

| No | Fitur | Anggota | Koperasi | Status |
|----|-------|---------|----------|--------|
| 1 | Kartu PDF | ✅ | ✅ | Ready |
| 2 | Sertifikat PDF | ✅ | ✅ | Ready |
| 3 | Dokumen Word | ✅ | ✅ | Ready |
| 4 | Logo 2x | ✅ | ✅ | Ready |
| 5 | Kop Surat | ✅ | ✅ | Ready |
| 6 | Border Emas | ✅ | ✅ | Ready |
| 7 | Medali | ✅ | ✅ | Ready |
| 8 | Watermark | ✅ | ✅ | Ready |
| 9 | 1 Halaman | ✅ | ✅ | Ready |
| 10 | KTP Style | ✅ | ✅ | Ready |

---

## ✅ HASIL TESTING

### Jika Semua Berhasil:
- ✅ Semua dokumen ter-download dengan baik
- ✅ Logo muncul di semua dokumen
- ✅ Kartu seperti KTP
- ✅ Sertifikat dalam 1 halaman
- ✅ Dokumen Word bisa dibuka dan diedit
- ✅ Desain profesional dan menarik
- ✅ Siap untuk production!

### Jika Ada Masalah:
1. Catat error message
2. Cek file log: `storage/logs/laravel.log`
3. Clear cache dan coba lagi
4. Cek dokumentasi troubleshooting di atas
5. Pastikan semua package terinstall

---

## 📝 CATATAN TESTING

### Browser yang Direkomendasikan:
- ✅ Google Chrome (terbaik)
- ✅ Mozilla Firefox
- ✅ Microsoft Edge
- ⚠️ Safari (kadang ada issue dengan download)

### PDF Viewer yang Direkomendasikan:
- ✅ Adobe Acrobat Reader (terbaik)
- ✅ Browser built-in PDF viewer
- ✅ Foxit Reader
- ⚠️ Preview (Mac) - kadang warna tidak akurat

### Word Processor yang Direkomendasikan:
- ✅ Microsoft Word (terbaik)
- ✅ LibreOffice Writer
- ✅ Google Docs
- ✅ WPS Office

---

## 🎯 TESTING CHECKLIST FINAL

Sebelum deploy ke production, pastikan:

- [ ] Semua 6 jenis dokumen bisa di-download
- [ ] Logo muncul di semua dokumen
- [ ] Kartu ukuran standar (85.6mm x 53.98mm)
- [ ] Sertifikat dalam 1 halaman A4 Portrait
- [ ] Dokumen Word bisa dibuka dan diedit
- [ ] Foto anggota muncul (jika ada)
- [ ] Data lengkap dan akurat
- [ ] Desain profesional
- [ ] Tidak ada error di log
- [ ] Cache sudah di-clear
- [ ] Testing di berbagai browser
- [ ] Testing cetak (print preview)

---

## 🎉 SELESAI!

Jika semua checklist di atas ✅, maka:

**🌟 SISTEM SIAP DIGUNAKAN! 🌟**

---

**Tanggal:** 16 April 2026  
**Versi:** 4.0 FINAL  
**Status:** ✅ READY FOR TESTING  
**Tester:** Admin Koperasi Tolikara

---

**Selamat Testing! Semoga Sukses! 🚀**

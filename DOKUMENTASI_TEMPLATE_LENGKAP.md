# 📄 Dokumentasi Template Kartu, Sertifikat & Dokumen

## ✨ Pembaruan Template

Semua template telah diperbarui dengan **logo, data lengkap, dan desain yang lebih rapi dan profesional**.

---

## 🎨 Fitur Baru yang Ditambahkan

### 1. **Logo Resmi**
- ✅ Logo Pemerintah Kabupaten Tolikara
- ✅ Logo Dinas Perindustrian, Perdagangan & Koperasi
- ✅ Desain logo dengan SVG (scalable, tidak pecah saat dicetak)
- ✅ Warna logo sesuai identitas:
  - **Anggota**: Biru (#1e3a8a, #3b82f6) dengan bintang emas
  - **Koperasi**: Hijau (#059669, #10b981) dengan kotak emas

### 2. **Kop Surat Resmi**
- ✅ Header dengan logo dan nama instansi
- ✅ Alamat lengkap
- ✅ Email dan nomor telepon
- ✅ Border ganda untuk kesan formal

### 3. **Data Lengkap**
- ✅ Semua field data ditampilkan
- ✅ Format yang rapi dan terstruktur
- ✅ Badge status dengan warna (Aktif, Pending, Ditolak)
- ✅ Nomor dokumen unik
- ✅ Tanggal cetak dengan timestamp

### 4. **Desain Profesional**
- ✅ Gradient background yang elegan
- ✅ Border dan frame yang rapi
- ✅ Watermark "KOPERASI" di sertifikat
- ✅ Stempel "SAH VERIFIED" di sertifikat
- ✅ QR code placeholder di kartu
- ✅ Shadow dan efek 3D

---

## 📋 Detail Template

### A. KARTU ANGGOTA

**File:** `resources/views/admin/anggota/kartu-sertifikat.blade.php` (type='kartu')

**Ukuran:** 85.6mm x 53.98mm (ukuran kartu standar)

**Fitur:**
- ✅ Logo Dinas di header
- ✅ Gradient biru (#1e3a8a → #3b82f6)
- ✅ Foto anggota (70x90px)
- ✅ Data lengkap:
  - Nama
  - NIK
  - Tempat Lahir
  - Tanggal Lahir
  - Distrik
  - Nama Koperasi
  - No. Anggota
- ✅ Masa berlaku (5 tahun)
- ✅ QR code placeholder
- ✅ Pattern background

**Warna:**
- Primary: #1e3a8a (Biru Tua)
- Secondary: #3b82f6 (Biru Cerah)
- Accent: #fbbf24 (Emas)

---

### B. SERTIFIKAT ANGGOTA

**File:** `resources/views/admin/anggota/kartu-sertifikat.blade.php` (type='sertifikat')

**Ukuran:** A4 Landscape (297mm x 210mm)

**Fitur:**
- ✅ Logo Dinas besar di header
- ✅ Kop surat lengkap:
  - PEMERINTAH KABUPATEN TOLIKARA
  - Dinas Perindustrian, Perdagangan dan Koperasi
  - Papua Pegunungan, Indonesia
- ✅ Judul "SERTIFIKAT" besar dan bold
- ✅ Subtitle "Keanggotaan Koperasi"
- ✅ Nama anggota (underline, bold, besar)
- ✅ Detail box dengan data:
  - No. Anggota
  - NIK
  - Tempat, Tanggal Lahir
  - Alamat
  - Koperasi
- ✅ Teks keterangan resmi
- ✅ Tanda tangan:
  - Ketua Koperasi (kiri)
  - Kepala Dinas (kanan)
- ✅ Border ganda (outer + inner)
- ✅ Watermark "KOPERASI" (45 derajat, opacity rendah)
- ✅ Stempel "SAH VERIFIED" (merah, rotasi -15 derajat)

**Warna:**
- Primary: #1e3a8a (Biru Tua)
- Secondary: #3b82f6 (Biru Cerah)
- Accent: #fbbf24 (Emas)
- Stamp: #dc2626 (Merah)

---

### C. DOKUMEN WORD ANGGOTA

**File:** `resources/views/admin/anggota/dokumen-word.blade.php`

**Format:** Word Document (.doc)

**Fitur:**
- ✅ Kop surat resmi dengan logo
- ✅ Header dokumen:
  - Judul "DOKUMEN DATA ANGGOTA KOPERASI"
  - No. Dokumen: DOK/[No_Anggota]/[Tahun]
  - Tanggal cetak dengan timestamp
- ✅ Info box status (badge warna)
- ✅ Foto anggota (jika ada)
- ✅ 7 Bagian data lengkap:
  1. **DATA PRIBADI**
     - No. Anggota, NIK, Nama, TTL, Umur
     - Jenis Kelamin, Agama, Status Perkawinan
     - Pendidikan Terakhir
  
  2. **INFORMASI KONTAK**
     - No. HP/WhatsApp
     - Email
  
  3. **ALAMAT**
     - Desa, Distrik, Kabupaten, Kode Pos
     - Alamat Lengkap
     - Nama Komplek/Dekat Desa
     - Koordinat GPS
     - Status Kepemilikan Rumah
  
  4. **DATA USAHA**
     - Nama Usaha, Bidang Usaha
     - Lama Berdiri, Jumlah Karyawan
     - Alamat Tempat Usaha, Legalitas
     - Modal Usaha, Omzet per Bulan
     - Keterangan Usaha
  
  5. **DATA KEUANGAN & PERBANKAN**
     - Simpanan Pokok, Simpanan Wajib, Total Simpanan
     - Nama Bank, Nomor Rekening
     - Nama Pemilik Rekening, NPWP
  
  6. **DATA AHLI WARIS**
     - Nama, Hubungan, NIK, No. HP
  
  7. **STATUS KEANGGOTAAN**
     - Status (badge warna)
     - Tanggal Bergabung, Tanggal Verifikasi
     - Koperasi, Periode Pendaftaran
     - Catatan Admin (jika ada)

- ✅ Footer dengan tanda tangan Ketua Koperasi
- ✅ Catatan kaki (timestamp cetak)

**Warna:**
- Primary: #1e3a8a (Biru Tua)
- Secondary: #3b82f6 (Biru Cerah)
- Accent: #fbbf24 (Emas)

---

### D. KARTU KOPERASI

**File:** `resources/views/admin/koperasi/kartu-sertifikat.blade.php` (type='kartu')

**Ukuran:** 85.6mm x 53.98mm (ukuran kartu standar)

**Fitur:**
- ✅ Logo Dinas di header
- ✅ Gradient hijau (#059669 → #10b981)
- ✅ Data lengkap:
  - Nama Koperasi
  - No. Registrasi
  - Pemilik
  - No. KTP
  - Jenis Usaha
  - Kategori
  - Distrik
  - No. Telp
- ✅ Badge status (Aktif/Nonaktif)
- ✅ Masa berlaku (5 tahun)
- ✅ QR code placeholder
- ✅ Pattern background

**Warna:**
- Primary: #059669 (Hijau Tua)
- Secondary: #10b981 (Hijau Cerah)
- Accent: #fbbf24 (Emas)

---

### E. SERTIFIKAT KOPERASI

**File:** `resources/views/admin/koperasi/kartu-sertifikat.blade.php` (type='sertifikat')

**Ukuran:** A4 Landscape (297mm x 210mm)

**Fitur:**
- ✅ Logo Dinas besar di header
- ✅ Kop surat lengkap
- ✅ Judul "SERTIFIKAT" besar dan bold
- ✅ Subtitle "Registrasi Koperasi"
- ✅ Nama koperasi (underline, bold, besar)
- ✅ Detail box dengan data:
  - No. Registrasi
  - Pemilik
  - Jenis Usaha
  - Kategori
  - Alamat
  - Status
- ✅ Teks keterangan resmi
- ✅ Tanda tangan:
  - Pemilik Koperasi (kiri)
  - Kepala Dinas (kanan)
- ✅ Border ganda (outer + inner)
- ✅ Watermark "KOPERASI"
- ✅ Stempel "SAH VERIFIED"

**Warna:**
- Primary: #059669 (Hijau Tua)
- Secondary: #10b981 (Hijau Cerah)
- Accent: #fbbf24 (Emas)
- Stamp: #dc2626 (Merah)

---

### F. DOKUMEN WORD KOPERASI

**File:** `resources/views/admin/koperasi/dokumen-word.blade.php`

**Format:** Word Document (.doc)

**Fitur:**
- ✅ Kop surat resmi dengan logo
- ✅ Header dokumen:
  - Judul "DOKUMEN DATA KOPERASI"
  - No. Dokumen: DOK/[No_Registrasi]/[Tahun]
  - Tanggal cetak dengan timestamp
- ✅ Info box status (badge warna)
- ✅ 5 Bagian data lengkap:
  1. **DATA REGISTRASI**
     - No. Registrasi, Nama Koperasi/Usaha
     - Jenis Usaha, Kategori
     - Tanggal Registrasi
  
  2. **DATA PEMILIK**
     - Nama Pemilik, No. KTP
     - No. Telepon, Email
  
  3. **ALAMAT USAHA**
     - Alamat Lengkap
     - Kelurahan/Desa, Distrik, Kabupaten
  
  4. **DATA USAHA**
     - Modal Usaha, Omset per Bulan
     - Jumlah Karyawan
     - Status Usaha (badge warna)
  
  5. **STATUS VERIFIKASI**
     - Status Verifikasi (badge warna)
     - Tanggal Verifikasi
     - Diverifikasi Oleh
     - Catatan Verifikasi (jika ada)

- ✅ Footer dengan tanda tangan Kepala Dinas
- ✅ Catatan kaki (timestamp cetak)

**Warna:**
- Primary: #059669 (Hijau Tua)
- Secondary: #10b981 (Hijau Cerah)
- Accent: #fbbf24 (Emas)

---

## 🎯 Cara Menggunakan

### 1. Clear Cache (WAJIB!)

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### 2. Test Download

**Untuk Anggota:**
1. Buka: `http://127.0.0.1:8000/admin/kartu-sertifikat`
2. Pilih tab "Anggota"
3. Klik tombol:
   - **Kartu** → Download kartu anggota (PDF)
   - **Sertifikat** → Download sertifikat (PDF)
   - **Dokumen** → Download dokumen lengkap (Word)

**Untuk Koperasi:**
1. Buka: `http://127.0.0.1:8000/admin/kartu-sertifikat`
2. Pilih tab "Koperasi"
3. Klik tombol:
   - **Kartu** → Download kartu koperasi (PDF)
   - **Sertifikat** → Download sertifikat (PDF)
   - **Dokumen** → Download dokumen lengkap (Word)

---

## 📊 Perbandingan Sebelum & Sesudah

### Sebelum:
- ❌ Tidak ada logo
- ❌ Tidak ada kop surat
- ❌ Data tidak lengkap
- ❌ Desain sederhana
- ❌ Tidak ada badge status
- ❌ Tidak ada watermark
- ❌ Tidak ada stempel

### Sesudah:
- ✅ Logo resmi Dinas
- ✅ Kop surat lengkap
- ✅ Data sangat lengkap (semua field)
- ✅ Desain profesional dengan gradient
- ✅ Badge status berwarna
- ✅ Watermark "KOPERASI"
- ✅ Stempel "SAH VERIFIED"
- ✅ Border ganda
- ✅ QR code placeholder
- ✅ Pattern background
- ✅ Shadow dan efek 3D
- ✅ Nomor dokumen unik
- ✅ Timestamp cetak

---

## 🎨 Panduan Warna

### Anggota (Biru)
```
Primary:   #1e3a8a (Biru Tua)
Secondary: #3b82f6 (Biru Cerah)
Accent:    #fbbf24 (Emas)
```

### Koperasi (Hijau)
```
Primary:   #059669 (Hijau Tua)
Secondary: #10b981 (Hijau Cerah)
Accent:    #fbbf24 (Emas)
```

### Status Badge
```
Success:  #d1fae5 (Background) + #065f46 (Text) + #10b981 (Border)
Warning:  #fef3c7 (Background) + #92400e (Text) + #f59e0b (Border)
Danger:   #fee2e2 (Background) + #991b1b (Text) + #ef4444 (Border)
```

### Stempel
```
Stamp: #dc2626 (Merah)
```

---

## 📁 File yang Diubah

1. ✅ `resources/views/admin/anggota/kartu-sertifikat.blade.php`
2. ✅ `resources/views/admin/anggota/dokumen-word.blade.php`
3. ✅ `resources/views/admin/koperasi/kartu-sertifikat.blade.php`
4. ✅ `resources/views/admin/koperasi/dokumen-word.blade.php`

---

## 🖨️ Tips Cetak

### Untuk Kartu:
- Gunakan kertas PVC atau kartu plastik
- Ukuran: 85.6mm x 53.98mm
- Cetak dengan printer kartu atau print shop
- Laminasi untuk ketahanan

### Untuk Sertifikat:
- Gunakan kertas A4 (210mm x 297mm)
- Orientasi: Landscape
- Kertas: Art Paper 150-200 gsm
- Cetak warna (full color)
- Frame untuk display

### Untuk Dokumen Word:
- Kertas A4 standar
- Orientasi: Portrait
- Cetak hitam putih atau warna
- Staples atau jilid untuk arsip

---

## ✅ Checklist Kualitas

- [x] Logo jelas dan tidak pecah
- [x] Semua data terisi lengkap
- [x] Warna sesuai identitas
- [x] Font mudah dibaca
- [x] Layout rapi dan terstruktur
- [x] Border dan frame proporsional
- [x] Badge status terlihat jelas
- [x] Watermark tidak mengganggu
- [x] Stempel terlihat resmi
- [x] Tanda tangan area cukup
- [x] Nomor dokumen unik
- [x] Timestamp akurat

---

## 🚀 Status

**✅ SELESAI** - Semua template telah diperbarui dengan logo dan data lengkap!

---

**Dibuat:** 16 April 2026  
**Versi:** 2.0  
**Status:** Production Ready ✅

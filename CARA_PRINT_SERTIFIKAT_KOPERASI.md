# Cara Print Sertifikat Koperasi

## 📋 Fitur Baru: Print Sertifikat yang Rapi dan Menarik

Sertifikat koperasi sekarang dilengkapi dengan tombol print yang mudah digunakan dan desain yang lebih profesional.

---

## 🎯 Cara Menggunakan

### 1. **Akses Halaman Sertifikat**
   - Login sebagai **Admin**
   - Buka menu **Laporan** → **Sertifikat Koperasi**
   - Atau akses langsung: `http://127.0.0.1:8000/admin/laporan/sertifikat`

### 2. **Pilih Koperasi**
   - Lihat daftar koperasi yang sudah terverifikasi
   - Klik tombol **"Cetak PDF"** (tombol kuning dengan icon sertifikat)
   - Sertifikat akan terbuka di tab baru

### 3. **Print Sertifikat**
   - Di halaman sertifikat, Anda akan melihat 2 tombol di pojok kanan atas:
     - **Print Sertifikat** (tombol hijau) - untuk mencetak
     - **Kembali** (tombol abu-abu) - untuk kembali ke daftar
   
   - Klik tombol **"Print Sertifikat"**
   - Dialog print browser akan muncul
   - Pilih printer dan pengaturan print
   - Klik **Print**

### 4. **Pengaturan Print yang Disarankan**
   - **Orientasi**: Landscape (Horizontal)
   - **Ukuran Kertas**: A4
   - **Margin**: None / Minimum
   - **Background Graphics**: Enabled (untuk melihat border dan ornamen)

---

## ✨ Fitur Desain Sertifikat

### 1. **Border & Ornamen**
   - Border ganda (biru navy dan emas)
   - Corner decorations di 4 sudut
   - Watermark "DISPERINDAGKOP" di background

### 2. **Header**
   - Logo Kabupaten Tolikara (kiri dan kanan)
   - Nama Dinas lengkap
   - Divider emas yang elegan

### 3. **Konten Utama**
   - Judul "SERTIFIKAT" dengan font besar dan tebal
   - Nomor registrasi dengan background biru muda
   - Nama usaha dengan font italic dan tebal
   - Nama pemilik dan alamat lengkap

### 4. **Informasi Detail**
   - Jenis Usaha
   - Kategori (dengan badge berwarna)
   - Tanggal Verifikasi
   - Masa Berlaku (3 tahun dari sekarang)

### 5. **Footer**
   - Kolom tanda tangan Kepala Dinas
   - QR Code placeholder (untuk verifikasi digital)
   - Area cap dinas

---

## 🎨 Desain yang Menarik

### Warna Utama:
- **Biru Navy** (#1a3a6e) - untuk teks utama dan border
- **Emas** (#f5a623) - untuk aksen dan divider
- **Putih** - background bersih

### Typography:
- **Font**: Times New Roman (formal dan profesional)
- **Judul**: 32pt, bold, uppercase
- **Nama Usaha**: 24pt, bold, italic
- **Detail**: 10-11pt, readable

### Layout:
- **Format**: A4 Landscape (297mm x 210mm)
- **Alignment**: Center (simetris dan seimbang)
- **Spacing**: Proporsional dan tidak terlalu padat

---

## 🖨️ Tips Print yang Baik

1. **Gunakan Kertas Berkualitas**
   - Kertas HVS 80-100 gsm untuk hasil terbaik
   - Atau kertas khusus sertifikat untuk tampilan premium

2. **Pengaturan Printer**
   - Pilih kualitas print "High" atau "Best"
   - Pastikan tinta printer cukup
   - Aktifkan "Print Background Colors and Images"

3. **Preview Sebelum Print**
   - Gunakan Print Preview untuk melihat hasil
   - Pastikan semua elemen terlihat dengan baik
   - Cek margin dan posisi

4. **Simpan sebagai PDF**
   - Jika tidak ingin langsung print, simpan sebagai PDF
   - Pilih "Save as PDF" di dialog print
   - PDF bisa dikirim via email atau disimpan sebagai arsip digital

---

## 📱 Tombol Print

### Tombol "Print Sertifikat" (Hijau)
- **Fungsi**: Membuka dialog print browser
- **Shortcut**: Ctrl+P (Windows) atau Cmd+P (Mac)
- **Icon**: Printer
- **Warna**: Gradient hijau (#10b981)

### Tombol "Kembali" (Abu-abu)
- **Fungsi**: Kembali ke halaman daftar sertifikat
- **Icon**: Arrow left
- **Warna**: Gradient abu-abu (#6b7280)

### Catatan Penting:
- Tombol-tombol ini **TIDAK AKAN MUNCUL** saat print
- Hanya sertifikat yang akan dicetak
- Desain otomatis menyesuaikan untuk print

---

## 🔍 Elemen Sertifikat

### Yang Tercetak:
✅ Border dan ornamen  
✅ Logo Kabupaten Tolikara  
✅ Nama Dinas dan Kabupaten  
✅ Judul "SERTIFIKAT"  
✅ Nomor registrasi  
✅ Nama usaha dan pemilik  
✅ Alamat lengkap  
✅ Jenis usaha dan kategori  
✅ Tanggal verifikasi dan masa berlaku  
✅ Area tanda tangan  
✅ QR Code placeholder  
✅ Area cap dinas  
✅ Watermark background  

### Yang TIDAK Tercetak:
❌ Tombol "Print Sertifikat"  
❌ Tombol "Kembali"  
❌ Elemen navigasi lainnya  

---

## 📂 File yang Dimodifikasi

- `resources/views/admin/laporan/pdf/sertifikat.blade.php`
  - Ditambahkan tombol print dan kembali
  - Diperbaiki desain border dan ornamen
  - Ditingkatkan typography dan spacing
  - Ditambahkan CSS print media
  - Diperbaiki logo path menggunakan `asset()`

---

## 🎯 Hasil Akhir

Sertifikat koperasi sekarang:
- ✅ Memiliki tombol print yang mudah digunakan
- ✅ Desain yang rapi dan profesional
- ✅ Border dan ornamen yang menarik
- ✅ Typography yang jelas dan mudah dibaca
- ✅ Layout yang seimbang dan simetris
- ✅ Siap untuk dicetak atau disimpan sebagai PDF
- ✅ Tombol otomatis hilang saat print

---

## 📞 Troubleshooting

### Logo tidak muncul?
- Pastikan file `public/logo.png` ada
- Cek permission folder public
- Refresh browser dengan Ctrl+F5

### Border tidak tercetak?
- Aktifkan "Background Graphics" di pengaturan print
- Atau "Print Background Colors and Images"

### Layout tidak pas?
- Pastikan orientasi Landscape
- Set margin ke None atau Minimum
- Pilih ukuran kertas A4

### Tombol masih muncul saat print?
- Pastikan menggunakan fungsi print browser (Ctrl+P)
- Jangan screenshot atau print screen
- CSS print media akan otomatis menyembunyikan tombol

---

## ✅ Status: SELESAI

Fitur print sertifikat sudah siap digunakan dengan desain yang rapi dan menarik!

# 📄 Fitur Dokumen Anggota - Quick Guide

## 🎯 Ringkasan Fitur

Sistem ini menyediakan **3 jenis dokumen** yang bisa didownload untuk setiap anggota:

| No | Dokumen | Format | Ukuran | Fungsi |
|----|---------|--------|--------|--------|
| 1 | **Dokumen Lengkap** | Word (.doc) | A4 | Data lengkap anggota |
| 2 | **Kartu Anggota** | PDF | 85.6mm x 53.98mm | Kartu identitas |
| 3 | **Sertifikat** | PDF | A4 Landscape | Sertifikat keanggotaan |

---

## 🚀 Quick Start

### Akses Menu:
```
Login Admin → Anggota → Dokumen Anggota
```

### Download Dokumen:
1. **Dokumen Word** → Klik tombol hijau "Word" 📗
2. **Kartu Anggota** → Klik tombol biru "Kartu" 🆔
3. **Sertifikat** → Klik tombol orange "Sertifikat" 🏆

---

## 📊 Fitur Dashboard

### Statistik Real-time:
- ✅ Total Anggota
- ✅ Dokumen Lengkap
- ✅ Dokumen Sebagian
- ✅ Dokumen Tidak Lengkap

### Filter & Pencarian:
- 🔍 Cari berdasarkan nama/no anggota
- 📋 Filter status dokumen (Lengkap/Sebagian/Tidak Lengkap)

---

## 📥 Isi Dokumen

### 1. Dokumen Word (Lengkap)
```
✓ Data Pribadi (NIK, Nama, TTL, dll)
✓ Informasi Kontak
✓ Alamat Lengkap
✓ Data Usaha
✓ Data Keuangan & Perbankan
✓ Data Ahli Waris
✓ Status Keanggotaan
✓ Foto Anggota
```

### 2. Kartu Anggota
```
✓ Foto Anggota
✓ Nama & NIK
✓ Tempat/Tanggal Lahir
✓ Distrik
✓ No. Anggota
✓ Masa Berlaku (5 tahun)
```

### 3. Sertifikat Keanggotaan
```
✓ Logo Koperasi
✓ Nama Anggota
✓ No. Anggota & NIK
✓ Nama Koperasi
✓ Tanggal Bergabung
✓ Tanda Tangan Ketua & Sekretaris
```

---

## 🖨️ Tips Cetak

### Kartu Anggota:
- **Kertas:** Card stock 260-300 gsm
- **Setting:** Borderless, Landscape
- **Finishing:** Laminating

### Sertifikat:
- **Kertas:** Art paper 100-120 gsm
- **Setting:** A4 Landscape, High Quality
- **Finishing:** Frame atau gulung dengan pita

---

## 🔧 Technical Details

### Routes:
```php
// Menu Dokumen
GET /admin/anggota-dokumen

// Download Dokumen Word
GET /admin/anggota/{id}/download-dokumen

// Download Kartu PDF
GET /admin/anggota/{id}/download-kartu

// Download Sertifikat PDF
GET /admin/anggota/{id}/download-sertifikat
```

### Files:
```
Views:
- resources/views/admin/anggota/dokumen.blade.php
- resources/views/admin/anggota/dokumen-word.blade.php
- resources/views/admin/anggota/kartu-sertifikat.blade.php

Controller:
- app/Http/Controllers/Admin/AnggotaController.php
  - dokumen()
  - downloadDokumen()
  - downloadKartu()
  - downloadSertifikat()
```

---

## 🎨 Customization

### Edit Template:
1. **Dokumen Word:** `dokumen-word.blade.php`
2. **Kartu & Sertifikat:** `kartu-sertifikat.blade.php`

### Yang Bisa Diubah:
- ✏️ Layout dan design
- 🎨 Warna dan font
- 📐 Ukuran dan spacing
- 🖼️ Logo dan watermark

---

## 📱 Responsive

Halaman dokumen anggota **responsive** dan bisa diakses dari:
- 💻 Desktop
- 📱 Tablet
- 📱 Mobile

---

## 🔐 Security

- ✅ Hanya admin yang bisa akses
- ✅ Validasi session
- ✅ Log aktivitas download
- ✅ Data terenkripsi

---

## 📚 Dokumentasi Lengkap

Untuk panduan detail, lihat:
- 📄 [CARA_DOWNLOAD_DOKUMEN_ANGGOTA.md](CARA_DOWNLOAD_DOKUMEN_ANGGOTA.md)
- 🎫 [CARA_AKSES_KARTU_SERTIFIKAT.md](CARA_AKSES_KARTU_SERTIFIKAT.md)

---

## ❓ Quick FAQ

**Q: Bagaimana cara download dokumen?**  
A: Masuk ke menu "Dokumen Anggota", cari anggota, klik tombol download yang diinginkan.

**Q: Format apa yang tersedia?**  
A: Word (.doc) untuk dokumen lengkap, PDF untuk kartu dan sertifikat.

**Q: Apakah bisa cetak langsung?**  
A: Ya, download PDF lalu cetak menggunakan printer.

**Q: Bagaimana jika foto tidak ada?**  
A: Akan muncul placeholder "No Photo". Sebaiknya upload foto terlebih dahulu.

**Q: Apakah bisa download banyak sekaligus?**  
A: Saat ini satu per satu. Fitur bulk download bisa ditambahkan jika diperlukan.

---

## 🚀 Future Features

- [ ] Bulk download (multiple anggota)
- [ ] QR Code di kartu
- [ ] Multiple template design
- [ ] Email dokumen ke anggota
- [ ] Export ke format lain (JPG, PNG)

---

## 📞 Support

Butuh bantuan? Hubungi:
- 📧 Email: admin@koperasi.com
- 💬 WhatsApp: 08xx-xxxx-xxxx

---

**Version:** 1.0  
**Last Update:** {{ date('d F Y') }}  
**System:** Koperasi Tolikara Management System

---

## 🎉 Selamat Menggunakan!

Fitur ini dibuat untuk memudahkan pengelolaan dokumen anggota koperasi. Semoga bermanfaat! 🙏

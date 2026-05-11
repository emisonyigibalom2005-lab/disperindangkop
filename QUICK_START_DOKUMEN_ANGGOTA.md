# 🚀 Quick Start - Dokumen Anggota

## ⚡ Akses Cepat

### 1️⃣ Login sebagai Admin
```
URL: /login
Username: admin
Password: [password admin]
```

### 2️⃣ Buka Menu Dokumen Anggota
```
Sidebar → Anggota → Dokumen Anggota
```
atau langsung ke:
```
URL: /admin/anggota-dokumen
```

### 3️⃣ Download Dokumen
Klik salah satu tombol:
- 📗 **Word** → Dokumen lengkap (.doc)
- 🆔 **Kartu** → Kartu anggota (.pdf)
- 🏆 **Sertifikat** → Sertifikat keanggotaan (.pdf)

---

## 📊 Dashboard Overview

```
┌─────────────────────────────────────────────────┐
│  DOKUMEN ANGGOTA                                │
├─────────────────────────────────────────────────┤
│                                                 │
│  📊 STATISTIK                                   │
│  ┌──────────┬──────────┬──────────┬──────────┐ │
│  │ Total    │ Lengkap  │ Sebagian │ Tidak    │ │
│  │ Anggota  │          │          │ Lengkap  │ │
│  └──────────┴──────────┴──────────┴──────────┘ │
│                                                 │
│  🔍 FILTER & PENCARIAN                          │
│  [Status ▼] [Cari...] [Cari] [Reset]           │
│                                                 │
│  📋 DAFTAR ANGGOTA                              │
│  ┌─────────────────────────────────────────┐   │
│  │ Nama │ No │ Koperasi │ Status │ Aksi   │   │
│  ├─────────────────────────────────────────┤   │
│  │ ...  │... │ ...      │ ...    │ [Btn]  │   │
│  └─────────────────────────────────────────┘   │
│                                                 │
│  « 1 2 3 ... »                                  │
└─────────────────────────────────────────────────┘
```

---

## 🎯 3 Jenis Dokumen

### 1. Dokumen Word (.doc)
**Isi:**
- Data Pribadi
- Kontak
- Alamat
- Data Usaha
- Data Keuangan
- Ahli Waris
- Status Keanggotaan

**Ukuran:** A4  
**Format:** Microsoft Word  
**Fungsi:** Arsip lengkap data anggota

### 2. Kartu Anggota (.pdf)
**Isi:**
- Foto
- Nama & NIK
- TTL
- Distrik
- No. Anggota
- Masa Berlaku

**Ukuran:** 85.6mm x 53.98mm  
**Format:** PDF  
**Fungsi:** Kartu identitas anggota

### 3. Sertifikat (.pdf)
**Isi:**
- Logo Koperasi
- Nama Anggota
- No. Anggota & NIK
- Nama Koperasi
- Tanggal Bergabung
- TTD Ketua & Sekretaris

**Ukuran:** A4 Landscape  
**Format:** PDF  
**Fungsi:** Sertifikat resmi keanggotaan

---

## 🔍 Filter & Pencarian

### Filter Status Dokumen:
```
[Semua Status ▼]
  - Semua Status
  - Lengkap (KTP + KK + Foto ada)
  - Sebagian (Minimal 1 dokumen ada)
  - Tidak Lengkap (Semua dokumen kosong)
```

### Pencarian:
```
[Cari: Nama atau No. Anggota...]
```

### Reset:
```
[Reset] → Hapus semua filter
```

---

## 📥 Cara Download

### Download Dokumen Word:
1. Cari anggota
2. Klik tombol **"Word"** (hijau) 📗
3. File terdownload: `Dokumen_Anggota_[Nama]_[No].doc`

### Download Kartu:
1. Cari anggota
2. Klik tombol **"Kartu"** (biru) 🆔
3. File terdownload: `Kartu_Anggota_[Nama].pdf`

### Download Sertifikat:
1. Cari anggota
2. Klik tombol **"Sertifikat"** (orange) 🏆
3. File terdownload: `Sertifikat_[Nama].pdf`

---

## 🖨️ Tips Cetak

### Kartu Anggota:
```
Kertas: Card stock 260-300 gsm
Setting: Borderless, Landscape
Ukuran: 85.6mm x 53.98mm
Finishing: Laminating
```

### Sertifikat:
```
Kertas: Art paper 100-120 gsm
Setting: A4 Landscape, High Quality
Finishing: Frame atau gulung
```

---

## 🎨 Status Dokumen

### ✅ Lengkap (Hijau)
- KTP: ✓
- KK: ✓
- Foto: ✓

### ⚠️ Sebagian (Kuning)
- Minimal 1 dokumen ada
- Tidak semua lengkap

### ❌ Tidak Lengkap (Merah)
- KTP: ✗
- KK: ✗
- Foto: ✗

---

## 🔧 Troubleshooting

### Dokumen tidak terdownload?
```
✓ Cek koneksi internet
✓ Allow pop-ups di browser
✓ Clear cache browser
✓ Coba browser lain
```

### Foto tidak muncul?
```
✓ Pastikan anggota sudah upload foto
✓ Cek path storage
✓ Verify file exists
```

### Kartu tidak bisa dicetak?
```
✓ Pastikan PDF reader terinstall
✓ Cek setting printer
✓ Pastikan kertas sesuai ukuran
```

---

## 📱 Akses dari Device

### Desktop 💻
```
✓ Full features
✓ Optimal experience
✓ All buttons visible
```

### Tablet 📱
```
✓ Responsive layout
✓ Touch-friendly
✓ Scrollable table
```

### Mobile 📱
```
✓ Card-based layout
✓ Vertical buttons
✓ Easy navigation
```

---

## 🔐 Security

```
✓ Login required (Admin only)
✓ Session validation
✓ CSRF protection
✓ Activity logging
```

---

## 📚 Dokumentasi Lengkap

Untuk panduan detail:

1. **Download Dokumen**
   → [CARA_DOWNLOAD_DOKUMEN_ANGGOTA.md](CARA_DOWNLOAD_DOKUMEN_ANGGOTA.md)

2. **Kartu & Sertifikat**
   → [CARA_AKSES_KARTU_SERTIFIKAT.md](CARA_AKSES_KARTU_SERTIFIKAT.md)

3. **Quick Guide**
   → [FITUR_DOKUMEN_ANGGOTA_README.md](FITUR_DOKUMEN_ANGGOTA_README.md)

4. **Implementation**
   → [IMPLEMENTASI_FITUR_DOKUMEN_SUMMARY.md](IMPLEMENTASI_FITUR_DOKUMEN_SUMMARY.md)

---

## ❓ Quick FAQ

**Q: Bagaimana cara akses menu?**  
A: Login → Sidebar → Anggota → Dokumen Anggota

**Q: Format apa yang tersedia?**  
A: Word (.doc) dan PDF untuk kartu & sertifikat

**Q: Apakah bisa download banyak sekaligus?**  
A: Saat ini satu per satu. Bulk download coming soon.

**Q: Bagaimana jika foto tidak ada?**  
A: Akan muncul placeholder "No Photo"

**Q: Apakah bisa cetak langsung?**  
A: Ya, download PDF lalu cetak

---

## 📞 Bantuan

Butuh bantuan?
- 📧 Email: admin@koperasi.com
- 💬 WhatsApp: 08xx-xxxx-xxxx

---

## 🎉 Selamat Menggunakan!

Fitur ini dibuat untuk memudahkan pengelolaan dokumen anggota koperasi.

**Tips:**
- Pastikan data anggota lengkap sebelum download
- Cek preview sebelum cetak massal
- Simpan file PDF sebagai backup
- Update foto anggota secara berkala

---

**Version:** 1.0  
**Last Update:** {{ date('d F Y') }}  
**System:** Koperasi Tolikara Management System

---

**Happy documenting! 📄✨**

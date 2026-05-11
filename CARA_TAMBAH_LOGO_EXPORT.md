# 🖼️ Cara Menambahkan Logo di Export Data Koperasi & Anggota

## 📍 Lokasi Logo

Logo sudah ada di:
```
public/logo.png
```

## ✅ STATUS INTEGRASI

### ✔️ Data Koperasi (SUDAH TERINTEGRASI)
- File: `resources/views/petugas/koperasi/index.blade.php`
- JavaScript: `public/js/export-with-logo.js`
- Fungsi: `exportPDFKoperasi()`, `exportWordKoperasi()`, `printDataKoperasi()`
- Status: **AKTIF** ✅

### ✔️ Data Anggota (SUDAH TERINTEGRASI)
- File: `resources/views/petugas/anggota/index.blade.php`
- JavaScript: `public/js/export-anggota-with-logo.js`
- Fungsi: `exportPDFAnggota()`, `exportWordAnggota()`, `printDataAnggota()`
- Status: **AKTIF** ✅

## 🎨 Format Header Export

Header export menampilkan:

```
┌─────────────────────────────────────────────────────┐
│  [LOGO]     DATA KOPERASI / DATA ANGGOTA            │
│        DINAS PERINDUSTRIAN, PERDAGANGAN             │
│                 DAN KOPERASI                        │
│      Kabupaten Tolikara, Papua Pegunungan          │
│         Tanggal: Kamis, 16 April 2026               │
└─────────────────────────────────────────────────────┘
```

## 📂 Struktur File

```
public/
├── logo.png                           # Logo Kabupaten Tolikara
├── js/
│   ├── export-with-logo.js           # Export untuk Data Koperasi
│   └── export-anggota-with-logo.js   # Export untuk Data Anggota

resources/views/petugas/
├── koperasi/
│   └── index.blade.php               # Sudah include export-with-logo.js
└── anggota/
    └── index.blade.php               # Sudah include export-anggota-with-logo.js
```

## 🔧 Cara Kerja

### 1. Export PDF
- Menggunakan jsPDF dengan autotable
- Logo dimuat menggunakan `img.onload` untuk memastikan logo ter-load
- Header dengan border dan styling profesional
- Footer dengan nomor halaman

### 2. Export Word
- Format HTML yang kompatibel dengan Microsoft Word
- Logo menggunakan tag `<img>` dengan path absolut
- Tabel dengan styling yang rapi

### 3. Print
- Membuka window baru dengan konten yang sudah di-format
- Logo ditampilkan di header
- CSS khusus untuk print media
- Auto-trigger print dialog setelah 500ms

## 🚀 Cara Menggunakan

### Di Halaman Data Koperasi:
1. Buka: `http://localhost:8000/petugas/koperasi`
2. Klik tombol **PDF**, **Word**, atau **Print**
3. Logo akan muncul otomatis di header

### Di Halaman Data Anggota:
1. Buka: `http://localhost:8000/petugas/anggota`
2. Klik tombol **PDF**, **Word**, atau **Print**
3. Logo akan muncul otomatis di header

## 🎯 Fitur Export

| Format | Logo | Header | Footer | Styling |
|--------|------|--------|--------|---------|
| Excel  | ❌   | ❌     | ❌     | Basic   |
| PDF    | ✅   | ✅     | ✅     | Professional |
| Word   | ✅   | ✅     | ✅     | Professional |
| Print  | ✅   | ✅     | ✅     | Professional |

## 🔍 Troubleshooting

### Logo tidak muncul di PDF
- Pastikan file `public/logo.png` ada
- Cek console browser untuk error
- Logo harus dalam format PNG atau JPG

### Logo tidak muncul di Word/Print
- Pastikan path logo benar: `/logo.png`
- Cek apakah server Laravel berjalan
- Logo harus accessible via HTTP

### Export tidak berfungsi
- Pastikan library sudah ter-load:
  - jsPDF
  - jsPDF-autotable
  - SheetJS (untuk Excel)
- Cek console browser untuk error JavaScript

## 📝 Catatan Teknis

### Ukuran Logo
- **PDF**: 25mm x 30mm
- **Word/Print**: 70px (auto height)

### Warna Header
- Border: `#1a3a6e` (Biru gelap)
- Background gradient: `#667eea` → `#764ba2` (Purple)

### Font
- Judul: Bold, 18-22px
- Subjudul: Bold, 14-16px
- Body: Normal, 11-13px

## ✅ Checklist Verifikasi

- [x] Logo ada di `public/logo.png`
- [x] File `export-with-logo.js` dibuat
- [x] File `export-anggota-with-logo.js` dibuat
- [x] View koperasi sudah include JS file
- [x] View anggota sudah include JS file
- [x] Tombol export menggunakan fungsi baru
- [x] Test export PDF - logo muncul
- [x] Test export Word - logo muncul
- [x] Test print - logo muncul

## 🎉 Selesai!

Logo Kabupaten Tolikara sudah terintegrasi di semua export (PDF, Word, Print) untuk:
- ✅ Data Koperasi
- ✅ Data Anggota

**Sistem export dengan logo sudah aktif dan siap digunakan!** 🚀

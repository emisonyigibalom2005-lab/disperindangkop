# Fitur Print Laporan - Dokumentasi

## Overview
Sistem telah dilengkapi dengan fitur print laporan yang profesional dan rapi dengan header logo resmi untuk semua jenis laporan.

## Fitur yang Tersedia

### 1. Laporan Data Koperasi (Admin & Pimpinan)

**Lokasi:**
- Admin: `/admin/laporan/koperasi`
- Pimpinan: `/pimpinan/laporan/koperasi`

**Fitur Print:**
- ✅ Header dengan 2 logo (Kabupaten Tolikara & Koperasi)
- ✅ Informasi dinas lengkap
- ✅ Filter yang diterapkan
- ✅ Statistik ringkasan (Total, Diverifikasi, Pending, Ditolak)
- ✅ Tabel data lengkap dengan styling
- ✅ Footer dengan timestamp dan copyright
- ✅ Format landscape A4
- ✅ Tombol print di preview

**Cara Menggunakan:**
1. Buka halaman Laporan Data Koperasi
2. Terapkan filter jika diperlukan (Distrik, Kategori, Status)
3. Klik tombol "Print Laporan"
4. Window preview akan terbuka
5. Klik tombol "🖨️ Print Laporan" atau gunakan Ctrl+P

### 2. Laporan Rekap Bantuan (Admin)

**Lokasi:**
- Admin: `/admin/laporan/bantuan`

**Fitur Print:**
- ✅ Header dengan 2 logo (Kabupaten Tolikara & Koperasi)
- ✅ Informasi dinas lengkap
- ✅ Filter yang diterapkan
- ✅ Tren penerima bantuan per tahun (jika ada)
- ✅ Grafik persentase dalam tabel
- ✅ Daftar program bantuan lengkap
- ✅ Footer dengan timestamp dan copyright
- ✅ Format landscape A4
- ✅ Tombol print di preview

**Cara Menggunakan:**
1. Buka halaman Rekap Bantuan
2. Terapkan filter jika diperlukan (Tahun, Status)
3. Klik tombol print (ikon printer)
4. Window preview akan terbuka
5. Klik tombol "🖨️ Print Laporan" atau gunakan Ctrl+P

## Spesifikasi Teknis

### Header Layout
```
┌─────────────┬──────────────────────────────┬─────────────┐
│   Logo      │    PEMERINTAH KABUPATEN      │   Logo      │
│  Tolikara   │         TOLIKARA             │  Koperasi   │
│   (80x80)   │  DINAS PERINDUSTRIAN, ...    │  (80x80)    │
│             │  Alamat & Kontak             │             │
└─────────────┴──────────────────────────────┴─────────────┘
```

### Ukuran Logo
- **Lebar**: 80px
- **Tinggi**: 80px
- **Format**: PNG dengan transparansi
- **Object-fit**: contain (menjaga rasio aspek)

### Warna Tema
- **Primary**: #1a3a6e (Biru Tua)
- **Gradient**: #667eea → #764ba2 (Ungu)
- **Success**: #10b981 (Hijau)
- **Warning**: #f59e0b (Oranye)
- **Danger**: #ef4444 (Merah)

### Format Kertas
- **Ukuran**: A4 Landscape
- **Margin**: 15mm semua sisi
- **Font**: Arial, 10-11px
- **Line Height**: 1.4

## File Logo yang Dibutuhkan

### 1. Logo Kabupaten Tolikara
- **Path**: `public/images/logo-tolikara.png`
- **Status**: ✅ Sudah tersedia
- **Ukuran**: 500x500px atau lebih
- **Format**: PNG dengan transparansi

### 2. Logo Koperasi
- **Path**: `public/images/logo-koperasi.png`
- **Status**: ⚠️ Perlu ditambahkan
- **Ukuran**: 500x500px (rasio 1:1)
- **Format**: PNG dengan transparansi

**Catatan**: Jika logo tidak tersedia, sistem akan otomatis menyembunyikan area logo tersebut menggunakan `onerror="this.style.display='none'"`.

## Konten yang Dicetak

### Laporan Koperasi
1. **Header** - Logo dan informasi dinas
2. **Judul** - "LAPORAN DATA KOPERASI"
3. **Info Section** - Filter dan tanggal cetak
4. **Statistik** - 4 kotak berwarna (Total, Diverifikasi, Pending, Ditolak)
5. **Tabel Data** - Semua data koperasi dengan kolom:
   - No
   - No. Registrasi
   - Nama Usaha
   - Pemilik
   - Distrik
   - Kategori (badge berwarna)
   - Status (badge berwarna)
   - Tanggal Daftar
6. **Footer** - Timestamp, copyright, total data

### Laporan Bantuan
1. **Header** - Logo dan informasi dinas
2. **Judul** - "LAPORAN REKAP BANTUAN KOPERASI"
3. **Info Section** - Filter dan tanggal cetak
4. **Tren Per Tahun** (jika ada):
   - Tahun
   - Jumlah Penerima
   - Total Nilai Bantuan
   - Grafik Persentase
5. **Tabel Program Bantuan**:
   - No
   - Kode
   - Nama Program
   - Jenis
   - Tahun
   - Anggaran
   - Kuota
   - Penerima
   - Status
6. **Footer** - Timestamp, copyright, total program

## Styling Print

### Print-Friendly Features
- ✅ Warna tetap muncul saat print (`print-color-adjust: exact`)
- ✅ Tombol print disembunyikan saat print (`.no-print`)
- ✅ Border dan spacing optimal
- ✅ Font size readable untuk print
- ✅ Badge dan status dengan warna kontras

### Responsive Elements
- Header flexbox untuk alignment sempurna
- Logo dengan object-fit contain
- Tabel dengan width proporsional
- Progress bar untuk grafik (laporan bantuan)

## Browser Compatibility
- ✅ Chrome/Edge (Recommended)
- ✅ Firefox
- ✅ Safari
- ⚠️ IE11 (Limited support)

## Tips Penggunaan

### Untuk Hasil Print Terbaik:
1. Gunakan browser Chrome atau Edge
2. Pastikan "Background graphics" diaktifkan di print settings
3. Pilih orientasi Landscape
4. Gunakan ukuran kertas A4
5. Set margin ke "Default" atau "Minimum"

### Troubleshooting:
- **Logo tidak muncul**: Pastikan file logo ada di `public/images/`
- **Warna tidak muncul**: Aktifkan "Background graphics" di print settings
- **Layout berantakan**: Pastikan menggunakan orientasi Landscape
- **Tabel terpotong**: Reduce zoom atau gunakan ukuran kertas lebih besar

## Pengembangan Selanjutnya

### Fitur yang Bisa Ditambahkan:
- [ ] Export to PDF langsung dari browser
- [ ] Pilihan orientasi (Portrait/Landscape)
- [ ] Custom header/footer
- [ ] Watermark
- [ ] QR Code untuk verifikasi dokumen
- [ ] Digital signature
- [ ] Print preview dengan zoom
- [ ] Save as template

## Maintenance

### Update Logo:
1. Siapkan file logo baru (PNG, 500x500px)
2. Upload ke `public/images/`
3. Ganti nama file sesuai:
   - `logo-tolikara.png` untuk logo kabupaten
   - `logo-koperasi.png` untuk logo koperasi
4. Clear browser cache
5. Test print

### Update Styling:
- Edit bagian `<style>` dalam fungsi JavaScript `printAllData()` atau `printLaporan()`
- Sesuaikan warna, font, spacing sesuai kebutuhan
- Test di berbagai browser

## Support
Untuk bantuan atau pertanyaan, hubungi tim IT DISPERINDAGKOP Kabupaten Tolikara.

---
**Last Updated**: 2026-04-15
**Version**: 1.0.0

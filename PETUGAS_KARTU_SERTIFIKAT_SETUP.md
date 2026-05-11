# Setup Kartu & Sertifikat untuk Petugas

## ✅ SETUP SELESAI!

Semua fitur kartu & sertifikat sudah berhasil ditambahkan untuk Petugas!

## Yang Sudah Dilakukan

### 1. ✅ Routes (routes/web.php)
Ditambahkan route untuk Petugas:
- `/petugas/kartu-sertifikat` - Halaman list kartu & sertifikat
- `/petugas/anggota/{id}/download-kartu` - Download kartu anggota
- `/petugas/anggota/{id}/download-sertifikat` - Download sertifikat anggota
- `/petugas/anggota/{id}/download-dokumen` - Download dokumen Word anggota
- `/petugas/anggota/{id}/print-dokumen` - Print dokumen anggota
- `/petugas/koperasi/{id}/download-kartu` - Download kartu koperasi
- `/petugas/koperasi/{id}/download-sertifikat` - Download sertifikat koperasi
- `/petugas/koperasi/{id}/download-dokumen` - Download dokumen Word koperasi
- `/petugas/koperasi/{id}/print-dokumen` - Print dokumen koperasi

### 2. ✅ Controllers
**app/Http/Controllers/Petugas/AnggotaController.php**
Ditambahkan method:
- `kartuSertifikatList()` - Menampilkan halaman list
- `downloadKartu()` - Generate PDF kartu
- `downloadSertifikat()` - Generate PDF sertifikat
- `downloadDokumen()` - Generate Word dokumen
- `printDokumen()` - Tampilkan HTML untuk print

**app/Http/Controllers/Petugas/KoperasiController.php**
Ditambahkan method:
- `downloadKartu()` - Generate PDF kartu
- `downloadSertifikat()` - Generate PDF sertifikat
- `downloadDokumen()` - Generate Word dokumen
- `printDokumen()` - Tampilkan HTML untuk print

### 3. ✅ View Files
Semua file view sudah disalin dan route sudah diupdate:

**Untuk Anggota:**
- ✅ `resources/views/petugas/anggota/kartu-sertifikat-list.blade.php`
- ✅ `resources/views/petugas/anggota/kartu-sertifikat.blade.php`
- ✅ `resources/views/petugas/anggota/dokumen-word.blade.php`

**Untuk Koperasi:**
- ✅ `resources/views/petugas/koperasi/kartu-sertifikat.blade.php`
- ✅ `resources/views/petugas/koperasi/dokumen-word.blade.php`

## Cara Mengakses

Petugas sekarang bisa mengakses fitur ini melalui:
- **URL**: `/petugas/kartu-sertifikat`
- **Menu**: Tambahkan link di sidebar petugas (opsional)

## Fitur yang Tersedia untuk Petugas

1. **Kartu Anggota & Koperasi** - Download kartu identitas format landscape (85.6mm x 53.98mm)
2. **Sertifikat** - Download sertifikat keanggotaan format A4 portrait
3. **Dokumen Word** - Download dokumen lengkap dalam format Word (.doc)
4. **Print PDF** - Print dokumen langsung dari browser
5. **Detail** - Lihat detail lengkap anggota/koperasi
6. **Print** - Modal untuk memilih jenis dokumen yang akan diprint

## Permissions

Semua method sudah dilengkapi dengan permission check:
- `can_view('anggota')` - Untuk melihat dan download
- Sesuai dengan izin akses yang sudah diberikan Admin

## Desain Dokumen

### Kartu (85.6mm x 53.98mm)
- Logo kiri & kanan di header (14mm)
- Data identitas penting: NIK, Nama, Tempat/Tgl Lahir, Alamat, Koperasi
- Foto anggota di kanan (26mm x 32mm)
- Background gradient biru
- Footer: Tanggal terdaftar & No. Anggota

### Sertifikat (A4 Portrait)
- Border emas luar & biru dalam
- Logo di atas tengah
- Kop surat singkat
- Nama dengan gradient emas
- Detail anggota dalam box
- Medal emas
- Tanda tangan Ketua Koperasi & Kepala Dinas

### Dokumen Word
- **Header baru yang lebih rapi:**
  - Logo di atas tengah (100px x 100px)
  - Text di bawah logo, center aligned
  - Typography: "PEMERINTAH KABUPATEN TOLIKARA" (20pt)
  - "DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI" (16pt)
  - Alamat dan kontak (10pt italic)
  - Double border line (4px + 1px solid)
- Foto anggota otomatis tampil jika ada
- Semua data lengkap dalam sections
- Format siap print

## Testing

1. ✅ Login sebagai Petugas
2. ✅ Akses `/petugas/kartu-sertifikat`
3. ✅ Coba download kartu, sertifikat, dan dokumen
4. ✅ Coba fitur print
5. ✅ Pastikan semua berfungsi dengan baik

## Status

🎉 **SEMUA FITUR SUDAH AKTIF DAN SIAP DIGUNAKAN!**

Petugas sekarang memiliki akses penuh ke fitur kartu & sertifikat, sama seperti Admin.


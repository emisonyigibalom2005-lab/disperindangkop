# Panduan Lengkap Export Jadwal - PDF, Word, Excel

## ✅ Fitur Export yang Tersedia

Halaman Manajemen Jadwal di Admin sekarang memiliki **4 tombol export** yang lengkap dan siap digunakan:

1. **🖨️ Print** - Cetak langsung ke printer
2. **📕 PDF** - Download file PDF otomatis
3. **📗 Excel** - Download file Excel (.xlsx)
4. **📘 Word** - Download file Word (.docx)

## 🎯 Cara Menggunakan

### 1. Akses Halaman Jadwal
```
URL: http://127.0.0.1:8000/admin/jadwal
```

### 2. Filter Data (Opsional)
- **Jenis Kegiatan**: Pilih jenis (Verifikasi, Pelatihan, Penilaian, Rapat)
- **Status**: Pilih status (Dijadwalkan, Berlangsung, Selesai, Dibatalkan)
- Klik tombol **Filter**

### 3. Export Data
Klik salah satu tombol di bagian atas:
- **Print** (Biru) - Buka halaman print
- **PDF** (Merah) - Download PDF langsung
- **Excel** (Hijau) - Download Excel langsung
- **Word** (Biru Tua) - Download Word langsung

## 📄 Format Laporan

### Kop Surat (Semua Format):
```
┌────────┬──────────────────────────────────────────────────────┐
│        │  DINAS PERINDUSTRIAN, PERDAGANGAN DAN KOPERASI       │
│  LOGO  │              KABUPATEN TOLIKARA                      │
│        │  Jl. Pemuda No. 123, Karubaga, Tolikara, Papua Peg. │
│        │  Telp: (0969) 12345 | Email: disperindagkop@...     │
└────────┴──────────────────────────────────────────────────────┘
═══════════════════════════════════════════════════════════════
                    LAPORAN JADWAL KEGIATAN
```

### Kolom Data (8 Kolom):
1. **No** - Nomor urut
2. **Tanggal** - Format: dd/mm/yyyy
3. **Waktu** - Format: HH:mm - HH:mm
4. **Judul Kegiatan** - Nama kegiatan lengkap
5. **Jenis** - Verifikasi/Pelatihan/Penilaian/Rapat
6. **Lokasi** - Tempat pelaksanaan
7. **Petugas** - Nama petugas yang ditugaskan
8. **Status** - Dijadwalkan/Berlangsung/Selesai/Dibatalkan

### Tanda Tangan:
```
                                    Karubaga, 06 Mei 2026
                Kepala Dinas Perindustrian, Perdagangan dan Koperasi
                                    Kabupaten Tolikara



                                ( _________________________ )
                                NIP. 19XXXXXXXXXXXXXXXXX
```

## 🖨️ 1. Export PRINT

### Cara Menggunakan:
1. Klik tombol **Print** (biru)
2. Halaman print akan terbuka di tab baru
3. Klik tombol **"Cetak Dokumen"** atau tekan **Ctrl+P**
4. Pilih printer dan cetak

### Fitur:
- ✅ Logo di kop surat
- ✅ Tombol cetak yang hilang saat print
- ✅ Layout A4 landscape
- ✅ Zebra striping (baris genap/ganjil berbeda warna)
- ✅ Summary box (total jadwal)
- ✅ Tanda tangan lengkap

### File:
- **View**: `resources/views/admin/jadwal/print.blade.php`
- **Route**: `admin.jadwal.export.print`

## 📕 2. Export PDF

### Cara Menggunakan:
1. Klik tombol **PDF** (merah)
2. File PDF akan **otomatis ter-download**
3. Buka file PDF dengan PDF reader

### Fitur:
- ✅ **Download otomatis** (tidak perlu print manual)
- ✅ Logo di kop surat
- ✅ Layout A4 landscape
- ✅ Zebra striping
- ✅ Summary box
- ✅ Tanda tangan lengkap
- ✅ Nama file: `Laporan_Jadwal_YYYY-MM-DD_HHMMSS.pdf`

### Teknologi:
- **Library**: DomPDF (barryvdh/laravel-dompdf)
- **Paper**: A4 Landscape
- **Encoding**: UTF-8

### File:
- **View**: `resources/views/admin/jadwal/pdf.blade.php`
- **Controller**: `JadwalController@exportPdf`
- **Route**: `admin.jadwal.export.pdf`

### Code:
```php
$pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.jadwal.pdf', compact('jadwal'));
$pdf->setPaper('a4', 'landscape');
return $pdf->download($filename);
```

## 📗 3. Export EXCEL

### Cara Menggunakan:
1. Klik tombol **Excel** (hijau)
2. File Excel akan **otomatis ter-download**
3. Buka file dengan Microsoft Excel atau Google Sheets

### Fitur:
- ✅ **Download otomatis**
- ✅ Logo di cell A1
- ✅ Kop surat lengkap
- ✅ Header hijau (#22c55e) dengan teks putih
- ✅ Zebra striping (hijau muda & putih)
- ✅ Summary box dengan border hijau
- ✅ Tanda tangan di kolom F-H
- ✅ Auto-width columns
- ✅ Border pada semua cell
- ✅ Nama file: `Laporan_Jadwal_YYYY-MM-DD_HHMMSS.xlsx`

### Teknologi:
- **Library**: PhpSpreadsheet
- **Format**: .xlsx (Excel 2007+)
- **Compatibility**: Excel, Google Sheets, LibreOffice

### Styling:
- **Header**: Background #22c55e, Font putih, Bold
- **Baris Genap**: Background #f0fdf4 (hijau muda)
- **Baris Ganjil**: Background #ffffff (putih)
- **Summary**: Background #dcfce7, Border #22c55e

### File:
- **Controller**: `JadwalController@exportExcel`
- **Route**: `admin.jadwal.export.excel`

## 📘 4. Export WORD

### Cara Menggunakan:
1. Klik tombol **Word** (biru tua)
2. File Word akan **otomatis ter-download**
3. Buka file dengan Microsoft Word atau Google Docs

### Fitur:
- ✅ **Download otomatis**
- ✅ Logo di kop surat (jika file ada)
- ✅ Kop surat lengkap
- ✅ Table dengan border
- ✅ Header hijau (#22c55e) dengan teks putih
- ✅ Zebra striping
- ✅ Summary box
- ✅ Tanda tangan lengkap
- ✅ Nama file: `Laporan_Jadwal_YYYY-MM-DD_HHMMSS.docx`

### Teknologi:
- **Library**: PhpWord
- **Format**: .docx (Word 2007+)
- **Compatibility**: Word, Google Docs, LibreOffice

### Layout:
- **Paper**: A4 Portrait
- **Margin**: 2.5cm semua sisi
- **Font**: Arial, 9-10pt
- **Table**: Full width dengan border hitam

### File:
- **Controller**: `JadwalController@exportWord`
- **Route**: `admin.jadwal.export.word`

## 🖼️ Setup Logo

### Lokasi File:
```
public/images/logo-koperasi.png
```

### Spesifikasi:
- **Format**: PNG (dengan background transparan)
- **Ukuran**: 80x80 pixels (recommended)
- **Resolusi**: 72-150 DPI
- **Warna**: Full color

### Cara Upload:
1. Siapkan file logo PNG (80x80px)
2. Upload ke folder `public/images/`
3. Rename menjadi `logo-koperasi.png`
4. Test export untuk verifikasi

### Jika Logo Tidak Ada:
- Print/PDF: Layout tetap rapi tanpa logo
- Word: Skip logo (conditional check)
- Excel: Skip logo (conditional check)

## ⚙️ Customization

### 1. Mengubah NIP:
Ganti `19XXXXXXXXXXXXXXXXX` dengan NIP sebenarnya di:

**Print View** (`resources/views/admin/jadwal/print.blade.php`):
```html
<p><strong>NIP. 19650815 199203 1 001</strong></p>
```

**PDF View** (`resources/views/admin/jadwal/pdf.blade.php`):
```html
<p class="nip">NIP. 19650815 199203 1 001</p>
```

**Word Export** (`app/Http/Controllers/Admin/JadwalController.php`):
```php
$section->addText('NIP. 19650815 199203 1 001', [
    'bold' => true,
    'size' => 10
], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END]);
```

**Excel Export** (`app/Http/Controllers/Admin/JadwalController.php`):
```php
$sheet->setCellValue('F' . $signRow, 'NIP. 19650815 199203 1 001');
```

### 2. Mengubah Nama Kepala Dinas:
Ganti "Kepala Dinas Perindustrian, Perdagangan dan Koperasi" dengan nama sebenarnya.

Contoh:
```html
<p class="jabatan">Drs. NAMA KEPALA DINAS, M.Si</p>
<p class="jabatan">Kepala Dinas Perindustrian, Perdagangan dan Koperasi</p>
```

### 3. Mengubah Alamat:
Edit alamat di kop surat di semua file export.

## 🧪 Testing

### Test Print:
1. ✅ Buka `/admin/jadwal`
2. ✅ Klik tombol "Print"
3. ✅ Verifikasi logo muncul
4. ✅ Verifikasi kop surat lengkap
5. ✅ Verifikasi data sesuai filter
6. ✅ Verifikasi tanda tangan rapi
7. ✅ Klik "Cetak Dokumen" atau Ctrl+P

### Test PDF:
1. ✅ Klik tombol "PDF"
2. ✅ File harus **otomatis ter-download**
3. ✅ Buka file PDF
4. ✅ Verifikasi logo muncul
5. ✅ Verifikasi kop surat lengkap
6. ✅ Verifikasi data lengkap dengan zebra striping
7. ✅ Verifikasi tanda tangan rapi
8. ✅ Verifikasi nama file: `Laporan_Jadwal_YYYY-MM-DD_HHMMSS.pdf`

### Test Excel:
1. ✅ Klik tombol "Excel"
2. ✅ File harus **otomatis ter-download**
3. ✅ Buka file dengan Excel/Google Sheets
4. ✅ Verifikasi logo di cell A1
5. ✅ Verifikasi kop surat di B1:H4
6. ✅ Verifikasi header hijau dengan teks putih
7. ✅ Verifikasi zebra striping
8. ✅ Verifikasi summary box
9. ✅ Verifikasi tanda tangan di kolom F-H
10. ✅ Verifikasi nama file: `Laporan_Jadwal_YYYY-MM-DD_HHMMSS.xlsx`

### Test Word:
1. ✅ Klik tombol "Word"
2. ✅ File harus **otomatis ter-download**
3. ✅ Buka file dengan Word/Google Docs
4. ✅ Verifikasi logo muncul (jika file ada)
5. ✅ Verifikasi kop surat lengkap
6. ✅ Verifikasi table dengan border
7. ✅ Verifikasi header hijau
8. ✅ Verifikasi zebra striping
9. ✅ Verifikasi tanda tangan rapi
10. ✅ Verifikasi nama file: `Laporan_Jadwal_YYYY-MM-DD_HHMMSS.docx`

### Test dengan Filter:
1. ✅ Pilih "Jenis: Pelatihan/Pembinaan"
2. ✅ Pilih "Status: Selesai"
3. ✅ Klik "Filter"
4. ✅ Export ke semua format (Print, PDF, Excel, Word)
5. ✅ Verifikasi hanya data yang sesuai filter yang muncul

## 🐛 Troubleshooting

### PDF Tidak Ter-download:
**Masalah**: Klik PDF tapi tidak download
**Solusi**:
1. Check browser console (F12) untuk error
2. Pastikan DomPDF terinstall: `composer show barryvdh/laravel-dompdf`
3. Clear cache: `php artisan view:clear && php artisan config:clear`
4. Check permission folder `storage/`

### Logo Tidak Muncul:
**Masalah**: Logo tidak tampil di export
**Solusi**:
1. Pastikan file ada di `public/images/logo-koperasi.png`
2. Check permission file (readable)
3. Check ukuran file (max 2MB)
4. Gunakan format PNG dengan background transparan

### Excel/Word Tidak Ter-download:
**Masalah**: Klik Excel/Word tapi tidak download
**Solusi**:
1. Pastikan PhpSpreadsheet terinstall: `composer show phpoffice/phpspreadsheet`
2. Pastikan PhpWord terinstall: `composer show phpoffice/phpword`
3. Check PHP memory limit (min 256MB)
4. Clear cache: `php artisan view:clear`

### Data Tidak Sesuai Filter:
**Masalah**: Export menampilkan semua data, tidak sesuai filter
**Solusi**:
1. Pastikan filter sudah diklik
2. Check URL ada parameter `?jenis=...&status=...`
3. Refresh halaman dan filter ulang

### Format Berantakan:
**Masalah**: Layout export tidak rapi
**Solusi**:
1. Clear browser cache (Ctrl+Shift+R)
2. Clear Laravel cache: `php artisan view:clear`
3. Check CSS di view file
4. Test dengan browser lain

## 📊 Perbandingan Format

| Fitur | Print | PDF | Excel | Word |
|-------|-------|-----|-------|------|
| Download Otomatis | ❌ | ✅ | ✅ | ✅ |
| Logo | ✅ | ✅ | ✅ | ✅ |
| Zebra Striping | ✅ | ✅ | ✅ | ✅ |
| Editable | ❌ | ❌ | ✅ | ✅ |
| File Size | - | Kecil | Sedang | Sedang |
| Compatibility | Browser | PDF Reader | Excel/Sheets | Word/Docs |
| Best For | Cetak Langsung | Arsip Digital | Analisis Data | Edit Dokumen |

## ✅ Status

**SELESAI & SIAP DIGUNAKAN!**

### Checklist:
- ✅ Print view dengan logo & tanda tangan
- ✅ PDF download otomatis dengan DomPDF
- ✅ Excel download otomatis dengan PhpSpreadsheet
- ✅ Word download otomatis dengan PhpWord
- ✅ Logo di semua format
- ✅ Kop surat lengkap
- ✅ Tanda tangan rapi dengan NIP
- ✅ Filter support
- ✅ Zebra striping
- ✅ Summary box
- ✅ Routes terdaftar
- ✅ Cache cleared

## 📞 Support

Jika ada masalah atau pertanyaan:
1. Check dokumentasi ini terlebih dahulu
2. Check browser console untuk error JavaScript
3. Check Laravel log: `storage/logs/laravel.log`
4. Test dengan data sample terlebih dahulu

---

**Dibuat oleh**: Kiro AI Assistant
**Tanggal**: 6 Mei 2026
**Versi**: 2.0.0 - Complete Export System

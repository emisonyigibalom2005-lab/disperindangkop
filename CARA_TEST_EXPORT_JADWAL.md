# CARA TEST EXPORT JADWAL - VERIFIKASI DATA LENGKAP

## ✅ STATUS: SIAP DIGUNAKAN

Semua fitur export jadwal sudah lengkap dan **4 data jadwal akan tampil semua** di export.

---

## 📋 LANGKAH-LANGKAH TEST

### 1️⃣ Login ke Admin Panel
```
URL: http://localhost/admin/login
Username: admin@example.com (atau username admin Anda)
Password: [password admin Anda]
```

### 2️⃣ Buka Halaman Manajemen Jadwal
```
Menu: Admin → Manajemen Jadwal
URL: http://localhost/admin/jadwal
```

### 3️⃣ Verifikasi Data di Tabel
Pastikan ada **4 data jadwal** yang tampil:
- ✅ Yuk, Jadi Bagian dari Keluarga Besar Koperasi (06/05/2026)
- ✅ Tentang Koperasi Desa/Kelurahan Merah Putih (01/05/2026)
- ✅ Undangan Rapat Anggota Tahunan (RAT) Tahun Buku 2025 (10/04/2026)
- ✅ Yuk, Jadi Bagian dari Keluarga Besar Koperasi (04/04/2026)

### 4️⃣ Test Export Print
1. **Klik tombol "Print" (biru)** di bagian atas
2. **Tab baru akan terbuka** dengan halaman print
3. **Verifikasi**:
   - ✅ Logo Kabupaten Tolikara tampil
   - ✅ Kop surat lengkap
   - ✅ **4 baris data jadwal** tampil di tabel
   - ✅ 8 kolom lengkap (No, Tanggal, Waktu, Judul, Jenis, Lokasi, Petugas, Status)
   - ✅ Summary box: "Total Jadwal: 4 kegiatan"
   - ✅ Signature: Wugi Kogoya, S.P - NIP. 19850215 200604 1 008
4. **Klik tombol "Cetak Dokumen"** untuk print

### 5️⃣ Test Export PDF
1. **Klik tombol "PDF" (merah)**
2. **File PDF akan ter-download** otomatis: `Laporan_Jadwal_2026-05-06_xxxxxx.pdf`
3. **Buka file PDF**
4. **Verifikasi**:
   - ✅ Logo tampil
   - ✅ Kop surat lengkap
   - ✅ **4 baris data jadwal** tampil
   - ✅ 8 kolom lengkap
   - ✅ Format landscape A4
   - ✅ Zebra striping (hijau muda/putih)
   - ✅ Summary box
   - ✅ Signature lengkap

### 6️⃣ Test Export Excel
1. **Klik tombol "Excel" (hijau)**
2. **File Excel akan ter-download**: `Laporan_Jadwal_2026-05-06_xxxxxx.xlsx`
3. **Buka file Excel** (Microsoft Excel / LibreOffice Calc / Google Sheets)
4. **Verifikasi**:
   - ✅ Logo tampil di cell A1
   - ✅ Kop surat dengan merge cells
   - ✅ **4 baris data jadwal** (row 10-13)
   - ✅ 8 kolom lengkap (A-H)
   - ✅ Header hijau (#22c55e)
   - ✅ Zebra striping
   - ✅ Summary box dengan border hijau
   - ✅ Signature di kolom kanan
   - ✅ Column width sudah di-adjust

### 7️⃣ Test Export Word
1. **Klik tombol "Word" (biru)**
2. **File Word akan ter-download**: `Laporan_Jadwal_2026-05-06_xxxxxx.docx`
3. **Buka file Word** (Microsoft Word / LibreOffice Writer / Google Docs)
4. **Verifikasi**:
   - ✅ Logo tampil (70x70px)
   - ✅ Kop surat dalam table
   - ✅ **4 baris data jadwal** tampil
   - ✅ 8 kolom lengkap
   - ✅ Header hijau
   - ✅ Zebra striping
   - ✅ Summary box
   - ✅ Signature lengkap

---

## 🔍 TEST DENGAN FILTER

### Test Filter Jenis:
1. **Pilih "Pelatihan/Pembinaan"** di dropdown Jenis Kegiatan
2. **Klik tombol "Filter"**
3. **Klik tombol "PDF"**
4. **Verifikasi**: File PDF akan menampilkan **4 data** (karena semua data jenis pelatihan)

### Test Filter Status:
1. **Pilih "Berlangsung"** di dropdown Status
2. **Klik tombol "Filter"**
3. **Klik tombol "Excel"**
4. **Verifikasi**: File Excel akan menampilkan **4 data** (karena semua data status berlangsung)

### Reset Filter:
1. **Klik tombol "Reset"**
2. **Semua filter akan di-clear**
3. **Export akan menampilkan semua data lagi**

---

## 📊 CHECKLIST VERIFIKASI

### Data Jadwal (4 data):
- [ ] Data #1: Yuk, Jadi Bagian dari Keluarga Besar Koperasi (06/05/2026, 11:01-11:40)
- [ ] Data #2: Tentang Koperasi Desa/Kelurahan Merah Putih (01/05/2026, 11:02-23:23)
- [ ] Data #3: Undangan Rapat Anggota Tahunan (RAT) (10/04/2026, 16:24-16:24)
- [ ] Data #4: Yuk, Jadi Bagian dari Keluarga Besar Koperasi (04/04/2026, 16:45)

### 8 Kolom Data:
- [ ] No (1, 2, 3, 4)
- [ ] Tanggal (format dd/mm/yyyy)
- [ ] Waktu (format HH:mm - HH:mm)
- [ ] Judul Kegiatan (lengkap)
- [ ] Jenis (Pelatihan/Pembinaan)
- [ ] Lokasi (del, Tolikara, del, del)
- [ ] Petugas (Petugas Dinas)
- [ ] Status (Berlangsung)

### Elemen Dokumen:
- [ ] Logo Kabupaten Tolikara tampil
- [ ] Kop surat lengkap (Nama instansi, alamat, kontak)
- [ ] Judul: "LAPORAN JADWAL KEGIATAN"
- [ ] Tabel dengan border dan zebra striping
- [ ] Summary box: "Total Jadwal: 4 kegiatan"
- [ ] Signature: Karubaga, [tanggal]
- [ ] Signature: Kepala Dinas Perindustrian, Perdagangan dan Koperasi
- [ ] Signature: Kabupaten Tolikara
- [ ] Signature: ( Wugi Kogoya, S.P )
- [ ] Signature: NIP. 19850215 200604 1 008

### Format Export:
- [ ] Print: Halaman print-friendly dengan tombol cetak
- [ ] PDF: Landscape A4, auto-download
- [ ] Excel: XLSX dengan styling, auto-download
- [ ] Word: DOCX dengan table, auto-download

---

## ❗ TROUBLESHOOTING

### Jika data tidak tampil lengkap:

**1. Clear cache browser:**
```
Tekan: Ctrl + Shift + R (hard reload)
Atau: Ctrl + F5
```

**2. Clear cache Laravel:**
```bash
php artisan view:clear
php artisan cache:clear
php artisan config:clear
```

**3. Cek data di database:**
```bash
php artisan tinker
>>> App\Models\Jadwal::count()
# Harus return: 4
>>> App\Models\Jadwal::latest('tanggal')->get()
# Harus tampil 4 data
```

### Jika logo tidak tampil:

**1. Cek file logo:**
```bash
# Di Windows PowerShell:
Test-Path public/logo.png
# Harus return: True
```

**2. Cek permission:**
- File `public/logo.png` harus readable
- Jika tidak ada, copy logo dari folder lain

### Jika export error:

**1. Cek library terinstall:**
```bash
composer show | Select-String "dompdf"
composer show | Select-String "phpspreadsheet"
composer show | Select-String "phpword"
```

**2. Install jika belum ada:**
```bash
composer require barryvdh/laravel-dompdf
composer require phpoffice/phpspreadsheet
composer require phpoffice/phpword
```

**3. Cek memory limit:**
- Edit `php.ini`
- Set: `memory_limit = 256M`
- Restart web server

---

## 🎯 HASIL YANG DIHARAPKAN

Setelah test, Anda harus mendapatkan:

✅ **4 file export** (Print view, PDF, Excel, Word)  
✅ **Semua file menampilkan 4 data jadwal lengkap**  
✅ **8 kolom data tampil sempurna**  
✅ **Logo, kop surat, dan signature lengkap**  
✅ **Format dokumen rapi dan profesional**  
✅ **Filter berfungsi dengan baik**  

---

## 📞 SUPPORT

Jika masih ada masalah:
1. Cek file `ADMIN_JADWAL_EXPORT_VERIFICATION.md` untuk detail teknis
2. Cek log Laravel: `storage/logs/laravel.log`
3. Cek browser console untuk JavaScript error (F12)

---

**Dibuat**: 6 Mei 2026  
**Status**: READY TO TEST  
**Data**: 4 jadwal kegiatan  
**Export**: Print, PDF, Excel, Word  

# 📋 Panduan Lengkap Periode Pendaftaran Anggota Koperasi

## 🎯 Masalah yang Sering Terjadi

### ❌ **Masalah: "Periode sudah dibuka di admin tapi user masih lihat tutup"**

**Penyebab:**
1. **Kuota Penuh** - Jumlah pendaftar sudah mencapai batas kuota
2. **Status Nonaktif** - Status periode masih 'nonaktif' di database
3. **Cache Browser** - Browser user masih menyimpan halaman lama

---

## ✅ Solusi Lengkap

### 1️⃣ **Cek Status Periode di Database**

Jalankan query ini di database:

```sql
SELECT 
    id,
    nama_periode,
    status,
    kuota,
    jumlah_pendaftar,
    CASE 
        WHEN status = 'aktif' AND (kuota IS NULL OR jumlah_pendaftar < kuota) THEN '✅ BUKA'
        WHEN status = 'aktif' AND jumlah_pendaftar >= kuota THEN '⚠️ PENUH'
        ELSE '❌ TUTUP'
    END AS status_pendaftaran
FROM periode_pendaftaran
ORDER BY id DESC;
```

### 2️⃣ **Aktifkan Periode Pendaftaran**

**Cara 1: Melalui Admin Panel**
1. Login sebagai Admin
2. Buka menu **Periode Pendaftaran**
3. Klik tombol **Toggle Status** pada periode yang ingin diaktifkan
4. Status akan berubah menjadi **AKTIF** (hijau)

**Cara 2: Melalui Database**
```sql
-- Nonaktifkan semua periode dulu
UPDATE periode_pendaftaran SET status = 'nonaktif';

-- Aktifkan periode tertentu (ganti 1 dengan ID periode)
UPDATE periode_pendaftaran SET status = 'aktif' WHERE id = 1;
```

### 3️⃣ **Mengatasi Kuota Penuh**

**Opsi A: Tambah Kuota**
```sql
-- Tambah kuota menjadi 50 orang
UPDATE periode_pendaftaran SET kuota = 50 WHERE id = 1;
```

**Opsi B: Hapus Batas Kuota (Unlimited)**
```sql
-- Set kuota menjadi NULL (unlimited)
UPDATE periode_pendaftaran SET kuota = NULL WHERE id = 1;
```

**Opsi C: Reset Jumlah Pendaftar**
```sql
-- HATI-HATI: Ini akan reset counter pendaftar
UPDATE periode_pendaftaran SET jumlah_pendaftar = 0 WHERE id = 1;
```

### 4️⃣ **Clear Cache Browser User**

Minta user untuk:
1. Tekan `Ctrl + Shift + R` (Windows/Linux)
2. Tekan `Cmd + Shift + R` (Mac)
3. Atau buka halaman dalam mode Incognito/Private

---

## 🔍 Cara Kerja Sistem

### **Logika Pendaftaran Terbuka/Tutup**

```
Pendaftaran BUKA jika:
✅ status = 'aktif'
✅ kuota = NULL (unlimited) ATAU jumlah_pendaftar < kuota

Pendaftaran TUTUP jika:
❌ status = 'nonaktif'
❌ jumlah_pendaftar >= kuota (kuota penuh)
```

### **File yang Terlibat**

1. **Model**: `app/Models/PeriodePendaftaran.php`
   - Method `getIsBukaAttribute()` - Cek apakah pendaftaran buka
   - Scope `aktif()` - Filter periode aktif

2. **Controller**: `app/Http/Controllers/PendaftaranAnggotaController.php`
   - Method `index()` - Cek periode dan redirect ke form/tutup

3. **View**: 
   - `resources/views/public/pendaftaran-anggota.blade.php` - Form pendaftaran
   - `resources/views/public/pendaftaran-tutup.blade.php` - Halaman tutup

---

## 📊 Monitoring Periode Pendaftaran

### **Query Monitoring**

```sql
-- Lihat semua periode dengan detail
SELECT 
    id,
    nama_periode,
    tahun_ajaran,
    DATE_FORMAT(tanggal_mulai, '%d %b %Y') as mulai,
    DATE_FORMAT(tanggal_selesai, '%d %b %Y') as selesai,
    status,
    CONCAT(jumlah_pendaftar, ' / ', IFNULL(kuota, '∞')) as pendaftar,
    CASE 
        WHEN status = 'aktif' AND (kuota IS NULL OR jumlah_pendaftar < kuota) THEN '✅ BUKA'
        WHEN status = 'aktif' AND jumlah_pendaftar >= kuota THEN '⚠️ PENUH'
        ELSE '❌ TUTUP'
    END as status_pendaftaran
FROM periode_pendaftaran
ORDER BY id DESC;
```

### **Cek Pendaftar per Periode**

```sql
SELECT 
    pp.nama_periode,
    pp.status,
    pp.kuota,
    COUNT(a.id) as total_pendaftar,
    COUNT(CASE WHEN a.status = 'Pending' THEN 1 END) as pending,
    COUNT(CASE WHEN a.status = 'Aktif' THEN 1 END) as aktif,
    COUNT(CASE WHEN a.status = 'Nonaktif' THEN 1 END) as nonaktif
FROM periode_pendaftaran pp
LEFT JOIN anggotas a ON a.periode_pendaftaran_id = pp.id
GROUP BY pp.id
ORDER BY pp.id DESC;
```

---

## 🛠️ Troubleshooting

### **Problem 1: User masih lihat "Tutup" padahal sudah aktif**

**Solusi:**
1. Cek status di database: `SELECT status FROM periode_pendaftaran WHERE id = 1;`
2. Pastikan status = 'aktif'
3. Cek kuota: `SELECT kuota, jumlah_pendaftar FROM periode_pendaftaran WHERE id = 1;`
4. Jika penuh, tambah kuota atau set NULL
5. Minta user clear cache browser

### **Problem 2: Tombol Toggle tidak bekerja**

**Solusi:**
1. Cek route: `php artisan route:list | grep periode-pendaftaran`
2. Pastikan ada route `periode-pendaftaran.toggle`
3. Cek permission user di database
4. Clear cache Laravel: `php artisan cache:clear`

### **Problem 3: Counter jumlah_pendaftar tidak update**

**Solusi:**
1. Cek trigger/event di database
2. Manual update: 
```sql
UPDATE periode_pendaftaran pp
SET jumlah_pendaftar = (
    SELECT COUNT(*) 
    FROM anggotas a 
    WHERE a.periode_pendaftaran_id = pp.id
)
WHERE pp.id = 1;
```

---

## 📝 Checklist Membuka Periode Baru

- [ ] Buat periode baru di menu Admin > Periode Pendaftaran
- [ ] Isi nama periode (contoh: "Pendaftaran Anggota 2026")
- [ ] Isi tahun ajaran (contoh: "2026")
- [ ] Set tanggal mulai dan selesai
- [ ] Set kuota (atau kosongkan untuk unlimited)
- [ ] Klik **Simpan**
- [ ] Klik tombol **Toggle Status** untuk aktifkan
- [ ] Pastikan status berubah menjadi **AKTIF** (hijau)
- [ ] Test dengan buka halaman pendaftaran di browser incognito
- [ ] Verifikasi form pendaftaran muncul (bukan halaman tutup)

---

## 🎨 Tampilan Status

### **Di Admin Panel**

```
Status: AKTIF (badge hijau)
Kuota: 25 / 50 orang
Sisa: 25 orang
Status Pendaftaran: Dibuka
```

### **Di Halaman Public**

**Jika BUKA:**
- Tampil form pendaftaran lengkap
- Banner hijau "Pendaftaran Dibuka"
- Info kuota tersisa

**Jika TUTUP:**
- Tampil halaman "Kuota Pendaftaran Penuh"
- Banner merah/orange
- Info periode dan kuota
- Tombol "Kembali ke Beranda" dan "Hubungi Kami"

---

## 📞 Kontak Support

Jika masih ada masalah:
1. Screenshot halaman error
2. Screenshot status di admin panel
3. Kirim ke: disperindagkop@tolikara.go.id
4. Atau hubungi: (0969) 12345

---

## 🔄 Update Log

- **2026-05-06**: Perbaikan tampilan halaman tutup
- **2026-05-06**: Tambah dokumentasi lengkap
- **2026-05-06**: Tambah script SQL untuk troubleshooting

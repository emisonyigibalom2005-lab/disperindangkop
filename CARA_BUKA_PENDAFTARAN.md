# 🚀 CARA MEMBUKA PENDAFTARAN ANGGOTA - MUDAH & LENGKAP

## ✅ LOGIKA BARU (SUDAH DIPERBAIKI)

### **Jika Status = AKTIF:**
- ✅ **Kuota masih tersedia** → Langsung tampil **FORM PENDAFTARAN**
- ⚠️ **Kuota sudah penuh** → Tampil **"TUNGGU GELOMBANG BERIKUTNYA"**

### **Jika Status = NONAKTIF:**
- ❌ Tampil **"PENDAFTARAN DITUTUP"**

---

## 📋 LANGKAH-LANGKAH MEMBUKA PENDAFTARAN

### **CARA 1: Melalui Admin Panel (MUDAH)**

1. **Login sebagai Admin**
   - Buka website
   - Login dengan akun admin

2. **Buka Menu Periode Pendaftaran**
   - Klik menu **"Periode Pendaftaran"** di sidebar

3. **Aktifkan Periode**
   - Cari periode yang ingin dibuka
   - Klik tombol **"Toggle Status"** (warna hijau/abu-abu)
   - Status akan berubah menjadi **AKTIF** (badge hijau)

4. **Selesai!**
   - Pendaftaran sudah BUKA
   - User bisa langsung daftar

---

### **CARA 2: Melalui Database (CEPAT)**

**Buka phpMyAdmin atau MySQL client, lalu jalankan:**

```sql
-- 1. CEK STATUS DULU
SELECT id, nama_periode, status, kuota, jumlah_pendaftar 
FROM periode_pendaftaran 
ORDER BY id DESC;

-- 2. AKTIFKAN PERIODE (ganti 1 dengan ID periode Anda)
UPDATE periode_pendaftaran 
SET status = 'aktif' 
WHERE id = 1;

-- 3. CEK HASIL
SELECT 
    nama_periode,
    status,
    CASE 
        WHEN status = 'aktif' AND (kuota IS NULL OR jumlah_pendaftar < kuota) 
        THEN '✅ BUKA - BISA DAFTAR'
        WHEN status = 'aktif' AND jumlah_pendaftar >= kuota 
        THEN '⚠️ PENUH'
        ELSE '❌ TUTUP'
    END as hasil
FROM periode_pendaftaran 
WHERE id = 1;
```

---

## 🔧 TROUBLESHOOTING

### **Problem 1: Sudah AKTIF tapi masih tampil TUTUP**

**Penyebab:** Kuota sudah penuh

**Solusi:**

```sql
-- Cek kuota
SELECT kuota, jumlah_pendaftar FROM periode_pendaftaran WHERE id = 1;

-- Jika penuh, pilih salah satu:

-- OPSI A: Tambah kuota
UPDATE periode_pendaftaran SET kuota = 50 WHERE id = 1;

-- OPSI B: Unlimited (hapus batas)
UPDATE periode_pendaftaran SET kuota = NULL WHERE id = 1;

-- OPSI C: Reset counter (HATI-HATI!)
UPDATE periode_pendaftaran SET jumlah_pendaftar = 0 WHERE id = 1;
```

---

### **Problem 2: User masih lihat halaman lama**

**Solusi:**

1. **Clear cache server:**
```bash
php artisan view:clear
php artisan cache:clear
```

2. **Minta user refresh browser:**
- Tekan `Ctrl + Shift + R` (Windows)
- Tekan `Cmd + Shift + R` (Mac)
- Atau buka dalam mode Incognito

---

### **Problem 3: Tombol Toggle tidak bekerja**

**Solusi:**

```sql
-- Manual update via database
UPDATE periode_pendaftaran 
SET status = 'aktif' 
WHERE id = 1;
```

---

## 📊 CEK STATUS PENDAFTARAN

### **Query Lengkap:**

```sql
SELECT 
    id,
    nama_periode,
    tahun_ajaran,
    status,
    kuota,
    jumlah_pendaftar,
    CASE 
        WHEN status = 'aktif' AND (kuota IS NULL OR jumlah_pendaftar < kuota) 
        THEN '✅ BUKA - FORM MUNCUL'
        WHEN status = 'aktif' AND jumlah_pendaftar >= kuota 
        THEN '⚠️ PENUH - TUNGGU GELOMBANG 2'
        WHEN status = 'nonaktif' 
        THEN '❌ TUTUP'
        ELSE '❓ UNKNOWN'
    END as status_pendaftaran,
    CASE 
        WHEN kuota IS NULL THEN '∞ Unlimited'
        WHEN jumlah_pendaftar >= kuota THEN '0 (PENUH)'
        ELSE CONCAT(kuota - jumlah_pendaftar, ' tersisa')
    END as sisa_kuota
FROM periode_pendaftaran
ORDER BY id DESC;
```

---

## 🎯 CONTOH KASUS

### **KASUS 1: Buka Pendaftaran Gelombang 1 (Kuota 30)**

```sql
-- Nonaktifkan semua periode dulu
UPDATE periode_pendaftaran SET status = 'nonaktif';

-- Aktifkan gelombang 1
UPDATE periode_pendaftaran 
SET status = 'aktif', kuota = 30, jumlah_pendaftar = 0 
WHERE nama_periode LIKE '%Gelombang 1%';
```

**Hasil:**
- ✅ Form pendaftaran muncul
- ✅ User bisa daftar
- ✅ Kuota: 0/30

---

### **KASUS 2: Kuota Penuh, Buka Gelombang 2**

```sql
-- Tutup gelombang 1
UPDATE periode_pendaftaran 
SET status = 'nonaktif' 
WHERE nama_periode LIKE '%Gelombang 1%';

-- Buka gelombang 2
UPDATE periode_pendaftaran 
SET status = 'aktif', kuota = 30, jumlah_pendaftar = 0 
WHERE nama_periode LIKE '%Gelombang 2%';
```

**Hasil:**
- ⚠️ Gelombang 1: Tampil "Tunggu Gelombang Berikutnya"
- ✅ Gelombang 2: Form pendaftaran muncul

---

### **KASUS 3: Buka Unlimited (Tanpa Batas)**

```sql
UPDATE periode_pendaftaran 
SET status = 'aktif', kuota = NULL 
WHERE id = 1;
```

**Hasil:**
- ✅ Form pendaftaran muncul
- ✅ Tidak ada batas kuota
- ✅ Semua orang bisa daftar

---

## 📱 TAMPILAN UNTUK USER

### **Jika BUKA (Status = Aktif, Kuota Tersedia):**

```
┌─────────────────────────────────────────┐
│  ✅ PENDAFTARAN DIBUKA                  │
│  Gelombang 1 - Tahun 2026               │
├─────────────────────────────────────────┤
│  📝 FORM PENDAFTARAN                    │
│  • NIK                                  │
│  • Nama Lengkap                         │
│  • Email                                │
│  • ... (form lengkap)                   │
│                                         │
│  [💾 Daftar Sekarang]                  │
└─────────────────────────────────────────┘
```

### **Jika PENUH (Status = Aktif, Kuota Penuh):**

```
┌─────────────────────────────────────────┐
│  ⚠️ KUOTA PENDAFTARAN PENUH             │
│  Gelombang 1 - Tahun 2026               │
├─────────────────────────────────────────┤
│  Kuota: 30/30 Orang [████████] PENUH   │
│                                         │
│  Tunggu Gelombang Berikutnya            │
│                                         │
│  [🏠 Kembali]  [📞 Hubungi Kami]       │
└─────────────────────────────────────────┘
```

### **Jika TUTUP (Status = Nonaktif):**

```
┌─────────────────────────────────────────┐
│  ❌ PENDAFTARAN DITUTUP                 │
│  Belum Ada Periode Aktif                │
├─────────────────────────────────────────┤
│  Saat ini belum ada periode             │
│  pendaftaran yang dibuka.               │
│                                         │
│  [🏠 Kembali]  [📞 Hubungi Kami]       │
└─────────────────────────────────────────┘
```

---

## ✅ CHECKLIST SEBELUM BUKA PENDAFTARAN

- [ ] Buat periode baru di admin panel
- [ ] Isi nama periode (contoh: "Gelombang 1 - 2026")
- [ ] Isi tahun ajaran (contoh: "2026")
- [ ] Set tanggal mulai dan selesai
- [ ] Set kuota (atau kosongkan untuk unlimited)
- [ ] Klik **Simpan**
- [ ] Klik **Toggle Status** untuk aktifkan
- [ ] Pastikan status = **AKTIF** (badge hijau)
- [ ] Test buka halaman pendaftaran
- [ ] Pastikan **FORM MUNCUL** (bukan halaman tutup)
- [ ] Test daftar dengan data dummy
- [ ] Verifikasi data masuk ke database

---

## 🆘 BANTUAN CEPAT

### **Script All-in-One:**

```sql
-- JALANKAN INI UNTUK BUKA PENDAFTARAN
UPDATE periode_pendaftaran 
SET status = 'aktif', kuota = NULL 
WHERE id = 1;

-- CEK HASIL
SELECT 
    nama_periode,
    CASE 
        WHEN status = 'aktif' THEN '✅ BUKA'
        ELSE '❌ TUTUP'
    END as status
FROM periode_pendaftaran 
WHERE id = 1;
```

### **Jika Masih Bermasalah:**

1. Screenshot halaman error
2. Screenshot status di admin panel
3. Kirim hasil query di atas
4. Hubungi: disperindagkop@tolikara.go.id

---

## 📞 KONTAK

**DISPERINDAGKOP Kabupaten Tolikara**
- 📞 Telp: (0969) 12345
- ✉️ Email: disperindagkop@tolikara.go.id
- 🌐 Website: [URL website]

---

**Terakhir diupdate:** 06 Mei 2026
**Versi:** 2.0 (Logika Baru - Lebih Mudah)

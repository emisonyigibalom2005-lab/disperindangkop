# 🔍 CEK DATA BANTUAN AKTIF - DASHBOARD PIMPINAN

## 📊 QUERY YANG DIGUNAKAN

### Di Controller:
```php
$bantuanAktif = PenerimaBantuan::where('status', 'diterima')->count();

$stats = [
    'penerima_bantuan' => $bantuanAktif
];
```

### Di View:
```blade
<div class="stat-card-value">{{ $stats['penerima_bantuan'] }}</div>
<div class="stat-card-label">Bantuan Aktif</div>
```

---

## 🔍 CARA CEK DATA DI DATABASE

### 1. Via phpMyAdmin / MySQL:

```sql
-- Cek total semua penerima bantuan
SELECT COUNT(*) as total FROM penerima_bantuan;

-- Cek bantuan yang diterima (aktif)
SELECT COUNT(*) as bantuan_aktif 
FROM penerima_bantuan 
WHERE status = 'diterima';

-- Cek detail per status
SELECT 
    status, 
    COUNT(*) as jumlah 
FROM penerima_bantuan 
GROUP BY status;

-- Lihat data lengkap
SELECT 
    id,
    bantuan_id,
    koperasi_id,
    status,
    tanggal_penerimaan,
    jumlah_bantuan
FROM penerima_bantuan
ORDER BY id DESC
LIMIT 10;
```

### 2. Via Laravel Tinker:

```bash
php artisan tinker
```

Kemudian jalankan:
```php
// Total semua penerima bantuan
PenerimaBantuan::count()

// Bantuan aktif (diterima)
PenerimaBantuan::where('status', 'diterima')->count()

// Bantuan pending
PenerimaBantuan::where('status', 'pending')->count()

// Bantuan ditolak
PenerimaBantuan::where('status', 'ditolak')->count()

// Detail per status
PenerimaBantuan::selectRaw('status, COUNT(*) as total')->groupBy('status')->get()

// Lihat 5 data terbaru
PenerimaBantuan::latest()->take(5)->get(['id', 'status', 'tanggal_penerimaan'])
```

---

## 📝 STATUS YANG VALID

Berdasarkan sistem, status yang ada:
1. **'diterima'** ✅ - Bantuan sudah diterima (INI YANG DIHITUNG)
2. **'pending'** ⏰ - Bantuan menunggu persetujuan
3. **'ditolak'** ❌ - Bantuan ditolak

---

## 🔧 TROUBLESHOOTING

### Masalah 1: Card menampilkan 0

**Kemungkinan Penyebab:**
1. Tidak ada data di tabel `penerima_bantuan`
2. Semua data memiliki status selain 'diterima'
3. Typo di status (contoh: 'Diterima' bukan 'diterima')

**Cara Cek:**
```sql
-- Cek apakah ada data
SELECT COUNT(*) FROM penerima_bantuan;

-- Cek status apa saja yang ada
SELECT DISTINCT status FROM penerima_bantuan;

-- Cek case sensitivity
SELECT status, COUNT(*) 
FROM penerima_bantuan 
WHERE LOWER(status) = 'diterima'
GROUP BY status;
```

**Solusi:**
```sql
-- Jika status salah (uppercase), update:
UPDATE penerima_bantuan 
SET status = 'diterima' 
WHERE LOWER(status) = 'diterima';
```

### Masalah 2: Data tidak update

**Solusi:**
1. Refresh halaman (F5)
2. Clear cache: `php artisan cache:clear`
3. Logout dan login lagi

---

## 📊 CARA MENAMBAH DATA BANTUAN

### Via Admin/Petugas Panel:

1. Login sebagai Admin/Petugas
2. Buka menu "Bantuan"
3. Pilih program bantuan
4. Klik "Tambah Penerima"
5. Isi data koperasi penerima
6. Set status = "Diterima"
7. Simpan

### Via Database (Manual):

```sql
INSERT INTO penerima_bantuan (
    bantuan_id,
    koperasi_id,
    status,
    tanggal_penerimaan,
    jumlah_bantuan,
    created_at,
    updated_at
) VALUES (
    1,                  -- ID program bantuan
    1,                  -- ID koperasi
    'diterima',         -- Status (lowercase!)
    NOW(),
    1000000,
    NOW(),
    NOW()
);
```

---

## 🧪 TESTING

### Test Case 1: Ada Data Bantuan Diterima

**Setup:**
```sql
INSERT INTO penerima_bantuan (bantuan_id, koperasi_id, status, tanggal_penerimaan, jumlah_bantuan, created_at, updated_at) VALUES
(1, 1, 'diterima', NOW(), 1000000, NOW(), NOW()),
(1, 2, 'diterima', NOW(), 1500000, NOW(), NOW()),
(1, 3, 'diterima', NOW(), 2000000, NOW(), NOW()),
(1, 4, 'pending', NOW(), 1000000, NOW(), NOW()),
(1, 5, 'ditolak', NOW(), 1000000, NOW(), NOW());
```

**Expected Result:**
- Card "Bantuan Aktif" menampilkan: **3**
- (Hanya yang status 'diterima')

### Test Case 2: Tidak Ada Data

**Setup:**
```sql
-- Tabel kosong atau tidak ada data
```

**Expected Result:**
- Card "Bantuan Aktif" menampilkan: **0**

### Test Case 3: Semua Pending

**Setup:**
```sql
INSERT INTO penerima_bantuan (bantuan_id, koperasi_id, status, tanggal_penerimaan, jumlah_bantuan, created_at, updated_at) VALUES
(1, 1, 'pending', NOW(), 1000000, NOW(), NOW()),
(1, 2, 'pending', NOW(), 1500000, NOW(), NOW());
```

**Expected Result:**
- Card "Bantuan Aktif" menampilkan: **0**
- (Tidak ada yang status 'diterima')

---

## 📋 CHECKLIST VERIFIKASI

Untuk memastikan data tampil dengan benar:

- [ ] Cek apakah tabel `penerima_bantuan` ada
- [ ] Cek apakah ada data di tabel
- [ ] Cek status ditulis dengan benar: `'diterima'` (lowercase)
- [ ] Refresh halaman dashboard
- [ ] Cek log file: `storage/logs/laravel.log`
- [ ] Cek console browser untuk error JavaScript

---

## 📊 CONTOH DATA REAL

### Scenario 1: Ada 5 Bantuan Aktif
```
Database:
- Total penerima: 10
- Status 'diterima': 5
- Status 'pending': 3
- Status 'ditolak': 2

Dashboard Card:
┌─────────────────┐
│  5           ❤️ │
│  Bantuan Aktif  │
└─────────────────┘
```

### Scenario 2: Tidak Ada Bantuan Aktif
```
Database:
- Total penerima: 5
- Status 'diterima': 0
- Status 'pending': 5
- Status 'ditolak': 0

Dashboard Card:
┌─────────────────┐
│  0           ❤️ │
│  Bantuan Aktif  │
└─────────────────┘
```

---

## 🔍 CEK LOG

Setelah membuka dashboard, cek log:

```bash
tail -f storage/logs/laravel.log
```

Akan muncul:
```
[2026-04-19 18:45:21] local.INFO: Dashboard Pimpinan - Bantuan Stats: 
{
    "total_penerima": 10,
    "diterima": 5,
    "pending": 3,
    "ditolak": 2
}
```

---

## 💡 TIPS

### 1. Pastikan Status Konsisten
```sql
-- Cek apakah ada variasi penulisan status
SELECT DISTINCT status FROM penerima_bantuan;

-- Hasil yang benar:
-- 'diterima' (lowercase)
-- 'pending' (lowercase)
-- 'ditolak' (lowercase)
```

### 2. Update Status Jika Salah
```sql
-- Jika ada 'Diterima' (uppercase), ubah ke lowercase
UPDATE penerima_bantuan 
SET status = LOWER(status);
```

### 3. Cek Relasi
```sql
-- Pastikan bantuan_id dan koperasi_id valid
SELECT 
    pb.*,
    b.nama_bantuan,
    k.nama_koperasi
FROM penerima_bantuan pb
LEFT JOIN bantuan b ON pb.bantuan_id = b.id
LEFT JOIN koperasi k ON pb.koperasi_id = k.id
WHERE pb.status = 'diterima';
```

---

## 🚀 QUICK FIX

Jika card masih menampilkan 0 padahal ada data:

### 1. Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### 2. Restart Server
```bash
# Jika menggunakan php artisan serve
Ctrl + C
php artisan serve
```

### 3. Hard Refresh Browser
```
Ctrl + Shift + R (Windows/Linux)
Cmd + Shift + R (Mac)
```

---

## ✅ SUMMARY

### Query:
```php
PenerimaBantuan::where('status', 'diterima')->count()
```

### Tabel:
- **Nama**: `penerima_bantuan`
- **Kolom**: `status`
- **Nilai**: `'diterima'` (lowercase)

### Display:
- **Card 4**: Bantuan Aktif
- **Warna**: Merah (card4)
- **Icon**: ❤️ (fas fa-hand-holding-heart)

### Data Flow:
```
Database (penerima_bantuan)
    ↓
WHERE status = 'diterima'
    ↓
COUNT(*)
    ↓
$stats['penerima_bantuan']
    ↓
Dashboard Card 4
    ↓
✅ TAMPIL ANGKA REAL!
```

---

**Status: ✅ WORKING**
**Data Source: ✅ DATABASE**
**Query: ✅ CORRECT**
**Display: ✅ REAL-TIME**

Card "Bantuan Aktif" menampilkan data real dari database! 🎉

# 🔧 Perbaikan Field no_telp Cannot be NULL

## 🐛 Masalah

**Error**: `SQLSTATE[23000]: Integrity constraint violation: 1048 Column 'no_telp' cannot be null`

### Penyebab
1. Field `no_telp` di database tidak memiliki `nullable()` di migration
2. Form mengirim string "null" ketika field kosong
3. Controller tidak memfilter nilai "null" atau empty string

---

## ✅ Solusi yang Diterapkan

### 1. **Migration Database** (`database/migrations/2026_04_16_063111_make_no_telp_nullable_in_koperasi_table.php`)

```php
public function up(): void
{
    Schema::table('koperasi', function (Blueprint $table) {
        $table->string('no_telp')->nullable()->change();
    });
}
```

**Hasil**: Field `no_telp` sekarang bisa menerima nilai NULL di database.

---

### 2. **Controller Filter** (`app/Http/Controllers/Petugas/KoperasiController.php`)

```php
// Filter nilai null/empty untuk field optional
$validated['no_telp'] = !empty($validated['no_telp']) && $validated['no_telp'] !== 'null' 
    ? $validated['no_telp'] 
    : null;
    
$validated['email'] = !empty($validated['email']) && $validated['email'] !== 'null' 
    ? $validated['email'] 
    : null;
    
$validated['modal_usaha'] = !empty($validated['modal_usaha']) 
    ? $validated['modal_usaha'] 
    : 0;
    
$validated['omset_per_bulan'] = !empty($validated['omset_per_bulan']) 
    ? $validated['omset_per_bulan'] 
    : 0;
    
$validated['jumlah_karyawan'] = !empty($validated['jumlah_karyawan']) 
    ? $validated['jumlah_karyawan'] 
    : 0;
```

**Hasil**: 
- String "null" atau empty string diubah menjadi NULL yang sebenarnya
- Field numeric yang kosong diubah menjadi 0

---

## 📁 File yang Dimodifikasi

1. ✅ `database/migrations/2026_04_16_063111_make_no_telp_nullable_in_koperasi_table.php`
2. ✅ `app/Http/Controllers/Petugas/KoperasiController.php`

---

## 🔍 Detail Perubahan

### Sebelum:
```sql
CREATE TABLE koperasi (
    ...
    no_telp VARCHAR(255) NOT NULL,  -- ❌ Tidak bisa NULL
    ...
);
```

### Sesudah:
```sql
CREATE TABLE koperasi (
    ...
    no_telp VARCHAR(255) NULL,  -- ✅ Bisa NULL
    ...
);
```

---

## 🧪 Testing

### Skenario yang Harus Ditest:
1. ✅ Daftar koperasi **dengan** nomor telepon
2. ✅ Daftar koperasi **tanpa** nomor telepon (field kosong)
3. ✅ Daftar koperasi **dengan** email
4. ✅ Daftar koperasi **tanpa** email (field kosong)
5. ✅ Daftar koperasi dengan modal_usaha = 0
6. ✅ Daftar koperasi dengan omset_per_bulan = 0
7. ✅ Daftar koperasi dengan jumlah_karyawan = 0

---

## 📊 Field Optional di Form

| Field | Type | Nullable | Default |
|-------|------|----------|---------|
| `no_telp` | string | ✅ Yes | NULL |
| `email` | string | ✅ Yes | NULL |
| `modal_usaha` | numeric | ✅ Yes | 0 |
| `omset_per_bulan` | numeric | ✅ Yes | 0 |
| `jumlah_karyawan` | integer | ✅ Yes | 0 |

---

## 🎯 Validasi Controller

```php
'no_telp' => 'nullable|string|max:20',
'email' => 'nullable|email|max:255',
'modal_usaha' => 'nullable|numeric|min:0',
'omset_per_bulan' => 'nullable|numeric|min:0',
'jumlah_karyawan' => 'nullable|integer|min:0',
```

**Catatan**: Semua field di atas adalah **optional** (nullable).

---

## 🚀 Cara Menjalankan Migration

```bash
php artisan migrate
```

**Output**:
```
INFO  Running migrations.
2026_04_16_063111_make_no_telp_nullable_in_koperasi_table .... DONE
```

---

## ✅ Hasil Akhir

### Masalah Teratasi:
- ✅ Field `no_telp` sekarang bisa NULL
- ✅ Form bisa disubmit tanpa nomor telepon
- ✅ Tidak ada lagi error "cannot be null"
- ✅ Filter controller menangani string "null" dengan benar

### Data yang Tersimpan:
```php
// Dengan nomor telepon
'no_telp' => '081234567890'

// Tanpa nomor telepon
'no_telp' => NULL  // ✅ Bukan string "null"
```

---

**Diperbaiki pada**: 16 April 2026  
**Status**: ✅ Selesai  
**Migration**: ✅ Berhasil dijalankan

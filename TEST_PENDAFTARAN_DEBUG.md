# Debug Pendaftaran Anggota - Error Database

## Perbaikan yang Sudah Dilakukan

### 1. ✅ Hapus Field yang Tidak Ada di Tabel Anggotas
**Masalah**: Field `password`, `password_confirmation`, dan `email` tidak ada di tabel `anggotas`

**Solusi**:
```php
// Hapus field yang tidak ada di tabel anggotas
unset($validated['password']);
unset($validated['password_confirmation']);
unset($validated['email']); // Email sudah disimpan di tabel users
```

### 2. ✅ Set Default Values untuk Field Opsional
**Masalah**: Field numeric yang kosong bisa menyebabkan error

**Solusi**:
```php
$defaults = [
    'lama_berdiri_usaha' => $validated['lama_berdiri_usaha'] ?? 0,
    'jumlah_karyawan' => $validated['jumlah_karyawan'] ?? 0,
    'modal_usaha' => $validated['modal_usaha'] ?? 0,
    'omzet_per_bulan' => $validated['omzet_per_bulan'] ?? 0,
    'simpanan_pokok' => $validated['simpanan_pokok'] ?? 0,
    'simpanan_wajib' => $validated['simpanan_wajib'] ?? 0,
    'kabupaten' => $validated['kabupaten'] ?? 'Tolikara',
];
```

### 3. ✅ Tambah Logging Detail
**Tujuan**: Untuk debugging error database

**Log yang Ditambahkan**:
- Log data yang akan disimpan
- Log error database dengan detail SQL
- Log error general dengan stack trace

---

## Cara Test Pendaftaran

### 1. Clear Cache Dulu
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### 2. Buka Form Pendaftaran
```
http://localhost/pendaftaran
```

### 3. Isi Form dengan Data Test

**Step 1: Data Pribadi**
```
NIK: 9113211112309005
Nama: TEST USER BARU
Tempat Lahir: Benari
Tanggal Lahir: 01/01/2000
Jenis Kelamin: Laki-laki
Status Perkawinan: Kawin
Pendidikan: SMP
Agama: Islam
No. HP: 081234567890
Email: testuser5@gmail.com
Password: 123456
Konfirmasi Password: 123456
```

**Step 2: Alamat**
```
Distrik: Karubaga
```

**Step 3: Data Usaha & Ahli Waris**
```
Nama Usaha: Toko Test
Bidang Usaha: Perdagangan

Nama Ahli Waris: Ahli Waris Test
Hubungan: Suami/Istri
No. HP Ahli Waris: 081234567891
NIK Ahli Waris: 9113211112309006
```

**Step 4: Upload Foto**
```
Upload foto (JPG/PNG, max 2MB)
```

### 4. Submit Form

---

## Jika Masih Error - Cek Log

### Lokasi Log File
```
storage/logs/laravel.log
```

### Cara Melihat Log Real-time
```bash
# Windows PowerShell
Get-Content storage/logs/laravel.log -Tail 50 -Wait

# Atau buka file langsung
notepad storage/logs/laravel.log
```

### Cari Error Terbaru
Cari baris yang mengandung:
- `Pendaftaran Anggota - Database Error`
- `Pendaftaran Anggota - General Error`
- `Pendaftaran Anggota - Data yang akan disimpan`

---

## Analisis Error dari Log

### Error 1: Column not found
```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'xxx' in 'field list'
```

**Artinya**: Ada field yang tidak ada di tabel database

**Solusi**: 
1. Cek field apa yang error
2. Hapus field tersebut dari `$anggotaData`
3. Atau tambahkan kolom di database

### Error 2: Data too long
```
SQLSTATE[22001]: String data, right truncated: 1406 Data too long for column 'xxx'
```

**Artinya**: Data terlalu panjang untuk kolom

**Solusi**:
1. Cek panjang data yang diinput
2. Potong data atau ubah tipe kolom di database

### Error 3: Cannot be null
```
SQLSTATE[23000]: Integrity constraint violation: 1048 Column 'xxx' cannot be null
```

**Artinya**: Kolom tidak boleh NULL tapi data kosong

**Solusi**:
1. Set default value untuk field tersebut
2. Atau ubah kolom di database menjadi nullable

### Error 4: Duplicate entry
```
SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'xxx' for key 'yyy'
```

**Artinya**: Data sudah ada (NIK, Email, atau No Anggota)

**Solusi**:
1. Gunakan NIK/Email yang berbeda
2. Atau hapus data lama dari database

---

## Command untuk Cek Database

### Cek Struktur Tabel Anggotas
```sql
DESCRIBE anggotas;
```

### Cek Data Terakhir
```sql
SELECT * FROM anggotas ORDER BY id DESC LIMIT 5;
```

### Cek User Terakhir
```sql
SELECT * FROM users ORDER BY id DESC LIMIT 5;
```

### Hapus Data Test
```sql
-- Hapus anggota test
DELETE FROM anggotas WHERE nik LIKE '911321111230900%';

-- Hapus user test
DELETE FROM users WHERE email LIKE 'testuser%@%';
```

---

## Perbaikan Berdasarkan Error Log

### Jika Error: "Column 'email' not found in anggotas"
✅ **SUDAH DIPERBAIKI**: Field `email` sudah dihapus dari `$anggotaData`

### Jika Error: "Column 'password' not found in anggotas"
✅ **SUDAH DIPERBAIKI**: Field `password` sudah dihapus dari `$anggotaData`

### Jika Error: "Column 'xxx' cannot be null"
**Solusi**: Tambahkan default value di controller:
```php
$defaults = [
    'xxx' => $validated['xxx'] ?? 'default_value',
];
```

### Jika Error: "Data too long for column 'xxx'"
**Solusi**: Ubah tipe kolom di database:
```sql
ALTER TABLE anggotas MODIFY COLUMN xxx VARCHAR(500);
```

---

## Checklist Debugging

- [ ] Clear cache (config, cache, view)
- [ ] Refresh browser (Ctrl+Shift+R)
- [ ] Gunakan NIK dan Email yang unik
- [ ] Isi semua field required
- [ ] Upload foto valid
- [ ] Submit form
- [ ] Cek log error di `storage/logs/laravel.log`
- [ ] Screenshot error message
- [ ] Copy error dari log
- [ ] Analisis error
- [ ] Perbaiki sesuai error
- [ ] Test lagi

---

## Expected Log Output (Jika Berhasil)

```
[2026-04-18 10:00:00] local.INFO: Pendaftaran Anggota - Data yang akan disimpan
{
    "no_anggota": "AGT202604XXXX",
    "nik": "9113211112309005",
    "nama": "TEST USER BARU",
    "user_id": 123,
    "data_keys": ["nik", "nama", "tempat_lahir", ...]
}
```

---

## Expected Result (Jika Berhasil)

```
✅ Redirect ke: /anggota/dashboard
✅ Pesan sukses: "Selamat! Pendaftaran berhasil dengan nomor anggota: AGT202604XXXX"
✅ User sudah login otomatis
✅ Data tersimpan di database
```

---

## Jika Masih Error Setelah Semua Perbaikan

### Kirim Informasi Berikut:

1. **Screenshot Error**
   - Screenshot halaman error
   - Screenshot form yang diisi

2. **Log Error**
   - Copy 50 baris terakhir dari `storage/logs/laravel.log`
   - Fokus pada error yang mengandung "Pendaftaran Anggota"

3. **Struktur Database**
   ```sql
   DESCRIBE anggotas;
   ```
   Copy hasil query ini

4. **Data yang Diinput**
   - NIK yang digunakan
   - Email yang digunakan
   - Field apa saja yang diisi

---

## Quick Fix Commands

### Reset Test Data
```bash
php artisan tinker
>>> App\Models\Anggota::where('nik', 'like', '911321111230900%')->delete();
>>> App\Models\User::where('email', 'like', 'testuser%@%')->delete();
>>> exit
```

### Clear All Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Check Permissions (Jika Error Upload Foto)
```bash
# Windows PowerShell
icacls storage /grant Everyone:F /T
icacls bootstrap/cache /grant Everyone:F /T
```

---

## Summary Perbaikan

### Yang Sudah Diperbaiki:
1. ✅ Hapus field `password`, `password_confirmation`, `email` dari data anggota
2. ✅ Set default values untuk field numeric (0)
3. ✅ Set default value untuk kabupaten (Tolikara)
4. ✅ Tambah logging detail untuk debugging
5. ✅ Perbaiki error handling dengan pesan yang lebih jelas
6. ✅ Tambah log SQL query saat error database

### Yang Perlu Dilakukan:
1. 🔄 Test pendaftaran dengan data baru
2. 🔄 Cek log jika masih error
3. 🔄 Kirim log error untuk analisis lebih lanjut

---

**Status**: ✅ Perbaikan selesai, siap untuk testing  
**Next**: Test pendaftaran dan cek log jika ada error

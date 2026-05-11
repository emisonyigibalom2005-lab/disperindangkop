# Cara Menampilkan Foto Anggota

## Masalah
Foto anggota tidak tampil di halaman Data Anggota

## Solusi yang Sudah Dilakukan

### 1. ✅ Symbolic Link Sudah Dibuat Ulang
```bash
php artisan storage:link
```
Output: Link berhasil dibuat dari `public/storage` ke `storage/app/public`

### 2. ✅ Model Anggota Sudah Diperbaiki
File: `app/Models/Anggota.php`
- Accessor `getFotoUrlAttribute()` sudah benar
- Mengembalikan URL: `http://127.0.0.1:8000/storage/anggota/filename.jpg`

### 3. ✅ File Foto Ada di Storage
Lokasi: `storage/app/public/anggota/`
- Ada 15 file foto (JPG)
- Bisa diakses via `public/storage/anggota/`

### 4. ✅ Cache Sudah Di-Clear
```bash
php artisan cache:clear
```

## Langkah Selanjutnya untuk User

### STEP 1: Test Foto Langsung
Buka di browser: **http://127.0.0.1:8000/test-foto.html**

Jika foto muncul = Symbolic link bekerja ✅
Jika foto tidak muncul = Ada masalah di server ❌

### STEP 2: Hard Refresh Browser
1. Buka halaman Data Anggota: http://127.0.0.1:8000/admin/anggota
2. Tekan **Ctrl + Shift + R** (Windows) atau **Cmd + Shift + R** (Mac)
3. Atau tekan **Ctrl + F5**
4. Atau buka Incognito/Private Window

### STEP 3: Clear Browser Cache
1. Tekan **F12** untuk buka Developer Tools
2. Klik kanan pada tombol Refresh
3. Pilih **"Empty Cache and Hard Reload"**

### STEP 4: Cek Console Browser
1. Tekan **F12** untuk buka Developer Tools
2. Klik tab **Console**
3. Lihat apakah ada error 404 untuk foto
4. Jika ada error 404, screenshot dan kirim ke developer

### STEP 5: Cek Network Tab
1. Tekan **F12** untuk buka Developer Tools
2. Klik tab **Network**
3. Refresh halaman
4. Cari request ke `/storage/anggota/...jpg`
5. Klik request tersebut dan lihat status code:
   - **200 OK** = Foto berhasil dimuat ✅
   - **404 Not Found** = File tidak ditemukan ❌
   - **403 Forbidden** = Permission error ❌

## Troubleshooting Lanjutan

### Jika Foto Masih Tidak Muncul

#### Opsi 1: Restart Development Server
```bash
# Stop server (Ctrl + C)
# Start ulang
php artisan serve
```

#### Opsi 2: Cek Permission Folder (Linux/Mac)
```bash
chmod -R 755 storage
chmod -R 755 public/storage
```

#### Opsi 3: Hapus dan Buat Ulang Symbolic Link
```bash
# Hapus link lama
rm -rf public/storage

# Buat link baru
php artisan storage:link
```

#### Opsi 4: Cek .htaccess (Jika Pakai Apache)
Pastikan file `public/.htaccess` ada dan benar

#### Opsi 5: Cek Konfigurasi Web Server
- **Apache**: Pastikan `mod_rewrite` enabled
- **Nginx**: Pastikan konfigurasi routing benar

## Verifikasi Manual

### Test 1: Akses Foto Langsung di Browser
Buka: `http://127.0.0.1:8000/storage/anggota/m7REtcPKbgAdWAw6r62BaAvs7uvaapw4hhesmTfZ.jpg`

**Hasil yang Diharapkan**: Foto muncul
**Jika 404**: Symbolic link bermasalah

### Test 2: Cek File di Folder
```bash
ls -la public/storage/anggota/
```
**Hasil yang Diharapkan**: Ada file-file JPG

### Test 3: Cek Symbolic Link
```bash
ls -la public/storage
```
**Hasil yang Diharapkan**: `storage -> ../storage/app/public` (symbolic link)

## Informasi Teknis

### Path Foto di Database
```
anggota/m7REtcPKbgAdWAw6r62BaAvs7uvaapw4hhesmTfZ.jpg
```

### URL Foto yang Dihasilkan
```
http://127.0.0.1:8000/storage/anggota/m7REtcPKbgAdWAw6r62BaAvs7uvaapw4hhesmTfZ.jpg
```

### Lokasi File Fisik
```
storage/app/public/anggota/m7REtcPKbgAdWAw6r62BaAvs7uvaapw4hhesmTfZ.jpg
```

### Akses via Symbolic Link
```
public/storage/anggota/m7REtcPKbgAdWAw6r62BaAvs7uvaapw4hhesmTfZ.jpg
```

## Status Saat Ini
✅ Model sudah benar
✅ Symbolic link sudah dibuat
✅ File foto ada di storage
✅ Cache sudah di-clear
✅ Test file sudah dibuat

**NEXT**: User perlu hard refresh browser atau test di http://127.0.0.1:8000/test-foto.html

---
**Update**: 13 April 2026

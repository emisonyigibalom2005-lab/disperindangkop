# 🆓 PANDUAN HOSTING GRATIS - INFINITYFREE

## 📋 Overview
Panduan lengkap hosting website Laravel di **InfinityFree** - hosting gratis selamanya dengan unlimited storage dan bandwidth!

---

## ✨ Keunggulan InfinityFree

```
✅ GRATIS SELAMANYA (No credit card required)
✅ Unlimited Disk Space
✅ Unlimited Bandwidth
✅ cPanel (mudah digunakan)
✅ PHP 8.2 Support
✅ MySQL Database
✅ FTP Access
✅ File Manager
✅ Subdomain Gratis (.infinityfreeapp.com)
✅ Custom Domain Support (bisa pakai domain sendiri)
✅ 99.9% Uptime
✅ Community Support

❌ Tidak ada SSL gratis (bisa beli $5/tahun)
❌ Ada iklan kecil di footer website
❌ Limit 50,000 hits/day (cukup untuk website kecil-menengah)
```

---

## 🚀 LANGKAH 1: Daftar InfinityFree

### 1.1 Buka Website
```
https://infinityfree.net
```

### 1.2 Sign Up
1. Klik tombol **"Sign Up"** (pojok kanan atas)
2. Isi form registrasi:
   - **Email Address**: email aktif Anda
   - **Password**: buat password kuat (min 8 karakter)
   - Centang: "I agree to the Terms of Service"
3. Klik **"Sign Up"**

### 1.3 Verifikasi Email
1. Buka email Anda
2. Cari email dari **InfinityFree**
3. Klik link verifikasi
4. Email terverifikasi!

---

## 🌐 LANGKAH 2: Buat Account Hosting

### 2.1 Login Dashboard
1. Login ke: https://app.infinityfree.net
2. Masukkan email & password

### 2.2 Create Account
1. Klik tombol **"Create Account"** (besar, warna hijau)
2. Isi form:

**Choose a Domain:**
- Pilih **"Use a subdomain"**
- Ketik subdomain: `disperindagkop-tolikara`
- Pilih: `.infinityfreeapp.com`
- **Hasil**: `disperindagkop-tolikara.infinityfreeapp.com`

**Account Label:**
- Ketik: `DISPERINDAGKOP Tolikara`

3. Klik **"Create Account"**

### 2.3 Tunggu Setup
- Proses setup: 5-10 menit
- Status: "Creating Account..."
- Setelah selesai: "Active"

### 2.4 Catat Informasi
Setelah aktif, catat:
- **Username**: `if0_12345678` (contoh)
- **Password**: password yang Anda buat
- **MySQL Host**: `sql123.infinityfree.com`
- **FTP Host**: `ftpupload.net`
- **Website URL**: `http://disperindagkop-tolikara.infinityfreeapp.com`

---

## 📁 LANGKAH 3: Siapkan File Project

### 3.1 Backup Database
1. Buka **phpMyAdmin** di XAMPP
2. Pilih database `disperindagkop`
3. Tab **"Export"**
4. Klik **"Go"**
5. Save: `disperindagkop.sql`

### 3.2 Compress Project
1. Buka folder project
2. **HAPUS** folder:
   - `node_modules/`
   - `vendor/`
   - `storage/logs/*.log`
3. **ZIP** folder project
4. Rename: `disperindagkop.zip`

---

## 📤 LANGKAH 4: Upload File

### 4.1 Login cPanel
1. Di dashboard InfinityFree, klik **"Control Panel"**
2. Atau buka: `https://cpanel.infinityfree.net`
3. Login otomatis (dari dashboard)

### 4.2 Buka File Manager
1. Di cPanel, scroll ke **"Files"**
2. Klik **"Online File Manager"**
3. Klik **"Go to File Manager"**

### 4.3 Masuk ke htdocs
1. Klik folder **"htdocs"**
   (Ini seperti `public_html` di hosting lain)
2. Hapus file default (index.html, dll)

### 4.4 Upload ZIP
1. Klik tombol **"Upload Files"** di atas
2. Klik **"Select File"**
3. Pilih `disperindagkop.zip`
4. Tunggu upload selesai (100%)
5. Klik **"Back to /htdocs"**

### 4.5 Extract ZIP
1. Klik kanan file `disperindagkop.zip`
2. Pilih **"Extract"**
3. Extract to: `/htdocs/`
4. Klik **"Extract File(s)"**
5. Tunggu sampai selesai

### 4.6 Pindahkan File
**PENTING!** Struktur Laravel harus benar:

1. Buka folder `disperindagkop` yang baru di-extract
2. Masuk ke folder `public`
3. **Select All** file di dalam `public`
4. Klik **"Move"**
5. Move to: `/htdocs/`
6. Klik **"Move File(s)"**

7. Kembali ke folder `disperindagkop`
8. **Select All** folder lainnya (app, config, database, dll)
9. Klik **"Move"**
10. Move to: `/` (root, di luar htdocs)
11. Klik **"Move File(s)"**

**Struktur Akhir:**
```
/
├── disperindagkop/          ← Folder Laravel (di root)
│   ├── app/
│   ├── config/
│   ├── database/
│   └── ...
└── htdocs/                  ← Folder public Laravel
    ├── index.php
    ├── .htaccess
    ├── css/
    └── js/
```

---

## 🗄️ LANGKAH 5: Buat Database

### 5.1 Buka MySQL Databases
1. Kembali ke cPanel
2. Scroll ke **"Databases"**
3. Klik **"MySQL Databases"**

### 5.2 Create Database
1. Di **"Create New Database"**
2. Database Name: `disperindagkop`
3. Klik **"Create Database"**
4. **Catat nama lengkap**: `if0_12345678_disperindagkop`

### 5.3 Create User
1. Scroll ke **"MySQL Users"**
2. Username: `admin`
3. Password: buat password kuat
4. Klik **"Create User"**
5. **Catat username lengkap**: `if0_12345678_admin`

### 5.4 Add User to Database
1. Scroll ke **"Add User To Database"**
2. User: pilih `if0_12345678_admin`
3. Database: pilih `if0_12345678_disperindagkop`
4. Klik **"Add"**
5. Centang **"ALL PRIVILEGES"**
6. Klik **"Make Changes"**

---

## 📊 LANGKAH 6: Import Database

### 6.1 Buka phpMyAdmin
1. Kembali ke cPanel
2. Klik **"phpMyAdmin"**
3. Login otomatis

### 6.2 Pilih Database
1. Di sidebar kiri, klik database `if0_12345678_disperindagkop`

### 6.3 Import
1. Klik tab **"Import"** di atas
2. Klik **"Choose File"**
3. Pilih file `disperindagkop.sql`
4. Scroll ke bawah
5. Klik **"Go"**
6. Tunggu sampai selesai (muncul pesan sukses)

---

## ⚙️ LANGKAH 7: Setup File .env

### 7.1 Buka File Manager
1. Kembali ke cPanel → File Manager
2. Masuk ke folder `/disperindagkop/`

### 7.2 Copy .env.example
1. Cari file `.env.example`
2. Klik kanan → **"Copy"**
3. Copy to: `/disperindagkop/.env`
4. Klik **"Copy File(s)"**

### 7.3 Edit .env
1. Klik kanan file `.env`
2. Klik **"Edit"**
3. Klik **"Edit"** lagi (konfirmasi)

### 7.4 Ubah Konfigurasi
**Ganti bagian ini:**

```env
APP_NAME="DISPERINDAGKOP Tolikara"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://disperindagkop-tolikara.infinityfreeapp.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=sql123.infinityfree.com
DB_PORT=3306
DB_DATABASE=if0_12345678_disperindagkop
DB_USERNAME=if0_12345678_admin
DB_PASSWORD=password_database_anda

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

**Ganti:**
- `sql123.infinityfree.com` → MySQL host dari dashboard
- `if0_12345678_disperindagkop` → nama database lengkap
- `if0_12345678_admin` → username database lengkap
- `password_database_anda` → password database

### 7.5 Save
- Klik **"Save Changes"** (pojok kanan atas)
- Klik **"Close"**

---

## 🔑 LANGKAH 8: Generate APP_KEY

### 8.1 Via Online PHP Executor
Karena InfinityFree tidak punya terminal, gunakan cara ini:

1. Buka: https://www.writephponline.com
2. Paste code ini:

```php
<?php
echo 'base64:' . base64_encode(random_bytes(32));
?>
```

3. Klik **"Run"**
4. Copy hasil (contoh: `base64:abcd1234...`)

### 8.2 Update .env
1. Buka File Manager → edit `.env`
2. Cari baris `APP_KEY=`
3. Paste hasil: `APP_KEY=base64:abcd1234...`
4. Save

---

## 📦 LANGKAH 9: Install Dependencies

### 9.1 Via FTP (Recommended)
Karena InfinityFree tidak support Composer di cPanel, install di local dulu:

1. Di komputer local, buka terminal
2. Masuk ke folder project
3. Jalankan:

```bash
composer install --optimize-autoloader --no-dev
```

4. Upload folder `vendor` via FTP ke `/disperindagkop/vendor/`

### 9.2 Set Permission
Di File Manager:
1. Klik kanan folder `storage`
2. **"Change Permissions"**
3. Set: `755`
4. Centang: "Recurse into subdirectories"
5. Klik **"Change Permissions"**

6. Ulangi untuk folder `bootstrap/cache`

---

## 📝 LANGKAH 10: Update index.php

### 10.1 Edit index.php
1. File Manager → folder `htdocs`
2. Klik kanan `index.php`
3. Klik **"Edit"**

### 10.2 Ubah Path
**Cari baris:**
```php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

**Ganti dengan:**
```php
require __DIR__.'/../disperindagkop/vendor/autoload.php';
$app = require_once __DIR__.'/../disperindagkop/bootstrap/app.php';
```

### 10.3 Save
- Klik **"Save Changes"**
- Klik **"Close"**

---

## 🎉 LANGKAH 11: Test Website

### 11.1 Buka Browser
```
http://disperindagkop-tolikara.infinityfreeapp.com
```

### 11.2 Test Login
```
http://disperindagkop-tolikara.infinityfreeapp.com/login
```

**Login dengan:**
- Email: `admin@tolikara.go.id`
- Password: password admin Anda

### 11.3 Test Admin
```
http://disperindagkop-tolikara.infinityfreeapp.com/admin/dashboard
```

---

## 🔧 Troubleshooting

### Error: 500 Internal Server Error
**Solusi:**
1. Cek file `.env` sudah benar
2. Cek `APP_KEY` sudah di-set
3. Cek permission `storage` dan `bootstrap/cache` = 755
4. Cek path di `index.php` sudah benar

### Error: Database Connection Failed
**Solusi:**
1. Cek `DB_HOST` di `.env` (harus `sql123.infinityfree.com`)
2. Cek `DB_DATABASE` (harus nama lengkap dengan prefix)
3. Cek `DB_USERNAME` (harus nama lengkap dengan prefix)
4. Cek `DB_PASSWORD`

### Error: 404 Not Found
**Solusi:**
1. Cek file `.htaccess` ada di `htdocs/`
2. Cek isi `.htaccess`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### Website Blank/Putih
**Solusi:**
1. Set `APP_DEBUG=true` temporary
2. Refresh website untuk lihat error
3. Fix error
4. Set kembali `APP_DEBUG=false`

---

## 📊 Limitasi InfinityFree

```
⚠️ PERHATIAN:

1. Hits Limit: 50,000 hits/day
   (Cukup untuk ~1,500 visitor/day)

2. File Size: Max 10 MB per file upload

3. Execution Time: Max 60 seconds

4. No Cron Jobs
   (Tidak bisa schedule task otomatis)

5. No Shell Access
   (Tidak ada terminal/SSH)

6. No Email Sending
   (Tidak bisa kirim email dari website)

7. Ads: Ada iklan kecil di footer
   (Bisa dihilangkan dengan upgrade)
```

---

## 💡 Tips & Tricks

### 1. Hilangkan Iklan
Upgrade ke **Premium** ($5/tahun):
- No ads
- SSL gratis
- Priority support

### 2. Gunakan Custom Domain
Jika punya domain sendiri:
1. Dashboard → **"Addon Domains"**
2. Tambah domain
3. Update DNS domain ke InfinityFree nameservers

### 3. Backup Rutin
1. Download database via phpMyAdmin
2. Download file via File Manager
3. Simpan di komputer/cloud

### 4. Optimasi Performa
```php
// Di .env
APP_DEBUG=false
APP_ENV=production

// Cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## ✅ Checklist

- [ ] Daftar InfinityFree
- [ ] Buat account hosting
- [ ] Backup database
- [ ] Upload file project
- [ ] Buat database MySQL
- [ ] Import database
- [ ] Setup file .env
- [ ] Generate APP_KEY
- [ ] Set permission
- [ ] Update index.php
- [ ] Test website
- [ ] Test login
- [ ] Test admin panel

---

## 🎊 SELESAI!

Website Anda sudah online dan bisa diakses gratis selamanya!

**URL Website:**
```
http://disperindagkop-tolikara.infinityfreeapp.com
```

**URL Admin:**
```
http://disperindagkop-tolikara.infinityfreeapp.com/admin
```

**URL Login:**
```
http://disperindagkop-tolikara.infinityfreeapp.com/login
```

---

## 📞 Support

### InfinityFree Forum:
```
https://forum.infinityfree.net
```

### Knowledge Base:
```
https://infinityfree.net/support
```

---

**Selamat! Website Anda sudah online GRATIS! 🎉**

**Estimasi Waktu**: 30-45 menit  
**Biaya**: Rp 0 (GRATIS SELAMANYA)

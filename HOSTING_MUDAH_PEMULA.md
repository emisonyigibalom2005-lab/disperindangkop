# 🚀 HOSTING MUDAH UNTUK PEMULA

## 📱 Panduan Super Simpel - 10 Langkah Saja!

Panduan ini khusus untuk pemula yang ingin hosting website dengan cara paling mudah menggunakan **Niagahoster** (Hosting Indonesia).

---

## 💰 Biaya: ~Rp 32.500/bulan

**Paket yang Dibutuhkan:**
- Domain `.com` = Rp 150.000/tahun
- Hosting Bayi = Rp 20.000/bulan
- SSL = GRATIS

**Total 1 Tahun = Rp 390.000** (sudah termasuk domain!)

---

## 🎯 LANGKAH 1: Beli Hosting

### 1.1 Buka Website Niagahoster
```
https://www.niagahoster.co.id
```

### 1.2 Pilih Paket
- Klik **"Hosting"** di menu atas
- Pilih **"Hosting Unlimited"**
- Pilih paket **"Bayi"** (Rp 20.000/bulan)
- Klik **"Pilih Paket"**

### 1.3 Pilih Domain
- Ketik nama domain yang diinginkan
  Contoh: `disperindagkop-tolikara.com`
- Klik **"Cek Domain"**
- Jika tersedia, klik **"Lanjutkan"**

### 1.4 Checkout
- Pilih periode: **1 Tahun** (lebih hemat)
- Isi data diri
- Pilih metode pembayaran (Transfer Bank/E-wallet)
- Klik **"Bayar Sekarang"**

### 1.5 Tunggu Email
- Setelah bayar, tunggu 5-10 menit
- Cek email dari Niagahoster
- Email berisi:
  - Link cPanel
  - Username cPanel
  - Password cPanel

---

## 🎯 LANGKAH 2: Siapkan File Project

### 2.1 Backup Database
1. Buka **phpMyAdmin** di XAMPP
2. Pilih database `disperindagkop`
3. Klik tab **"Export"**
4. Klik **"Go"**
5. Save file `disperindagkop.sql`

### 2.2 Compress Project
1. Buka folder project di `J:\MATERI SEMESTERI_6_2026\Tolikara\disperindagkop`
2. **HAPUS** folder berikut (untuk mengecilkan ukuran):
   - `node_modules/`
   - `vendor/`
   - `storage/logs/` (isi file log)
3. **Klik kanan** folder project → **Send to** → **Compressed (zipped) folder**
4. Rename jadi `disperindagkop.zip`

---

## 🎯 LANGKAH 3: Login ke cPanel

### 3.1 Buka cPanel
```
https://namadomain.com/cpanel
atau
https://cpanel.niagahoster.co.id
```

### 3.2 Login
- Username: dari email Niagahoster
- Password: dari email Niagahoster

---

## 🎯 LANGKAH 4: Upload File

### 4.1 Buka File Manager
- Di cPanel, cari **"File Manager"**
- Klik **"File Manager"**

### 4.2 Masuk ke public_html
- Klik folder **"public_html"**
- Ini adalah folder website Anda

### 4.3 Upload ZIP
- Klik tombol **"Upload"** di atas
- Klik **"Select File"**
- Pilih file `disperindagkop.zip`
- Tunggu sampai upload selesai (100%)
- Klik **"Go Back"**

### 4.4 Extract ZIP
- Klik kanan file `disperindagkop.zip`
- Klik **"Extract"**
- Klik **"Extract Files"**
- Tunggu sampai selesai

### 4.5 Pindahkan File
**PENTING!** File Laravel harus diatur seperti ini:

1. Buka folder `disperindagkop` yang baru di-extract
2. Masuk ke folder `public`
3. **Select All** file di dalam folder `public`
4. Klik **"Move"**
5. Pindahkan ke `/public_html/`
6. Klik **"Move Files"**

7. Kembali ke folder `disperindagkop`
8. **Select All** folder lainnya (app, config, database, dll)
9. Klik **"Move"**
10. Pindahkan ke `/home/username/disperindagkop/`
    (Buat folder baru di luar public_html)

**Struktur Akhir:**
```
/home/username/
├── disperindagkop/          ← Folder Laravel (di luar public_html)
│   ├── app/
│   ├── config/
│   ├── database/
│   └── ...
└── public_html/             ← Folder public Laravel
    ├── index.php
    ├── css/
    ├── js/
    └── .htaccess
```

---

## 🎯 LANGKAH 5: Buat Database

### 5.1 Buka MySQL Databases
- Kembali ke cPanel
- Cari **"MySQL Databases"**
- Klik **"MySQL Databases"**

### 5.2 Create Database
- Di **"Create New Database"**
- Ketik nama: `disperindagkop`
- Klik **"Create Database"**
- Catat nama lengkap: `username_disperindagkop`

### 5.3 Create User
- Scroll ke **"MySQL Users"**
- Di **"Username"**: ketik `admin`
- Di **"Password"**: buat password kuat (contoh: `Admin123!@#`)
- Klik **"Create User"**
- Catat username lengkap: `username_admin`

### 5.4 Add User to Database
- Scroll ke **"Add User To Database"**
- User: pilih `username_admin`
- Database: pilih `username_disperindagkop`
- Klik **"Add"**
- Centang **"ALL PRIVILEGES"**
- Klik **"Make Changes"**

---

## 🎯 LANGKAH 6: Import Database

### 6.1 Buka phpMyAdmin
- Kembali ke cPanel
- Cari **"phpMyAdmin"**
- Klik **"phpMyAdmin"**

### 6.2 Pilih Database
- Di sidebar kiri, klik database `username_disperindagkop`

### 6.3 Import
- Klik tab **"Import"** di atas
- Klik **"Choose File"**
- Pilih file `disperindagkop.sql` yang tadi di-backup
- Scroll ke bawah
- Klik **"Go"**
- Tunggu sampai selesai (muncul pesan sukses)

---

## 🎯 LANGKAH 7: Setup File .env

### 7.1 Buka File Manager
- Kembali ke cPanel → File Manager
- Masuk ke folder `/home/username/disperindagkop/`

### 7.2 Copy .env.example
- Cari file `.env.example`
- Klik kanan → **"Copy"**
- Rename jadi `.env`

### 7.3 Edit .env
- Klik kanan file `.env`
- Klik **"Edit"**
- Klik **"Edit"** lagi (konfirmasi)

### 7.4 Ubah Konfigurasi
**Cari dan ubah bagian ini:**

```env
APP_NAME="DISPERINDAGKOP Tolikara"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://namadomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=username_disperindagkop
DB_USERNAME=username_admin
DB_PASSWORD=Admin123!@#
```

**Ganti:**
- `namadomain.com` → domain Anda
- `username_disperindagkop` → nama database lengkap
- `username_admin` → username database lengkap
- `Admin123!@#` → password database Anda

### 7.5 Save
- Klik **"Save Changes"** di kanan atas
- Klik **"Close"**

---

## 🎯 LANGKAH 8: Generate APP_KEY

### 8.1 Buka Terminal
- Di cPanel, cari **"Terminal"**
- Klik **"Terminal"**

### 8.2 Masuk ke Folder Project
```bash
cd disperindagkop
```

### 8.3 Generate Key
```bash
php artisan key:generate
```

Tunggu sampai muncul pesan: **"Application key set successfully"**

---

## 🎯 LANGKAH 9: Install Dependencies

### 9.1 Install Composer
```bash
composer install --optimize-autoloader --no-dev
```

Tunggu 2-5 menit sampai selesai.

### 9.2 Set Permission
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### 9.3 Clear Cache
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🎯 LANGKAH 10: Update index.php

### 10.1 Edit index.php
- Buka File Manager
- Masuk ke `/public_html/`
- Klik kanan file `index.php`
- Klik **"Edit"**

### 10.2 Ubah Path
**Cari baris ini:**
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

## 🎉 SELESAI! Test Website

### Buka Browser
```
https://namadomain.com
```

### Test Login
```
https://namadomain.com/login
```

**Login dengan:**
- Email: `admin@tolikara.go.id`
- Password: password admin Anda

### Test Admin
```
https://namadomain.com/admin/dashboard
```

---

## 🔒 BONUS: Install SSL (HTTPS)

### 1. Buka SSL/TLS
- Di cPanel, cari **"SSL/TLS Status"**
- Klik **"SSL/TLS Status"**

### 2. Install SSL
- Centang domain Anda
- Klik **"Run AutoSSL"**
- Tunggu 5-10 menit

### 3. Test HTTPS
```
https://namadomain.com
```

Harus ada **icon gembok** di browser!

---

## 🆘 Troubleshooting

### Error: 500 Internal Server Error
**Solusi:**
1. Cek file `.env` sudah benar
2. Cek `APP_KEY` sudah di-generate
3. Cek permission folder `storage` dan `bootstrap/cache`

### Error: Database Connection Failed
**Solusi:**
1. Cek nama database di `.env`
2. Cek username database di `.env`
3. Cek password database di `.env`
4. Pastikan user sudah ditambahkan ke database

### Error: 404 Not Found
**Solusi:**
1. Cek file `.htaccess` ada di `public_html/`
2. Cek path di `index.php` sudah benar

### Website Blank/Putih
**Solusi:**
1. Set `APP_DEBUG=true` di `.env` untuk lihat error
2. Cek log di `storage/logs/laravel.log`
3. Clear cache: `php artisan cache:clear`

---

## 📞 Butuh Bantuan?

### Contact Support:
- **Niagahoster Support**: https://www.niagahoster.co.id/livechat
- **WhatsApp**: 0804-1-808-888
- **Email**: support@niagahoster.co.id

### Tutorial Video:
- YouTube: "Cara Upload Laravel ke Hosting"
- YouTube: "Deploy Laravel ke cPanel"

---

## ✅ Checklist

Pastikan semua sudah dilakukan:

- [ ] Beli hosting & domain
- [ ] Backup database
- [ ] Upload file project
- [ ] Buat database
- [ ] Import database
- [ ] Setup file .env
- [ ] Generate APP_KEY
- [ ] Install dependencies
- [ ] Update index.php
- [ ] Test website
- [ ] Install SSL

---

## 🎊 SELAMAT!

Website Anda sudah online dan bisa diakses dari mana saja! 🚀

**URL Website**: `https://namadomain.com`  
**URL Admin**: `https://namadomain.com/admin`  
**URL Login**: `https://namadomain.com/login`

Share link website Anda ke teman-teman! 🎉

---

**Estimasi Waktu Total**: 30-60 menit  
**Tingkat Kesulitan**: ⭐⭐ (Mudah)  
**Biaya**: Rp 32.500/bulan

**Selamat mencoba!** 💪

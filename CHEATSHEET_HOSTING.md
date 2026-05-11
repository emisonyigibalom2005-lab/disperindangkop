# 📋 CHEATSHEET HOSTING - Quick Reference

## 🚀 10 Langkah Hosting Website

```
┌─────────────────────────────────────────────────────────┐
│  1. BELI HOSTING                                        │
│  → Niagahoster.co.id                                    │
│  → Paket Bayi (Rp 20.000/bulan)                         │
│  → Domain .com (Rp 150.000/tahun)                       │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  2. BACKUP DATABASE                                     │
│  → phpMyAdmin → Export → Go                             │
│  → Save: disperindagkop.sql                             │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  3. COMPRESS PROJECT                                    │
│  → Hapus: node_modules/, vendor/                        │
│  → Zip folder project                                   │
│  → Save: disperindagkop.zip                             │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  4. LOGIN CPANEL                                        │
│  → https://namadomain.com/cpanel                        │
│  → Username & Password dari email                       │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  5. UPLOAD FILE                                         │
│  → File Manager → public_html                           │
│  → Upload disperindagkop.zip                            │
│  → Extract → Move files                                 │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  6. BUAT DATABASE                                       │
│  → MySQL Databases                                      │
│  → Create Database: disperindagkop                      │
│  → Create User: admin                                   │
│  → Add User to Database                                 │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  7. IMPORT DATABASE                                     │
│  → phpMyAdmin                                           │
│  → Select database                                      │
│  → Import → Choose File → Go                            │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  8. SETUP .ENV                                          │
│  → Copy .env.example → .env                             │
│  → Edit: DB_DATABASE, DB_USERNAME, DB_PASSWORD          │
│  → Edit: APP_URL                                        │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  9. GENERATE KEY & INSTALL                              │
│  → Terminal: cd disperindagkop                          │
│  → php artisan key:generate                             │
│  → composer install --no-dev                            │
│  → chmod -R 755 storage bootstrap/cache                 │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  10. UPDATE INDEX.PHP                                   │
│  → Edit: public_html/index.php                          │
│  → Ganti path ke ../disperindagkop/                     │
│  → Save & Test website                                  │
└─────────────────────────────────────────────────────────┘
```

---

## 🔧 Command Terminal

```bash
# Masuk ke folder project
cd disperindagkop

# Generate APP_KEY
php artisan key:generate

# Install dependencies
composer install --optimize-autoloader --no-dev

# Set permission
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Clear cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Cek versi PHP
php -v

# Cek versi Composer
composer -V
```

---

## 📝 File .env Configuration

```env
APP_NAME="DISPERINDAGKOP Tolikara"
APP_ENV=production
APP_KEY=                          # Generate dengan artisan
APP_DEBUG=false                   # PENTING: false untuk production
APP_URL=https://namadomain.com    # Ganti dengan domain Anda

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=username_disperindagkop    # Nama database lengkap
DB_USERNAME=username_admin             # Username database lengkap
DB_PASSWORD=password_anda              # Password database
```

---

## 📂 Struktur Folder

```
/home/username/
├── disperindagkop/              # Folder Laravel (AMAN)
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   ├── .env                     # File konfigurasi
│   └── artisan
│
└── public_html/                 # Folder public (AKSES WEB)
    ├── index.php                # Entry point
    ├── .htaccess                # Rewrite rules
    ├── css/
    ├── js/
    └── storage/                 # Symlink ke storage
```

---

## 🔒 Keamanan Checklist

```
✓ APP_DEBUG=false
✓ APP_ENV=production
✓ Folder Laravel di luar public_html
✓ File .env tidak bisa diakses public
✓ Permission storage: 755
✓ Permission bootstrap/cache: 755
✓ SSL/HTTPS aktif
✓ Firewall aktif (VPS)
✓ Backup database rutin
```

---

## 🆘 Troubleshooting Quick Fix

### Error 500
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Set permission
chmod -R 755 storage bootstrap/cache

# Cek log
tail -f storage/logs/laravel.log
```

### Database Error
```bash
# Test koneksi
php artisan tinker
>>> DB::connection()->getPdo();

# Cek .env
cat .env | grep DB_
```

### 404 Not Found
```bash
# Enable mod_rewrite (VPS)
a2enmod rewrite
systemctl restart apache2

# Cek .htaccess
ls -la public_html/.htaccess
```

### Website Blank
```env
# Enable debug temporary
APP_DEBUG=true

# Cek error di browser
# Setelah fix, set kembali:
APP_DEBUG=false
```

---

## 📊 Monitoring Commands

```bash
# Cek disk space
df -h

# Cek memory usage
free -m

# Cek CPU usage
top

# Cek Apache status
systemctl status apache2

# Cek MySQL status
systemctl status mysql

# Cek log Apache
tail -f /var/log/apache2/error.log

# Cek log Laravel
tail -f storage/logs/laravel.log
```

---

## 🔄 Maintenance Commands

```bash
# Backup database
mysqldump -u username -p database_name > backup.sql

# Restore database
mysql -u username -p database_name < backup.sql

# Update Laravel
composer update

# Clear all cache
php artisan optimize:clear

# Optimize for production
php artisan optimize
```

---

## 🌐 DNS Configuration

```
Type: A
Name: @
Value: IP_SERVER
TTL: 3600

Type: A
Name: www
Value: IP_SERVER
TTL: 3600

Type: CNAME
Name: www
Value: namadomain.com
TTL: 3600
```

---

## 💰 Biaya Hosting

### Shared Hosting (Niagahoster)
```
Domain .com      : Rp 150.000/tahun
Hosting Bayi     : Rp 240.000/tahun
SSL              : GRATIS
─────────────────────────────────
TOTAL            : Rp 390.000/tahun
                   Rp 32.500/bulan
```

### VPS (DigitalOcean)
```
Domain .com      : Rp 150.000/tahun
VPS Basic        : Rp 1.080.000/tahun ($6/bulan)
SSL              : GRATIS
─────────────────────────────────
TOTAL            : Rp 1.230.000/tahun
                   Rp 102.500/bulan
```

---

## 📞 Support Contact

### Niagahoster
```
Website  : https://www.niagahoster.co.id
LiveChat : https://www.niagahoster.co.id/livechat
WhatsApp : 0804-1-808-888
Email    : support@niagahoster.co.id
```

### DigitalOcean
```
Website  : https://www.digitalocean.com
Support  : https://www.digitalocean.com/support
Docs     : https://docs.digitalocean.com
```

---

## 🔗 Useful Links

```
Laravel Docs     : https://laravel.com/docs
PHP Docs         : https://www.php.net/docs.php
Composer Docs    : https://getcomposer.org/doc
Apache Docs      : https://httpd.apache.org/docs
MySQL Docs       : https://dev.mysql.com/doc

Laravel Indonesia: https://id-laravel.com
Forum Laravel    : https://laracasts.com/discuss
Stack Overflow   : https://stackoverflow.com/questions/tagged/laravel
```

---

## ✅ Pre-Launch Checklist

```
PERSIAPAN:
□ Backup database
□ Backup file project
□ Domain sudah dibeli
□ Hosting sudah aktif

UPLOAD:
□ File project uploaded
□ Database created
□ Database imported
□ .env configured
□ APP_KEY generated

KONFIGURASI:
□ Permission set (755)
□ Dependencies installed
□ Cache cleared
□ index.php updated

TESTING:
□ Homepage works
□ Login works
□ Admin panel works
□ Upload file works
□ Database connection works

KEAMANAN:
□ APP_DEBUG=false
□ SSL installed
□ Firewall configured
□ Backup scheduled

OPTIMASI:
□ Cache enabled
□ OPcache enabled
□ Gzip enabled
□ CDN configured (optional)
```

---

## 🎯 Quick Test URLs

```
Homepage    : https://namadomain.com
Login       : https://namadomain.com/login
Admin       : https://namadomain.com/admin
Public      : https://namadomain.com/berita
API Test    : https://namadomain.com/api/test
```

---

## 📅 Maintenance Schedule

```
HARIAN:
- Cek website uptime
- Cek error log

MINGGUAN:
- Backup database
- Cek disk space
- Update security patches

BULANAN:
- Update Laravel dependencies
- Optimize database
- Review performance

TAHUNAN:
- Renew domain
- Renew hosting/VPS
- Review & upgrade plan
```

---

**Print & Keep This Cheatsheet!** 📋

**Last Updated**: April 17, 2026  
**Version**: 1.0.0

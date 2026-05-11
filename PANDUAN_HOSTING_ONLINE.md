# 🚀 PANDUAN HOSTING ONLINE - Sistem DISPERINDAGKOP

## 📋 Overview
Panduan lengkap untuk meng-hosting website Sistem DISPERINDAGKOP secara online agar bisa diakses dari internet. Panduan ini mencakup persiapan, pilihan hosting, dan langkah-langkah deployment.

---

## 🎯 Pilihan Hosting

### 1. **Hosting Berbayar (Recommended)** ⭐
**Kelebihan:**
- ✅ Performa cepat dan stabil
- ✅ Support 24/7
- ✅ SSL gratis (HTTPS)
- ✅ Backup otomatis
- ✅ Domain gratis (beberapa provider)

**Provider Recommended:**
- **Niagahoster** (Indonesia) - Rp 20.000/bulan
- **Hostinger** (Global) - Rp 25.000/bulan
- **Dewaweb** (Indonesia) - Rp 30.000/bulan
- **Rumahweb** (Indonesia) - Rp 25.000/bulan

### 2. **VPS (Virtual Private Server)** 💪
**Kelebihan:**
- ✅ Full control server
- ✅ Performa tinggi
- ✅ Bisa install apapun
- ✅ Cocok untuk traffic tinggi

**Provider Recommended:**
- **DigitalOcean** - $6/bulan (~Rp 90.000)
- **Vultr** - $6/bulan (~Rp 90.000)
- **AWS Lightsail** - $5/bulan (~Rp 75.000)
- **IDCloudHost** (Indonesia) - Rp 75.000/bulan

### 3. **Hosting Gratis** (Untuk Testing)
**Kelebihan:**
- ✅ Gratis
- ✅ Cocok untuk demo/testing

**Kekurangan:**
- ❌ Performa lambat
- ❌ Tidak stabil
- ❌ Iklan di website
- ❌ Tidak cocok untuk production

**Provider:**
- **InfinityFree** (Gratis)
- **000webhost** (Gratis)

---

## 📦 Persiapan Sebelum Hosting

### 1. **Cek Requirement Server**
```
✓ PHP >= 8.0
✓ MySQL/MariaDB >= 5.7
✓ Composer
✓ Node.js & NPM (untuk build assets)
✓ Git (optional)
```

### 2. **Siapkan File Project**
```bash
# Compress project menjadi ZIP
# Exclude folder yang tidak perlu:
- node_modules/
- vendor/
- storage/logs/*
- .env
```

### 3. **Backup Database**
```bash
# Export database dari phpMyAdmin atau command line
mysqldump -u root -p disperindagkop > database_backup.sql
```

### 4. **Siapkan Domain**
Pilihan:
- **Domain Berbayar**: .com, .id, .co.id (~Rp 150.000/tahun)
- **Subdomain Gratis**: dari hosting provider

---

## 🌐 METODE 1: Hosting Shared (Niagahoster/Hostinger)

### Step 1: Beli Hosting & Domain
1. Buka website **Niagahoster.co.id** atau **Hostinger.co.id**
2. Pilih paket **Bayi** atau **Pelajar** (cukup untuk Laravel)
3. Pilih domain (contoh: `disperindagkop-tolikara.com`)
4. Checkout dan bayar

### Step 2: Setup cPanel
1. Login ke **cPanel** (biasanya: `namadomain.com/cpanel`)
2. Username & password dikirim via email

### Step 3: Upload File Project

#### Via File Manager (Mudah):
1. Buka **File Manager** di cPanel
2. Masuk ke folder `public_html`
3. **Upload** file ZIP project
4. **Extract** file ZIP
5. Pindahkan semua file dari folder `disperindagkop/public/*` ke `public_html/`
6. Pindahkan folder lainnya ke **luar** `public_html` (untuk keamanan)

**Struktur Akhir:**
```
/home/username/
├── disperindagkop/          # Folder utama Laravel (di luar public_html)
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   └── vendor/
└── public_html/             # Folder public Laravel
    ├── index.php
    ├── css/
    ├── js/
    └── .htaccess
```

#### Via FTP (Alternatif):
1. Download **FileZilla** (FTP Client)
2. Connect ke server:
   - Host: `ftp.namadomain.com`
   - Username: dari email
   - Password: dari email
   - Port: 21
3. Upload semua file project

### Step 4: Setup Database
1. Buka **MySQL Databases** di cPanel
2. **Create Database**: `username_disperindagkop`
3. **Create User**: `username_admin` dengan password kuat
4. **Add User to Database** dengan privilege **ALL**
5. Catat:
   - Database name
   - Database user
   - Database password
   - Database host (biasanya: `localhost`)

### Step 5: Import Database
1. Buka **phpMyAdmin** di cPanel
2. Pilih database yang baru dibuat
3. Klik tab **Import**
4. Upload file `database_backup.sql`
5. Klik **Go**

### Step 6: Setup File .env
1. Buka **File Manager** → folder `disperindagkop`
2. Copy file `.env.example` → rename jadi `.env`
3. Edit file `.env`:

```env
APP_NAME="DISPERINDAGKOP Tolikara"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://namadomain.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=username_disperindagkop
DB_USERNAME=username_admin
DB_PASSWORD=password_database_anda

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

### Step 7: Generate APP_KEY
1. Buka **Terminal** di cPanel (atau SSH)
2. Masuk ke folder project:
```bash
cd /home/username/disperindagkop
```

3. Generate key:
```bash
php artisan key:generate
```

### Step 8: Set Permission
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### Step 9: Install Dependencies
```bash
# Install Composer dependencies
composer install --optimize-autoloader --no-dev

# Clear cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 10: Update index.php
Edit file `public_html/index.php`:

**Cari:**
```php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

**Ganti dengan:**
```php
require __DIR__.'/../disperindagkop/vendor/autoload.php';
$app = require_once __DIR__.'/../disperindagkop/bootstrap/app.php';
```

### Step 11: Setup SSL (HTTPS)
1. Buka **SSL/TLS** di cPanel
2. Pilih **Let's Encrypt SSL** (Gratis)
3. Pilih domain
4. Klik **Install**
5. Tunggu 5-10 menit

### Step 12: Test Website
1. Buka browser
2. Akses: `https://namadomain.com`
3. Test login: `https://namadomain.com/login`
4. Test admin: `https://namadomain.com/admin/dashboard`

---

## 🖥️ METODE 2: VPS (DigitalOcean/Vultr)

### Step 1: Beli VPS
1. Daftar di **DigitalOcean.com** atau **Vultr.com**
2. Create Droplet/Instance:
   - OS: **Ubuntu 22.04 LTS**
   - Plan: **Basic** ($6/month)
   - Region: **Singapore** (terdekat Indonesia)
3. Catat IP Address server

### Step 2: Connect via SSH
```bash
ssh root@IP_ADDRESS_SERVER
# Masukkan password yang dikirim via email
```

### Step 3: Update Server
```bash
apt update && apt upgrade -y
```

### Step 4: Install LAMP Stack

#### Install Apache:
```bash
apt install apache2 -y
systemctl start apache2
systemctl enable apache2
```

#### Install MySQL:
```bash
apt install mysql-server -y
mysql_secure_installation
```

#### Install PHP 8.2:
```bash
apt install software-properties-common -y
add-apt-repository ppa:ondrej/php -y
apt update
apt install php8.2 php8.2-cli php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd php8.2-bcmath -y
```

#### Install Composer:
```bash
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer
```

### Step 5: Setup Database
```bash
mysql -u root -p

# Di MySQL prompt:
CREATE DATABASE disperindagkop;
CREATE USER 'admin_dkop'@'localhost' IDENTIFIED BY 'password_kuat_123';
GRANT ALL PRIVILEGES ON disperindagkop.* TO 'admin_dkop'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Step 6: Upload Project

#### Via Git (Recommended):
```bash
cd /var/www/
git clone https://github.com/username/disperindagkop.git
cd disperindagkop
```

#### Via SCP (Upload dari local):
```bash
# Di komputer local:
scp -r /path/to/project root@IP_ADDRESS:/var/www/disperindagkop
```

### Step 7: Setup Project
```bash
cd /var/www/disperindagkop

# Copy .env
cp .env.example .env
nano .env
# Edit sesuai database

# Install dependencies
composer install --optimize-autoloader --no-dev

# Generate key
php artisan key:generate

# Set permission
chown -R www-data:www-data /var/www/disperindagkop
chmod -R 755 /var/www/disperindagkop/storage
chmod -R 755 /var/www/disperindagkop/bootstrap/cache

# Import database
mysql -u admin_dkop -p disperindagkop < database_backup.sql

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 8: Setup Apache Virtual Host
```bash
nano /etc/apache2/sites-available/disperindagkop.conf
```

**Isi file:**
```apache
<VirtualHost *:80>
    ServerName namadomain.com
    ServerAlias www.namadomain.com
    DocumentRoot /var/www/disperindagkop/public

    <Directory /var/www/disperindagkop/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/disperindagkop_error.log
    CustomLog ${APACHE_LOG_DIR}/disperindagkop_access.log combined
</VirtualHost>
```

**Enable site:**
```bash
a2ensite disperindagkop.conf
a2enmod rewrite
systemctl restart apache2
```

### Step 9: Setup Domain
1. Login ke **Domain Provider** (Niagahoster, Namecheap, dll)
2. Buka **DNS Management**
3. Tambah **A Record**:
   - Type: `A`
   - Name: `@`
   - Value: `IP_ADDRESS_SERVER`
   - TTL: `3600`
4. Tambah **A Record** untuk www:
   - Type: `A`
   - Name: `www`
   - Value: `IP_ADDRESS_SERVER`
   - TTL: `3600`
5. Tunggu 5-30 menit untuk propagasi DNS

### Step 10: Install SSL (Let's Encrypt)
```bash
apt install certbot python3-certbot-apache -y
certbot --apache -d namadomain.com -d www.namadomain.com
# Ikuti instruksi, pilih redirect HTTP ke HTTPS
```

### Step 11: Setup Firewall
```bash
ufw allow 'Apache Full'
ufw allow OpenSSH
ufw enable
```

### Step 12: Test Website
```bash
# Test dari server
curl http://localhost

# Test dari browser
https://namadomain.com
```

---

## 🔒 Keamanan & Optimasi

### 1. **Disable Debug Mode**
```env
APP_DEBUG=false
APP_ENV=production
```

### 2. **Setup Backup Otomatis**
```bash
# Install backup package
composer require spatie/laravel-backup

# Setup cron job
crontab -e

# Tambahkan:
0 2 * * * cd /var/www/disperindagkop && php artisan backup:run
```

### 3. **Setup Monitoring**
- Install **UptimeRobot** (gratis) untuk monitoring uptime
- Install **Google Analytics** untuk tracking visitor

### 4. **Optimasi Performa**
```bash
# Enable OPcache
nano /etc/php/8.2/apache2/php.ini

# Tambahkan:
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=10000

# Restart Apache
systemctl restart apache2
```

### 5. **Setup Firewall**
```bash
# Block IP yang mencurigakan
ufw deny from IP_ADDRESS

# Limit SSH login attempts
ufw limit ssh
```

---

## 📊 Monitoring & Maintenance

### 1. **Cek Log Error**
```bash
# Laravel log
tail -f /var/www/disperindagkop/storage/logs/laravel.log

# Apache log
tail -f /var/log/apache2/disperindagkop_error.log
```

### 2. **Update Sistem**
```bash
# Update Laravel
composer update

# Update server
apt update && apt upgrade -y
```

### 3. **Backup Database**
```bash
# Manual backup
mysqldump -u admin_dkop -p disperindagkop > backup_$(date +%Y%m%d).sql

# Auto backup (cron job)
0 3 * * * mysqldump -u admin_dkop -pPASSWORD disperindagkop > /backup/db_$(date +\%Y\%m\%d).sql
```

---

## 🆘 Troubleshooting

### Error: 500 Internal Server Error
**Solusi:**
```bash
# Cek log
tail -f storage/logs/laravel.log

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Set permission
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### Error: Database Connection Failed
**Solusi:**
```bash
# Cek .env
nano .env

# Test koneksi
php artisan tinker
DB::connection()->getPdo();
```

### Error: 404 Not Found
**Solusi:**
```bash
# Enable mod_rewrite
a2enmod rewrite
systemctl restart apache2

# Cek .htaccess di public/
```

### Website Lambat
**Solusi:**
```bash
# Cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoload
composer dump-autoload --optimize
```

---

## 💰 Estimasi Biaya

### Hosting Shared (1 Tahun):
```
Domain .com         : Rp 150.000
Hosting Bayi        : Rp 240.000 (Rp 20.000 x 12)
SSL                 : Gratis (Let's Encrypt)
─────────────────────────────────
TOTAL               : Rp 390.000/tahun
                      (~Rp 32.500/bulan)
```

### VPS (1 Tahun):
```
Domain .com         : Rp 150.000
VPS DigitalOcean    : Rp 1.080.000 ($6 x 12)
SSL                 : Gratis (Let's Encrypt)
─────────────────────────────────
TOTAL               : Rp 1.230.000/tahun
                      (~Rp 102.500/bulan)
```

---

## 📞 Support & Bantuan

### Jika Butuh Bantuan:
1. **Forum Laravel Indonesia**: https://id-laravel.com
2. **Facebook Group**: Laravel Indonesia
3. **Telegram**: @laravel_id
4. **Email Support Hosting**: support@niagahoster.co.id

---

## ✅ Checklist Deployment

### Persiapan:
- [ ] Backup database
- [ ] Backup file project
- [ ] Siapkan domain
- [ ] Beli hosting/VPS

### Upload:
- [ ] Upload file project
- [ ] Setup database
- [ ] Import database
- [ ] Setup .env
- [ ] Generate APP_KEY

### Konfigurasi:
- [ ] Set permission
- [ ] Install dependencies
- [ ] Cache config
- [ ] Setup virtual host (VPS)
- [ ] Setup SSL

### Testing:
- [ ] Test homepage
- [ ] Test login
- [ ] Test admin panel
- [ ] Test upload file
- [ ] Test database

### Keamanan:
- [ ] Disable debug mode
- [ ] Setup firewall
- [ ] Setup backup
- [ ] Setup monitoring

---

## 🎉 SELESAI!

Website Anda sekarang sudah online dan bisa diakses dari internet! 🚀

**URL Website**: `https://namadomain.com`  
**URL Admin**: `https://namadomain.com/admin`  
**URL Login**: `https://namadomain.com/login`

---

## 📅 Update Info

**Date**: April 17, 2026  
**Version**: 1.0.0  
**Status**: Production Ready ✅

**Recommended**: Gunakan **Hosting Shared** untuk pemula, **VPS** untuk advanced user.

---

## 🎊 Selamat!

Website Sistem DISPERINDAGKOP Anda sudah berhasil di-hosting dan bisa diakses secara online! 🎉

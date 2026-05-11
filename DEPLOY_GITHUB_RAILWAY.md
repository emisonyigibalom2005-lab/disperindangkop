# 🚀 DEPLOY LARAVEL DARI GITHUB KE RAILWAY

## 📋 Overview
Panduan lengkap deploy website Laravel dari GitHub ke Railway.app - hosting gratis dengan auto deploy!

---

## ✨ Keunggulan Railway

```
✅ Deploy langsung dari GitHub (1 klik!)
✅ Gratis $5 credit/bulan (cukup untuk 500 jam)
✅ Auto deploy (push GitHub → otomatis update)
✅ Database MySQL/PostgreSQL gratis
✅ SSL/HTTPS otomatis
✅ Custom domain support
✅ Environment variables (untuk .env)
✅ Logs real-time
✅ Rollback mudah
✅ Monitoring built-in
✅ No credit card required (untuk free tier)
```

---

## 🎯 LANGKAH 1: Push Project ke GitHub

### 1.1 Buat Repository di GitHub

1. Buka: **https://github.com**
2. Login
3. Klik **"+"** → **"New repository"**
4. Isi:
   - Repository name: `disperindagkop`
   - Description: `Sistem DISPERINDAGKOP Tolikara`
   - Public atau Private (pilih sesuai kebutuhan)
5. Klik **"Create repository"**

### 1.2 Push Code ke GitHub

Di folder project, buka terminal:

```bash
# Initialize git (jika belum)
git init

# Tambah .gitignore
echo "node_modules/" >> .gitignore
echo "vendor/" >> .gitignore
echo ".env" >> .gitignore
echo "storage/*.key" >> .gitignore
echo "storage/logs/*.log" >> .gitignore

# Add all files
git add .

# Commit
git commit -m "Initial commit - DISPERINDAGKOP System"

# Add remote
git remote add origin https://github.com/USERNAME/disperindagkop.git

# Push
git branch -M main
git push -u origin main
```

**Ganti `USERNAME` dengan username GitHub Anda!**

---

## 🚀 LANGKAH 2: Daftar Railway

### 2.1 Buka Railway

```
https://railway.app
```

### 2.2 Login dengan GitHub

1. Klik **"Login"** (pojok kanan atas)
2. Pilih **"Login with GitHub"**
3. Klik **"Authorize Railway"**
4. Login berhasil!

---

## 📦 LANGKAH 3: Deploy Project

### 3.1 Create New Project

1. Di dashboard Railway, klik **"New Project"**
2. Pilih **"Deploy from GitHub repo"**

### 3.2 Connect Repository

1. Pilih repository: **"disperindagkop"**
2. Klik repository tersebut
3. Railway mulai deploy otomatis!

### 3.3 Tunggu Deploy

- Railway otomatis detect Laravel
- Install dependencies (composer install)
- Build project
- Deploy!
- Proses: 2-5 menit

---

## 🗄️ LANGKAH 4: Tambah Database MySQL

### 4.1 Add MySQL Database

1. Di project Railway, klik **"New"**
2. Pilih **"Database"**
3. Pilih **"Add MySQL"**
4. Database otomatis dibuat!

### 4.2 Catat Database Credentials

1. Klik database yang baru dibuat
2. Tab **"Variables"**
3. Catat:
   - `MYSQLHOST`
   - `MYSQLPORT`
   - `MYSQLDATABASE`
   - `MYSQLUSER`
   - `MYSQLPASSWORD`

---

## ⚙️ LANGKAH 5: Setup Environment Variables

### 5.1 Buka Variables

1. Klik service Laravel (bukan database)
2. Tab **"Variables"**
3. Klik **"Raw Editor"**

### 5.2 Tambah Variables

Paste ini:

```env
APP_NAME=DISPERINDAGKOP
APP_ENV=production
APP_DEBUG=false
APP_URL=https://${{RAILWAY_PUBLIC_DOMAIN}}

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=${{MYSQLHOST}}
DB_PORT=${{MYSQLPORT}}
DB_DATABASE=${{MYSQLDATABASE}}
DB_USERNAME=${{MYSQLUSER}}
DB_PASSWORD=${{MYSQLPASSWORD}}

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

### 5.3 Generate APP_KEY

**Cara 1: Via Online Tool**
1. Buka: https://generate-random.org/laravel-key-generator
2. Copy key yang di-generate
3. Tambah variable:
   ```
   APP_KEY=base64:xxx...
   ```

**Cara 2: Via Local**
```bash
# Di folder project local
php artisan key:generate --show

# Copy hasilnya, tambah ke Railway variables
```

### 5.4 Save Variables

Klik **"Save"** atau tekan `Ctrl+S`

---

## 🔧 LANGKAH 6: Setup Build & Start Commands

### 6.1 Buka Settings

1. Klik service Laravel
2. Tab **"Settings"**
3. Scroll ke **"Deploy"**

### 6.2 Build Command

Klik **"Custom Build Command"**, isi:

```bash
composer install --optimize-autoloader --no-dev && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

### 6.3 Start Command

Klik **"Custom Start Command"**, isi:

```bash
php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
```

**Penjelasan:**
- `migrate --force`: Jalankan migration otomatis
- `serve`: Start Laravel server
- `--host=0.0.0.0`: Listen semua IP
- `--port=$PORT`: Gunakan port dari Railway

---

## 🌐 LANGKAH 7: Generate Public Domain

### 7.1 Enable Public Domain

1. Tab **"Settings"**
2. Scroll ke **"Networking"**
3. Klik **"Generate Domain"**
4. Domain otomatis dibuat!

**URL:**
```
https://disperindagkop-production-xxxx.up.railway.app
```

### 7.2 Custom Domain (Optional)

Jika punya domain sendiri:
1. Klik **"Custom Domain"**
2. Masukkan domain: `disperindagkop.com`
3. Update DNS domain:
   - Type: `CNAME`
   - Name: `@` atau `www`
   - Value: dari Railway
4. Tunggu propagasi DNS (5-30 menit)

---

## 📊 LANGKAH 8: Import Database

### 8.1 Connect ke Database

**Via phpMyAdmin (Tidak ada di Railway)**

**Via MySQL Client:**
```bash
mysql -h MYSQLHOST -P MYSQLPORT -u MYSQLUSER -p MYSQLDATABASE
```

**Via Railway CLI:**
```bash
# Install Railway CLI
npm install -g @railway/cli

# Login
railway login

# Connect to database
railway connect mysql
```

### 8.2 Import SQL File

```bash
# Via Railway CLI
railway connect mysql < database_backup.sql

# Atau via MySQL client
mysql -h HOST -P PORT -u USER -p DATABASE < database_backup.sql
```

---

## 🎉 LANGKAH 9: Test Website

### 9.1 Buka Website

```
https://disperindagkop-production-xxxx.up.railway.app
```

### 9.2 Test Login

```
https://disperindagkop-production-xxxx.up.railway.app/login
```

**Login dengan:**
- Email: `admin@tolikara.go.id`
- Password: password admin Anda

### 9.3 Test Admin

```
https://disperindagkop-production-xxxx.up.railway.app/admin/dashboard
```

---

## 🔄 AUTO DEPLOY (Push GitHub → Update Otomatis)

### Setup Auto Deploy

1. Di Railway, tab **"Settings"**
2. Scroll ke **"Service"**
3. **"Source Repo"** sudah connected
4. **"Auto Deploy"** sudah enabled

### Cara Update Website

```bash
# Edit code di local
# Commit changes
git add .
git commit -m "Update fitur xxx"

# Push ke GitHub
git push origin main

# Railway otomatis detect dan deploy!
# Tunggu 2-3 menit, website updated!
```

---

## 📊 MONITORING & LOGS

### 9.1 Lihat Logs

1. Klik service Laravel
2. Tab **"Deployments"**
3. Klik deployment terakhir
4. Tab **"Logs"**
5. Lihat real-time logs!

### 9.2 Metrics

1. Tab **"Metrics"**
2. Lihat:
   - CPU usage
   - Memory usage
   - Network traffic
   - Request count

---

## 💰 BIAYA & LIMIT

### Free Tier ($5 Credit/Bulan)

```
✅ 500 jam execution/bulan
✅ 1 GB RAM
✅ 1 GB disk
✅ Unlimited bandwidth
✅ Unlimited projects

Estimasi:
- Website kecil: Gratis selamanya
- Website sedang: ~$3-5/bulan
- Website besar: ~$10-20/bulan
```

### Cek Usage

1. Dashboard Railway
2. Klik **"Usage"**
3. Lihat credit yang terpakai

---

## 🔧 Troubleshooting

### Error: 500 Internal Server Error

**Solusi:**
1. Cek logs di Railway
2. Pastikan `APP_KEY` sudah di-set
3. Pastikan database connected
4. Cek permission storage (set di Dockerfile)

### Error: Database Connection Failed

**Solusi:**
1. Cek variables database sudah benar
2. Pastikan MySQL service running
3. Test connection via Railway CLI

### Error: 404 Not Found

**Solusi:**
1. Cek `.htaccess` ada di `public/`
2. Cek start command sudah benar
3. Clear cache: `php artisan cache:clear`

### Website Lambat

**Solusi:**
1. Enable cache:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
2. Optimize autoload:
   ```bash
   composer dump-autoload --optimize
   ```

---

## 📁 File Penting untuk Railway

### 1. Procfile (Optional)

Buat file `Procfile` di root project:

```
web: php artisan serve --host=0.0.0.0 --port=$PORT
```

### 2. nixpacks.toml (Optional)

Buat file `nixpacks.toml`:

```toml
[phases.setup]
nixPkgs = ["php82", "php82Packages.composer"]

[phases.install]
cmds = ["composer install --optimize-autoloader --no-dev"]

[phases.build]
cmds = [
  "php artisan config:cache",
  "php artisan route:cache",
  "php artisan view:cache"
]

[start]
cmd = "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT"
```

### 3. .gitignore

Pastikan ada:

```
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.phpunit.result.cache
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log
```

---

## 🎯 Best Practices

### 1. Environment Variables

```
✅ Jangan commit .env ke GitHub
✅ Set semua config di Railway Variables
✅ Gunakan ${{VARIABLE}} untuk reference
```

### 2. Database

```
✅ Backup database rutin
✅ Gunakan migration untuk schema
✅ Jangan hardcode credentials
```

### 3. Security

```
✅ APP_DEBUG=false di production
✅ APP_ENV=production
✅ Gunakan HTTPS (otomatis di Railway)
✅ Update dependencies rutin
```

### 4. Performance

```
✅ Enable cache (config, route, view)
✅ Optimize autoload
✅ Compress assets
✅ Use CDN untuk static files
```

---

## 🔄 Rollback Deployment

Jika ada error setelah deploy:

1. Tab **"Deployments"**
2. Pilih deployment sebelumnya yang working
3. Klik **"⋮"** → **"Redeploy"**
4. Website kembali ke versi sebelumnya!

---

## 📞 Support

### Railway Documentation:
```
https://docs.railway.app
```

### Railway Discord:
```
https://discord.gg/railway
```

### Railway Status:
```
https://status.railway.app
```

---

## ✅ Checklist

- [ ] Push code ke GitHub
- [ ] Daftar Railway
- [ ] Deploy from GitHub repo
- [ ] Tambah MySQL database
- [ ] Setup environment variables
- [ ] Generate APP_KEY
- [ ] Setup build & start commands
- [ ] Generate public domain
- [ ] Import database
- [ ] Test website
- [ ] Test login
- [ ] Test admin panel
- [ ] Setup auto deploy

---

## 🎊 SELESAI!

Website Anda sudah online dan auto deploy dari GitHub!

**URL:**
```
https://disperindagkop-production-xxxx.up.railway.app
```

**Setiap kali push ke GitHub, website otomatis update!** 🚀

---

**Estimasi Waktu**: 15-20 menit  
**Biaya**: Gratis (dengan $5 credit/bulan)  
**Kesulitan**: ⭐⭐ (Mudah)

**Selamat! Website Anda sudah production-ready!** 🎉

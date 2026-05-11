# Troubleshooting Dashboard Admin

## Masalah: Error 403 "ANDA TIDAK MEMILIKI AKSES KE HALAMAN INI"

### Penyebab Umum:

1. **Belum Login sebagai Admin**
   - Pastikan Anda login dengan akun yang memiliki role `admin`
   - Kredensial default:
     - Email: `admin@tolikara.go.id`
     - Password: (sesuai yang Anda set)

2. **User Tidak Aktif**
   - Pastikan field `is_active` di database bernilai `true`

3. **Cache Bermasalah**
   - Jalankan: `php artisan cache:clear`
   - Jalankan: `php artisan config:clear`
   - Jalankan: `php artisan route:clear`
   - Jalankan: `php artisan view:clear`

### Solusi Cepat:

#### 1. Periksa Status Admin
```bash
php artisan admin:check
```

#### 2. Periksa Admin Spesifik
```bash
php artisan admin:check admin@tolikara.go.id
```

#### 3. Buat Admin Baru (jika diperlukan)
```bash
php artisan db:seed --class=AdminUserSeeder
```

#### 4. Clear Semua Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

#### 5. Restart Development Server
```bash
# Hentikan server (Ctrl+C)
# Jalankan ulang
php artisan serve
```

### Cara Login sebagai Admin:

1. Buka browser dan akses: `http://127.0.0.1:8000/login`
2. Masukkan kredensial admin:
   - Email: `admin@tolikara.go.id`
   - Password: (password Anda)
3. Setelah login, Anda akan diarahkan ke `/admin/dashboard`

### Jika Masih Bermasalah:

#### Cek Database Langsung
```bash
php artisan tinker
```
Kemudian jalankan:
```php
User::where('role', 'admin')->get(['id', 'name', 'email', 'role', 'is_active']);
```

#### Cek Session
Pastikan file `.env` memiliki konfigurasi session yang benar:
```env
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

#### Cek Middleware
Pastikan di `routes/web.php`, route admin menggunakan middleware yang benar:
```php
Route::prefix('admin')->middleware(['auth','role:admin'])->group(function () {
    // routes...
});
```

### Fitur Dashboard Admin:

Dashboard admin menampilkan:
- ✅ Statistik koperasi (total, terverifikasi, pending, ditolak)
- ✅ Grafik koperasi per distrik
- ✅ Grafik koperasi per kategori
- ✅ Daftar koperasi menunggu verifikasi
- ✅ Aktivitas terbaru sistem
- ✅ Info boxes (koperasi aktif, bantuan, users)
- ✅ Peta sebaran koperasi Kabupaten Tolikara

### Kontak Support:

Jika masalah masih berlanjut, hubungi developer atau periksa log error di:
- `storage/logs/laravel.log`

---

**Terakhir diperbarui:** 11 April 2026

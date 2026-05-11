# ✅ FITUR PENGATURAN SISTEM - ADMIN

## STATUS: SELESAI ✅

---

## RINGKASAN FITUR

Fitur **Pengaturan Sistem** memungkinkan Admin untuk mengatur seluruh tampilan dan konfigurasi aplikasi tanpa perlu edit kode:

### ✅ Yang Bisa Diatur:
1. **Informasi Umum**
   - Nama Aplikasi
   - Nama Singkat
   - Deskripsi Aplikasi
   - Footer Text

2. **Tampilan (Appearance)**
   - Logo Aplikasi (Sidebar & Header)
   - Logo Login
   - Favicon
   - Warna Primary
   - Warna Secondary
   - Warna Sidebar
   - Warna Success
   - Warna Warning
   - Warna Danger

3. **Informasi Kontak**
   - Email
   - Telepon
   - WhatsApp
   - Alamat

---

## FILES YANG DIBUAT

### 1. **Model**
- `app/Models/SystemSetting.php` (tidak digunakan, pakai Setting.php yang sudah ada)
- Menggunakan: `app/Models/Setting.php` (sudah ada)

### 2. **Controller**
- `app/Http/Controllers/Admin/SystemSettingController.php`
  - Method: `index()` - Tampilkan halaman pengaturan
  - Method: `update()` - Simpan pengaturan
  - Method: `reset()` - Reset ke default

### 3. **View**
- `resources/views/admin/settings/index.blade.php`
  - UI modern dengan tabs (Umum, Tampilan, Kontak)
  - Form upload logo dengan preview
  - Color picker untuk warna
  - Tombol Save & Reset

### 4. **Routes**
- `routes/web.php`
  ```php
  Route::get("/settings", [SystemSettingController::class, "index"])->name("settings.index");
  Route::put("/settings", [SystemSettingController::class, "update"])->name("settings.update");
  Route::get("/settings/reset", [SystemSettingController::class, "reset"])->name("settings.reset");
  ```

### 5. **Sidebar Menu**
- `resources/views/layouts/app.blade.php`
  - Menu "Pengaturan Sistem" di section PENGATURAN
  - Icon: `fas fa-cog`

---

## CARA MENGGUNAKAN

### 1. **Akses Halaman Pengaturan**
1. Login sebagai **Admin**
2. Klik menu **"Pengaturan Sistem"** di sidebar (section PENGATURAN)
3. Halaman pengaturan akan terbuka dengan 3 tabs

### 2. **Tab Umum**
- Atur **Nama Aplikasi** (ditampilkan di header, sidebar, dll)
- Atur **Nama Singkat** (ditampilkan di logo)
- Atur **Deskripsi Aplikasi**
- Atur **Footer Text**

### 3. **Tab Tampilan**

#### A. Logo & Gambar
- **Logo Aplikasi**: Upload logo untuk sidebar & header
  - Klik "Pilih Gambar"
  - Pilih file (JPG/PNG, max 2MB)
  - Preview langsung muncul
  
- **Logo Login**: Upload logo untuk halaman login
  
- **Favicon**: Upload icon untuk tab browser

#### B. Warna Tema
- **Warna Primary**: Warna utama aplikasi (tombol, link, dll)
- **Warna Secondary**: Warna sekunder
- **Warna Sidebar**: Warna background sidebar
- **Warna Success**: Warna hijau untuk status sukses
- **Warna Warning**: Warna kuning untuk warning
- **Warna Danger**: Warna merah untuk danger

Cara mengubah warna:
1. Klik kotak warna
2. Pilih warna dari color picker
3. Preview langsung muncul di sebelah input

### 4. **Tab Kontak**
- Atur **Email** kontak resmi
- Atur **Telepon** kantor
- Atur **WhatsApp** untuk kontak
- Atur **Alamat** lengkap kantor

### 5. **Simpan Pengaturan**
- Klik tombol **"Simpan Pengaturan"** (hijau) di bawah
- Notifikasi sukses akan muncul
- Pengaturan langsung diterapkan

### 6. **Reset ke Default**
- Klik tombol **"Reset ke Default"** (merah) di bawah
- Konfirmasi dengan SweetAlert2
- Semua pengaturan kembali ke nilai default

---

## FITUR UI

### 1. **Header Modern**
- Gradient ungu (667eea → 764ba2)
- Icon gear besar
- Judul & deskripsi

### 2. **Tabs Navigation**
- 3 tabs: Umum, Tampilan, Kontak
- Active state dengan gradient
- Icon untuk setiap tab
- Smooth transition

### 3. **Setting Items**
- Card dengan border kiri biru
- Label dengan icon
- Description text
- Input field modern
- Hover effects

### 4. **Upload Logo**
- Preview image (100x100px)
- Tombol "Pilih Gambar" dengan gradient
- Info format & ukuran file
- Preview langsung saat upload

### 5. **Color Picker**
- Input type color (100x50px)
- Preview warna di sebelah label
- Update preview saat berubah

### 6. **Action Buttons**
- Tombol "Simpan" (hijau) dengan icon save
- Tombol "Reset" (merah) dengan icon undo
- Hover effects dengan shadow
- Responsive layout

### 7. **Notifications**
- SweetAlert2 untuk success/error
- Konfirmasi reset dengan popup
- Auto-hide setelah 3 detik

---

## STRUKTUR DATA

### Setting Model (app/Models/Setting.php)
```php
protected $fillable = ['key', 'value'];

// Get setting
Setting::get('app_name', 'Default Name');

// Set setting
Setting::set('app_name', 'New Name');
```

### Default Values
```php
[
    'app_name' => 'DISPERINDAGKOP',
    'app_short_name' => 'Kab. Tolikara',
    'app_description' => 'Sistem Informasi Manajemen Koperasi',
    'app_footer' => '© 2026 DISPERINDAGKOP Kabupaten Tolikara. All rights reserved.',
    'logo' => 'logo.png',
    'logo_login' => 'logo.png',
    'favicon' => 'logo.png',
    'color_primary' => '#1a3a6e',
    'color_secondary' => '#3b82f6',
    'color_sidebar' => '#1a3a6e',
    'color_success' => '#10b981',
    'color_warning' => '#f59e0b',
    'color_danger' => '#ef4444',
    'contact_email' => 'disperindagkop@tolikara.go.id',
    'contact_phone' => '(0969) 12345',
    'contact_whatsapp' => '081234567890',
    'contact_address' => 'Kabupaten Tolikara, Papua Pegunungan',
]
```

---

## CARA MENGGUNAKAN SETTINGS DI VIEW

### 1. **Di Blade Template**
```blade
{{-- Get app name --}}
<h1>{{ \App\Models\Setting::get('app_name', 'DISPERINDAGKOP') }}</h1>

{{-- Get logo --}}
<img src="{{ asset('storage/' . \App\Models\Setting::get('logo', 'logo.png')) }}" alt="Logo">

{{-- Get color --}}
<div style="background-color: {{ \App\Models\Setting::get('color_primary', '#1a3a6e') }}">
    Content
</div>
```

### 2. **Di Controller**
```php
use App\Models\Setting;

$appName = Setting::get('app_name', 'DISPERINDAGKOP');
$logo = Setting::get('logo', 'logo.png');
$primaryColor = Setting::get('color_primary', '#1a3a6e');
```

### 3. **Di CSS (Dynamic)**
```blade
<style>
:root {
    --color-primary: {{ \App\Models\Setting::get('color_primary', '#1a3a6e') }};
    --color-secondary: {{ \App\Models\Setting::get('color_secondary', '#3b82f6') }};
    --color-sidebar: {{ \App\Models\Setting::get('color_sidebar', '#1a3a6e') }};
    --color-success: {{ \App\Models\Setting::get('color_success', '#10b981') }};
    --color-warning: {{ \App\Models\Setting::get('color_warning', '#f59e0b') }};
    --color-danger: {{ \App\Models\Setting::get('color_danger', '#ef4444') }};
}

.btn-primary {
    background-color: var(--color-primary);
}

.sidebar {
    background-color: var(--color-sidebar);
}
</style>
```

---

## TESTING CHECKLIST

### ✅ Test 1: Ubah Informasi Umum
1. Login sebagai Admin
2. Masuk ke **Pengaturan Sistem**
3. Tab **Umum**
4. Ubah "Nama Aplikasi" menjadi "TEST APP"
5. Klik **"Simpan Pengaturan"**
6. **EXPECTED**: Notifikasi sukses, nama aplikasi berubah di header

### ✅ Test 2: Upload Logo
1. Tab **Tampilan**
2. Section "Logo & Gambar"
3. Klik **"Pilih Gambar"** untuk Logo Aplikasi
4. Pilih file gambar (JPG/PNG)
5. **EXPECTED**: Preview langsung muncul
6. Klik **"Simpan Pengaturan"**
7. **EXPECTED**: Logo berubah di sidebar

### ✅ Test 3: Ubah Warna Tema
1. Tab **Tampilan**
2. Section "Warna Tema"
3. Klik kotak warna "Warna Primary"
4. Pilih warna baru (misal: merah #ff0000)
5. **EXPECTED**: Preview warna berubah
6. Klik **"Simpan Pengaturan"**
7. **EXPECTED**: Warna primary berubah di aplikasi

### ✅ Test 4: Ubah Kontak
1. Tab **Kontak**
2. Ubah Email, Telepon, WhatsApp, Alamat
3. Klik **"Simpan Pengaturan"**
4. **EXPECTED**: Notifikasi sukses

### ✅ Test 5: Reset ke Default
1. Klik tombol **"Reset ke Default"**
2. **EXPECTED**: Popup konfirmasi muncul
3. Klik **"Ya, Reset!"**
4. **EXPECTED**: Semua pengaturan kembali ke default

---

## RESPONSIVE DESIGN

### Desktop (> 768px)
- Tabs horizontal
- Form 2 kolom untuk beberapa field
- Action buttons di kanan

### Mobile (< 768px)
- Tabs vertical (stack)
- Form 1 kolom
- Action buttons full width
- Preview logo lebih kecil

---

## SECURITY

### 1. **Authorization**
- Hanya Admin yang bisa akses
- Middleware: `auth`, `role:admin`

### 2. **Validation**
- File upload: max 2MB, format JPG/PNG
- Required fields
- CSRF protection

### 3. **File Upload**
- Stored di `storage/app/public/settings/`
- Old file dihapus saat upload baru
- Filename dengan timestamp untuk unique

---

## CACHE

Settings menggunakan cache untuk performa:
```php
// Cache selama 1 jam (3600 detik)
Cache::remember('setting_' . $key, 3600, function () use ($key, $default) {
    return static::where('key', $key)->value('value') ?? $default;
});

// Clear cache saat update
Cache::forget('setting_' . $key);
```

---

## SUMMARY

### ✅ SELESAI:
1. ✅ Model Setting (menggunakan yang sudah ada)
2. ✅ Controller dengan 3 methods
3. ✅ View modern dengan tabs
4. ✅ Routes untuk CRUD
5. ✅ Sidebar menu
6. ✅ Upload logo dengan preview
7. ✅ Color picker
8. ✅ Reset ke default
9. ✅ SweetAlert2 notifications
10. ✅ Responsive design

### 🎯 FITUR UTAMA:
- **No Code Editing**: Semua bisa diatur dari UI
- **Live Preview**: Logo dan warna langsung preview
- **Easy Reset**: Tombol reset ke default
- **Modern UI**: Gradient, tabs, hover effects
- **Responsive**: Mobile friendly

### 📊 STATISTIK:
- **Settings**: 17 pengaturan
- **Groups**: 3 (Umum, Tampilan, Kontak)
- **File Upload**: 3 (Logo, Logo Login, Favicon)
- **Color Picker**: 6 warna
- **Lines of Code**: ~500 (view), ~150 (controller)

---

**DOKUMENTASI DIBUAT**: 17 April 2026  
**STATUS**: ✅ COMPLETE  
**FITUR**: Pengaturan Sistem (Admin)

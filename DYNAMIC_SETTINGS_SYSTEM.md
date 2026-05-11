# 🎨 DYNAMIC SETTINGS SYSTEM

## 📋 Overview
Sistem Pengaturan Dinamis yang memungkinkan Admin mengubah logo, warna, dan informasi sistem tanpa perlu edit kode. Semua perubahan otomatis diterapkan ke seluruh sistem (Admin, Petugas, Pimpinan, Koperasi, Anggota, dan Public/User).

---

## ✅ STATUS: COMPLETED

### ✨ Fitur yang Sudah Diimplementasikan

#### 1. **Halaman Pengaturan Sistem (Admin)**
- **Route**: `/admin/settings`
- **Controller**: `App\Http\Controllers\Admin\SystemSettingController`
- **View**: `resources/views/admin/settings/index.blade.php`

**3 Tab Pengaturan:**

##### Tab 1: Umum
- Nama Aplikasi (app_name)
- Nama Singkat (app_short_name)
- Deskripsi Aplikasi (app_description)
- Footer Text (app_footer)

##### Tab 2: Tampilan
- Logo Utama (logo) - Upload dengan preview
- Logo Login (logo_login) - Upload dengan preview
- Favicon (favicon) - Upload dengan preview
- Warna Primary (color_primary) - Color picker
- Warna Secondary (color_secondary) - Color picker
- Warna Sidebar (color_sidebar) - Color picker
- Warna Success (color_success) - Color picker
- Warna Warning (color_warning) - Color picker
- Warna Danger (color_danger) - Color picker

##### Tab 3: Kontak
- Email Kontak (contact_email)
- Nomor Telepon (contact_phone)
- WhatsApp (contact_whatsapp)
- Alamat Lengkap (contact_address)

**Fitur Tambahan:**
- ✅ Tombol Save untuk simpan perubahan
- ✅ Tombol Reset untuk kembalikan ke default
- ✅ Preview real-time untuk logo
- ✅ Color picker untuk warna
- ✅ SweetAlert2 untuk notifikasi
- ✅ Validasi upload file (image, max 2MB)

---

#### 2. **Helper Functions**
File: `app/Helpers/SettingHelper.php`

```php
// Get setting value
setting($key, $default = null)

// Get app name
app_name()

// Get logo URL
app_logo()

// Get login logo URL
app_logo_login()

// Get favicon URL
app_favicon()

// Get theme color
theme_color($type = 'primary')
// Types: primary, secondary, sidebar, success, warning, danger
```

**Registered di**: `composer.json` → autoload → files

---

#### 3. **Auto Apply ke Seluruh Sistem**

##### ✅ Layout Admin (`resources/views/layouts/app.blade.php`)
- Title & Favicon: `app_name()`, `app_favicon()`
- CSS Variables untuk warna dinamis
- Logo Sidebar: `app_logo()`
- Footer: `setting('app_footer')`

##### ✅ Halaman Login (`resources/views/auth/login.blade.php`)
- Title & Favicon dinamis
- CSS Variables untuk warna
- Logo dan text menggunakan helper functions

##### ✅ Layout Public (`resources/views/public/layouts/app.blade.php`)
- Title & Favicon: `app_name()`, `app_favicon()`
- CSS Variables: `theme_color('primary')`, `theme_color('secondary')`, dll
- Footer dinamis dengan `setting('app_footer')`
- Deskripsi aplikasi: `setting('app_description')`
- Kontak footer: `setting('contact_email')`, `setting('contact_phone')`, `setting('contact_address')`

##### ✅ Navbar Public (`resources/views/public/partials/navbar.blade.php`)
- Logo: `app_logo()`
- Nama aplikasi: `app_name()`
- Nama singkat: `setting('app_short_name')`
- Topbar kontak: `setting('contact_address')`, `setting('contact_phone')`
- Warna navbar: `theme_color('primary')`, `theme_color('secondary')`
- Tombol login: `theme_color('warning')`

---

## 🎯 Cara Penggunaan

### Untuk Admin:
1. Login sebagai Admin
2. Buka menu **Pengaturan Sistem** di sidebar
3. Pilih tab yang ingin diubah (Umum/Tampilan/Kontak)
4. Ubah nilai yang diinginkan
5. Klik **Simpan Perubahan**
6. Refresh halaman untuk melihat perubahan

### Untuk Developer:
Gunakan helper functions di view Blade:

```blade
{{-- Get app name --}}
{{ app_name() }}

{{-- Get logo --}}
<img src="{{ app_logo() }}" alt="Logo">

{{-- Get favicon --}}
<link rel="icon" href="{{ app_favicon() }}">

{{-- Get any setting --}}
{{ setting('app_description', 'Default value') }}

{{-- Get theme color --}}
<style>
    :root {
        --primary: {{ theme_color('primary') }};
        --secondary: {{ theme_color('secondary') }};
    }
</style>

{{-- Use in inline style --}}
<div style="background: {{ theme_color('primary') }};">
    Content
</div>
```

---

## 📁 File Structure

```
app/
├── Helpers/
│   └── SettingHelper.php          # Helper functions
├── Http/Controllers/Admin/
│   └── SystemSettingController.php # Controller pengaturan
└── Models/
    └── Setting.php                 # Model setting

resources/views/
├── admin/settings/
│   └── index.blade.php            # Halaman pengaturan
├── layouts/
│   └── app.blade.php              # Layout admin (updated)
├── auth/
│   └── login.blade.php            # Halaman login (updated)
└── public/
    ├── layouts/
    │   └── app.blade.php          # Layout public (updated)
    └── partials/
        └── navbar.blade.php       # Navbar public (updated)

routes/
└── web.php                        # Route settings

composer.json                      # Autoload helper
```

---

## 🗄️ Database

**Table**: `settings`

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| key | varchar(255) | Setting key (unique) |
| value | text | Setting value |
| created_at | timestamp | Created timestamp |
| updated_at | timestamp | Updated timestamp |

**Default Settings:**
- app_name: "DISPERINDAGKOP"
- app_short_name: "Kab. Tolikara"
- app_description: "Sistem Informasi..."
- app_footer: "© 2026 DISPERINDAGKOP..."
- logo: "logo.png"
- logo_login: "logo.png"
- favicon: "logo.png"
- color_primary: "#1a3a6e"
- color_secondary: "#3b82f6"
- color_sidebar: "#1a3a6e"
- color_success: "#10b981"
- color_warning: "#f59e0b"
- color_danger: "#ef4444"
- contact_email: "info@disperindagkop.tolikara.go.id"
- contact_phone: "(0964) 123456"
- contact_whatsapp: ""
- contact_address: "Jl. Raya Karubaga..."

---

## 🎨 CSS Variables

Semua layout menggunakan CSS variables untuk warna dinamis:

```css
:root {
    --primary: {{ theme_color('primary') }};
    --secondary: {{ theme_color('secondary') }};
    --accent: {{ theme_color('warning') }};
    --success: {{ theme_color('success') }};
    --danger: {{ theme_color('danger') }};
}
```

Gunakan di CSS:
```css
.button {
    background: var(--primary);
    color: white;
}
```

---

## 🔄 Reset ke Default

Admin dapat mereset semua pengaturan ke nilai default dengan:
1. Klik tombol **Reset ke Default** di halaman pengaturan
2. Konfirmasi dengan SweetAlert2
3. Sistem akan menghapus semua custom settings
4. Nilai default akan digunakan kembali

---

## ✅ Testing Checklist

- [x] Upload logo berhasil
- [x] Upload favicon berhasil
- [x] Color picker berfungsi
- [x] Save settings berhasil
- [x] Reset to default berhasil
- [x] Logo tampil di admin sidebar
- [x] Logo tampil di halaman login
- [x] Logo tampil di navbar public
- [x] Warna berubah di admin
- [x] Warna berubah di login
- [x] Warna berubah di public
- [x] Footer dinamis di admin
- [x] Footer dinamis di public
- [x] Kontak dinamis di navbar public
- [x] Kontak dinamis di footer public
- [x] Title & favicon dinamis di semua halaman

---

## 🚀 Next Steps (Optional)

1. **Social Media Links**: Tambah setting untuk Facebook, Instagram, YouTube, Twitter
2. **Email Settings**: SMTP configuration untuk email
3. **SEO Settings**: Meta keywords, meta description per halaman
4. **Maintenance Mode**: Toggle maintenance mode dari pengaturan
5. **Multi-language**: Support multiple languages
6. **Theme Presets**: Preset warna (Blue, Green, Red, Purple)
7. **Advanced Customization**: Custom CSS/JS injection

---

## 📝 Notes

- Semua logo disimpan di `public/` atau `storage/app/public/`
- File helper di-autoload via `composer.json`
- Cache view otomatis di-clear setelah save
- Gunakan `php artisan view:clear` jika perubahan tidak tampil
- Default values di helper functions sebagai fallback
- Validasi upload: image, max 2MB
- Support format: jpg, jpeg, png, gif, svg

---

## 👨‍💻 Developer Info

**Created**: April 2026  
**Version**: 1.0.0  
**Status**: Production Ready ✅

**Prinsip Design:**
- **Dynamic Over Static**: Semua yang bisa diubah, harus bisa diubah dari UI
- **No Code Edit**: Admin tidak perlu edit kode untuk customization
- **Auto Apply**: Perubahan langsung diterapkan ke seluruh sistem
- **Fallback Ready**: Selalu ada default value jika setting tidak ada
- **User Friendly**: UI intuitif dengan preview dan color picker

---

## 🎉 COMPLETED SUCCESSFULLY!

Sistem Dynamic Settings sudah selesai dan siap digunakan. Admin sekarang bisa mengubah logo, warna, dan informasi sistem tanpa perlu edit kode. Semua perubahan otomatis diterapkan ke seluruh sistem!

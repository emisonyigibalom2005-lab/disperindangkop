# 📍 Lokasi Menu Navbar/Sidebar Petugas

## 📁 **File Utama**

### **File Layout (Sidebar/Navbar)**
```
📂 resources/views/layouts/app.blade.php
```

**Lokasi di file:** Baris sekitar **780-820**

**Bagian kode:**
```php
{{-- ═══════════ PETUGAS MENU ═══════════ --}}
@elseif(auth()->user()->isPetugas())
    <li class="nav-item">
        <a href="{{ route('petugas.dashboard') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
        </a>
    </li>
    
    <li class="nav-header">MANAJEMEN KOPERASI</li>
    <li class="nav-item">
        <a href="{{ route('petugas.koperasi.index') }}">
            <i class="nav-icon fas fa-store"></i><p>Semua Koperasi</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('petugas.koperasi.create') }}">
            <i class="nav-icon fas fa-plus-circle"></i><p>Daftar Koperasi Baru</p>
        </a>
    </li>
    
    <li class="nav-header">MANAJEMEN ANGGOTA</li>
    <li class="nav-item">
        <a href="{{ route('petugas.anggota.index') }}">
            <i class="nav-icon fas fa-users"></i><p>Data Anggota</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('petugas.anggota.create') }}">
            <i class="nav-icon fas fa-user-plus"></i><p>Daftar Koperasi Baru</p>
        </a>
    </li>
    
    <li class="nav-header">DISTRIBUSI BANTUAN</li>
    <li class="nav-item">
        <a href="{{ route('petugas.bantuan.index') }}">
            <i class="nav-icon fas fa-hand-holding-usd"></i><p>Distribusi Bantuan</p>
        </a>
    </li>
    
    <li class="nav-header">JADWAL</li>
    <li class="nav-item">
        <a href="{{ route('petugas.jadwal.index') }}">
            <i class="nav-icon fas fa-calendar"></i><p>Jadwal Saya</p>
        </a>
    </li>
    
    <li class="nav-header">AKUN</li>
    <li class="nav-item">
        <a href="#">
            <i class="nav-icon fas fa-user"></i><p>Profil Saya</p>
        </a>
    </li>
    
    <li class="nav-item">
        <a href="{{ route('logout') }}">
            <i class="nav-icon fas fa-sign-out-alt"></i><p>Keluar</p>
        </a>
    </li>
@endif
```

---

## 📂 **Struktur Folder**

### **1. Views (Tampilan)**
```
resources/views/
├── layouts/
│   └── app.blade.php          ← FILE UTAMA MENU NAVBAR/SIDEBAR
│
├── petugas/
│   ├── dashboard.blade.php    ← Halaman Dashboard Petugas
│   │
│   ├── koperasi/
│   │   ├── index.blade.php    ← Semua Koperasi
│   │   ├── create.blade.php   ← Daftar Koperasi Baru
│   │   └── show.blade.php     ← Detail Koperasi
│   │
│   ├── anggota/
│   │   ├── index.blade.php    ← Data Anggota
│   │   ├── create.blade.php   ← Daftar Koperasi Baru (Anggota)
│   │   ├── show.blade.php     ← Detail Anggota
│   │   ├── pendaftaran-ditutup.blade.php
│   │   └── kuota-penuh.blade.php
│   │
│   ├── bantuan/
│   │   └── index.blade.php    ← Distribusi Bantuan
│   │
│   └── jadwal/
│       └── index.blade.php    ← Jadwal Saya
```

### **2. Controllers (Logika)**
```
app/Http/Controllers/Petugas/
├── DashboardController.php    ← Controller Dashboard
├── KoperasiController.php     ← Controller Koperasi
├── AnggotaController.php      ← Controller Anggota
├── BantuanController.php      ← Controller Bantuan
└── JadwalController.php       ← Controller Jadwal
```

### **3. Routes (URL)**
```
routes/
└── web.php                    ← Definisi semua route petugas
```

**Contoh route petugas di web.php:**
```php
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');
    
    // Koperasi
    Route::resource('koperasi', PetugasKoperasiController::class);
    
    // Anggota
    Route::resource('anggota', PetugasAnggotaController::class);
    
    // Bantuan
    Route::resource('bantuan', PetugasBantuanController::class);
    
    // Jadwal
    Route::resource('jadwal', PetugasJadwalController::class);
});
```

---

## 🎨 **File CSS/Style**

### **CSS Khusus Petugas**
```
public/css/
└── petugas-style.css          ← Style khusus untuk petugas (warna biru)
```

**Isi file:**
```css
/* Tema Petugas - Biru Gelap */
.petugas-theme .main-sidebar {
    background: linear-gradient(180deg, #1a3a6e 0%, #0f2847 100%);
}

.petugas-theme .nav-sidebar .nav-link.active {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
}

/* Stats Cards */
.stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
```

### **Template AdminLTE**
```
public/adminlte/
├── css/
│   └── adminlte.min.css       ← CSS utama AdminLTE
├── js/
│   └── adminlte.min.js        ← JavaScript AdminLTE
└── plugins/
    ├── fontawesome-free/      ← Icon Font Awesome
    └── ...
```

---

## 🔧 **Cara Mengubah Menu**

### **1. Menambah Menu Baru**
Edit file: `resources/views/layouts/app.blade.php`

Cari bagian `{{-- ═══════════ PETUGAS MENU ═══════════ --}}`

Tambahkan:
```php
<li class="nav-item">
    <a href="{{ route('petugas.menu-baru.index') }}" class="nav-link">
        <i class="nav-icon fas fa-icon-name"></i><p>Menu Baru</p>
    </a>
</li>
```

### **2. Mengubah Nama Menu**
Edit file: `resources/views/layouts/app.blade.php`

Cari menu yang ingin diubah, misalnya:
```php
<p>Semua Koperasi</p>  ← Ubah teks ini
```

### **3. Mengubah Icon Menu**
Edit file: `resources/views/layouts/app.blade.php`

Cari icon yang ingin diubah, misalnya:
```php
<i class="nav-icon fas fa-store"></i>  ← Ubah class icon ini
```

**Referensi icon:** https://fontawesome.com/icons

### **4. Menghapus Menu**
Edit file: `resources/views/layouts/app.blade.php`

Hapus seluruh blok `<li class="nav-item">...</li>` yang ingin dihapus.

### **5. Mengubah Urutan Menu**
Edit file: `resources/views/layouts/app.blade.php`

Pindahkan blok `<li class="nav-item">...</li>` ke posisi yang diinginkan.

---

## 📊 **Struktur Menu Saat Ini**

```
🏠 Dashboard
   └── Route: petugas.dashboard
   └── File: resources/views/petugas/dashboard.blade.php

MANAJEMEN KOPERASI
├── 🏪 Semua Koperasi
│   └── Route: petugas.koperasi.index
│   └── File: resources/views/petugas/koperasi/index.blade.php
│
└── ➕ Daftar Koperasi Baru
    └── Route: petugas.koperasi.create
    └── File: resources/views/petugas/koperasi/create.blade.php

MANAJEMEN ANGGOTA
├── 👥 Data Anggota
│   └── Route: petugas.anggota.index
│   └── File: resources/views/petugas/anggota/index.blade.php
│
└── ➕ Daftar Koperasi Baru
    └── Route: petugas.anggota.create
    └── File: resources/views/petugas/anggota/create.blade.php

DISTRIBUSI BANTUAN
└── 💰 Distribusi Bantuan
    └── Route: petugas.bantuan.index
    └── File: resources/views/petugas/bantuan/index.blade.php

JADWAL
└── 📅 Jadwal Saya
    └── Route: petugas.jadwal.index
    └── File: resources/views/petugas/jadwal/index.blade.php

AKUN
├── 👤 Profil Saya
│   └── Route: (belum ada)
│
└── 🚪 Keluar
    └── Route: logout
```

---

## 🎯 **File Penting untuk Diingat**

| Komponen | File | Fungsi |
|----------|------|--------|
| **Sidebar/Navbar** | `resources/views/layouts/app.blade.php` | Menu utama sidebar |
| **Dashboard** | `resources/views/petugas/dashboard.blade.php` | Halaman dashboard |
| **CSS Petugas** | `public/css/petugas-style.css` | Style khusus petugas |
| **Routes** | `routes/web.php` | Definisi URL |
| **Controllers** | `app/Http/Controllers/Petugas/` | Logika aplikasi |

---

## 💡 **Tips**

1. **Backup sebelum edit:** Selalu backup file sebelum melakukan perubahan
2. **Gunakan Ctrl+F:** Untuk mencari teks di file dengan cepat
3. **Perhatikan indentasi:** Pastikan kode rapi dan mudah dibaca
4. **Test setelah edit:** Selalu test perubahan di browser
5. **Clear cache:** Jika perubahan tidak muncul, clear cache browser (Ctrl+Shift+R)

---

## 🔍 **Cara Mencari Menu di File**

1. Buka file: `resources/views/layouts/app.blade.php`
2. Tekan `Ctrl + F` (Windows) atau `Cmd + F` (Mac)
3. Ketik: `PETUGAS MENU`
4. Akan langsung ke bagian menu petugas

---

**Dibuat:** 16 April 2026  
**File Utama:** `resources/views/layouts/app.blade.php` (Baris 780-820)  
**Folder Views:** `resources/views/petugas/`  
**Folder Controllers:** `app/Http/Controllers/Petugas/`

# ⚡ Quick Start - Dashboard Admin

## 🎯 Masalah: Error 403 di Dashboard

### ✅ Solusi Cepat (3 Langkah):

#### 1️⃣ Login sebagai Admin
```
URL: http://127.0.0.1:8000/login
Email: admin@tolikara.go.id
Password: [password Anda]
```

#### 2️⃣ Jika Lupa Password
```bash
php artisan admin:check admin@tolikara.go.id
# Pilih opsi reset password
```

#### 3️⃣ Clear Cache (jika perlu)
```bash
php artisan config:clear
php artisan cache:clear
```

## 🔍 Cek Status Sistem

```bash
php tests/test-admin-access.php
```

## 📊 Dashboard Features

✅ **Statistik Real-time**
- Total Koperasi: 0
- Terverifikasi: 0
- Pending: 0
- Penerima Bantuan: 0

✅ **Grafik Interaktif**
- Koperasi per Distrik
- Kategori Koperasi

✅ **Peta Sebaran**
- Leaflet.js Map
- Marker per Distrik

✅ **Aktivitas Log**
- Real-time activity tracking

## 🎨 Preview Dashboard

```
┌─────────────────────────────────────────────────────┐
│  📊 Dashboard Administrator                         │
├─────────────────────────────────────────────────────┤
│                                                     │
│  [Total: 0]  [Verified: 0]  [Pending: 0]  [Help: 0]│
│                                                     │
│  ┌──────────────────┐  ┌──────────────────┐       │
│  │ Grafik Distrik   │  │ Grafik Kategori  │       │
│  │ [Bar Chart]      │  │ [Donut Chart]    │       │
│  └──────────────────┘  └──────────────────┘       │
│                                                     │
│  ┌──────────────────────────────────────────────┐  │
│  │ Koperasi Pending Verifikasi                  │  │
│  │ [Table with Actions]                         │  │
│  └──────────────────────────────────────────────┘  │
│                                                     │
│  ┌──────────────────────────────────────────────┐  │
│  │ Peta Sebaran Koperasi Tolikara               │  │
│  │ [Interactive Leaflet Map]                    │  │
│  └──────────────────────────────────────────────┘  │
│                                                     │
└─────────────────────────────────────────────────────┘
```

## 🆘 Bantuan Cepat

| Masalah | Solusi |
|---------|--------|
| Error 403 | Login sebagai admin |
| Lupa Password | `php artisan admin:check` |
| Dashboard Kosong | Normal jika belum ada data |
| Grafik Tidak Muncul | Clear cache browser (Ctrl+F5) |

## 📞 Support

- 📄 Dokumentasi Lengkap: `CARA_LOGIN_ADMIN.md`
- 🔧 Troubleshooting: `TROUBLESHOOTING_DASHBOARD.md`
- 🧪 Test Script: `php tests/test-admin-access.php`

---

**Status:** ✅ Ready to Use  
**Last Updated:** 11 April 2026

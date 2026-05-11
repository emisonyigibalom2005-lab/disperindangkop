# 📋 Panduan Pendaftaran Anggota oleh Petugas

## 🎯 Fitur Utama

Sistem pendaftaran anggota oleh petugas dengan fitur:
- ✅ Form pendaftaran 4 langkah dengan desain modern (purple/ungu)
- ✅ Pembuatan akun user otomatis (email + password untuk login)
- ✅ Validasi periode pendaftaran aktif
- ✅ Validasi kuota pendaftaran
- ✅ Upload foto diri
- ✅ Data masuk ke admin untuk verifikasi
- ✅ Notifikasi otomatis ke anggota setelah verifikasi

---

## 🚀 Cara Menggunakan

### 1️⃣ **Login sebagai Petugas**
- Buka aplikasi
- Login dengan akun petugas
- Masuk ke dashboard petugas

### 2️⃣ **Akses Menu Pendaftaran**
- Di sidebar, cari section **"MANAJEMEN ANGGOTA"**
- Klik menu **"Daftar Anggota Baru"**

### 3️⃣ **Sistem Akan Mengecek Otomatis**

#### ❌ **Jika Pendaftaran Ditutup**
- Tampil halaman: **"Pendaftaran Sedang Ditutup"**
- Pesan: Tidak ada periode pendaftaran aktif
- Solusi: Admin harus membuka periode pendaftaran terlebih dahulu
- Langkah untuk admin:
  1. Login sebagai Admin
  2. Buka menu "Periode Pendaftaran"
  3. Klik "Tambah Periode Baru"
  4. Isi data periode (nama, tanggal mulai/selesai, kuota)
  5. Aktifkan periode pendaftaran
  6. Form pendaftaran akan otomatis tersedia

#### ⚠️ **Jika Kuota Penuh**
- Tampil halaman: **"Kuota Pendaftaran Penuh"**
- Menampilkan informasi:
  - Nama periode aktif
  - Tahun ajaran
  - Periode tanggal
  - Kuota total
  - Jumlah pendaftar
  - Sisa kuota (0 orang - PENUH)
- Solusi: Admin dapat menambah kuota atau buat periode baru

#### ✅ **Jika Pendaftaran Terbuka**
- Tampil form pendaftaran 4 langkah
- Siap untuk diisi

---

## 📝 Form Pendaftaran 4 Langkah

### **Step 1: Data Pribadi & Akun**
Field yang harus diisi:
- ✅ NIK / No. KTP (16 digit) *
- ✅ Nama Lengkap *
- ✅ Tempat Lahir *
- ✅ Tanggal Lahir *
- ✅ Jenis Kelamin *
- ✅ Agama *
- ✅ No. HP/WhatsApp *
- ✅ Email * (untuk login)
- ✅ Password * (minimal 6 karakter)
- ✅ Konfirmasi Password *
- ⚪ Foto Diri (opsional, max 2MB)

**Catatan:** Email dan password akan digunakan untuk login ke sistem sebagai anggota koperasi.

### **Step 2: Alamat**
Field yang harus diisi:
- ⚪ Desa
- ✅ Distrik *
- ⚪ Kabupaten (default: Tolikara)
- ⚪ Alamat Lengkap
- ⚪ Nama Komplek/Dekat Desa

### **Step 3: Data Usaha & Koperasi**
Field yang harus diisi:
- ✅ Pilih Koperasi * (dropdown koperasi yang sudah diverifikasi)
- ⚪ Pekerjaan
- ⚪ Pendidikan Terakhir
- ⚪ Nama Ibu Kandung

### **Step 4: Data Keanggotaan**
Field yang harus diisi:
- ⚪ Simpanan Pokok (Rp) - default: 0
- ⚪ Simpanan Wajib (Rp) - default: 0

**Keterangan:**
- `*` = Field wajib diisi
- `⚪` = Field opsional

---

## 🔄 Alur Verifikasi

### 1. **Petugas Mendaftarkan Anggota**
- Petugas mengisi form pendaftaran
- Klik "Simpan & Daftarkan Anggota"
- Sistem membuat:
  - ✅ Akun user dengan email dan password
  - ✅ Data anggota dengan status "Pending"
  - ✅ Nomor anggota otomatis (format: ANG-YYYY-XXXX)
  - ✅ Activity log

### 2. **Data Masuk ke Admin**
- Data anggota muncul di dashboard admin
- Status: **"Pending"** (menunggu verifikasi)
- Admin dapat melihat detail lengkap

### 3. **Admin Melakukan Verifikasi**
- Admin login ke dashboard admin
- Buka menu "Data Anggota"
- Pilih anggota dengan status "Pending"
- Klik "Detail" atau "Verifikasi"
- Admin memilih:
  - ✅ **Terima** → Status berubah jadi "Diverifikasi"
  - ❌ **Tolak** → Status berubah jadi "Ditolak"
- Admin bisa menambahkan catatan

### 4. **Notifikasi Otomatis**
- Sistem mengirim notifikasi ke akun anggota
- Notifikasi berisi:
  - Status verifikasi (diterima/ditolak)
  - Catatan dari admin (jika ada)
  - Tanggal verifikasi
- Anggota dapat melihat notifikasi di portal anggota

### 5. **Petugas Hanya Bisa Lihat**
- Petugas dapat melihat daftar anggota
- Petugas dapat melihat detail anggota
- Petugas **TIDAK BISA** verifikasi
- Petugas **TIDAK BISA** ubah status

---

## 🎨 Desain & Tampilan

### **Form Pendaftaran**
- Desain modern dengan gradient **purple/ungu** (#667eea - #764ba2)
- Step navigation dengan animasi
- Card dengan shadow dan border radius
- Button dengan hover effect
- Alert info untuk periode aktif
- Responsive untuk mobile

### **Halaman Pendaftaran Ditutup**
- Gradient **merah** (#ef4444 - #dc2626)
- Icon pintu tertutup dengan animasi pulse
- Info box dengan panduan lengkap
- Langkah-langkah untuk admin
- Button kembali ke dashboard

### **Halaman Kuota Penuh**
- Gradient **kuning/orange** (#f59e0b - #d97706)
- Icon users-slash dengan animasi pulse
- Info periode aktif lengkap
- Tabel informasi kuota
- Info box dengan solusi
- Button kembali ke dashboard

---

## 📊 Status Anggota

| Status | Keterangan | Warna Badge |
|--------|-----------|-------------|
| **Pending** | Menunggu verifikasi admin | Kuning |
| **Diverifikasi** | Sudah diverifikasi dan diterima | Hijau |
| **Ditolak** | Ditolak oleh admin | Merah |

---

## 🔐 Hak Akses

### **Petugas**
- ✅ Mendaftarkan anggota baru
- ✅ Melihat daftar anggota
- ✅ Melihat detail anggota
- ❌ Verifikasi anggota
- ❌ Ubah status anggota
- ❌ Hapus anggota

### **Admin**
- ✅ Melihat semua anggota
- ✅ Verifikasi anggota (terima/tolak)
- ✅ Ubah status anggota
- ✅ Edit data anggota
- ✅ Hapus anggota
- ✅ Kelola periode pendaftaran

### **Anggota**
- ✅ Login dengan email dan password
- ✅ Melihat profil sendiri
- ✅ Melihat notifikasi verifikasi
- ✅ Update profil (jika diizinkan)

---

## 🛠️ Troubleshooting

### **Problem: Menu "Daftar Anggota Baru" tidak muncul**
**Solusi:**
- Pastikan Anda login sebagai petugas
- Refresh halaman (Ctrl + F5)
- Clear cache browser

### **Problem: Tampil "Pendaftaran Ditutup"**
**Solusi:**
- Admin harus membuka periode pendaftaran
- Buka menu "Periode Pendaftaran" di admin
- Buat periode baru atau aktifkan periode yang ada

### **Problem: Tampil "Kuota Penuh"**
**Solusi:**
- Admin harus menambah kuota
- Atau admin buat periode baru dengan kuota lebih besar

### **Problem: Email sudah terdaftar**
**Solusi:**
- Gunakan email lain yang belum terdaftar
- Atau hubungi admin untuk cek data

### **Problem: NIK sudah terdaftar**
**Solusi:**
- NIK harus unik, tidak boleh duplikat
- Cek apakah anggota sudah pernah didaftarkan
- Hubungi admin jika ada masalah

---

## 📁 File Terkait

### **Controller**
- `app/Http/Controllers/Petugas/AnggotaController.php`

### **Model**
- `app/Models/Anggota.php`
- `app/Models/PeriodePendaftaran.php`
- `app/Models/User.php`

### **Views**
- `resources/views/petugas/anggota/create.blade.php` - Form pendaftaran
- `resources/views/petugas/anggota/index.blade.php` - List anggota
- `resources/views/petugas/anggota/show.blade.php` - Detail anggota
- `resources/views/petugas/anggota/pendaftaran-ditutup.blade.php` - Halaman pendaftaran ditutup
- `resources/views/petugas/anggota/kuota-penuh.blade.php` - Halaman kuota penuh

### **Routes**
- `routes/web.php` - Route untuk petugas anggota

---

## ✅ Checklist Implementasi

- [x] Form pendaftaran 4 langkah dengan desain purple/ungu
- [x] Pembuatan akun user otomatis (email + password)
- [x] Upload foto diri (1 foto saja)
- [x] Validasi periode pendaftaran aktif
- [x] Validasi kuota pendaftaran
- [x] Halaman "Pendaftaran Ditutup" dengan desain menarik
- [x] Halaman "Kuota Penuh" dengan info detail
- [x] Data masuk ke admin dengan status "Pending"
- [x] Admin bisa verifikasi (terima/tolak)
- [x] Notifikasi otomatis ke anggota
- [x] Petugas hanya bisa lihat, tidak bisa verifikasi
- [x] Menu di sidebar (bukan di card dashboard)
- [x] Activity log untuk tracking
- [x] Generate nomor anggota otomatis

---

## 🎉 Selesai!

Sistem pendaftaran anggota oleh petugas sudah siap digunakan dengan fitur lengkap dan desain modern!

**Dibuat:** 16 April 2026  
**Versi:** 1.0  
**Status:** ✅ Production Ready

# 🛡️ Cara Menggunakan Fitur Izin Akses (Permission Management)

## 📋 Deskripsi
Fitur **Izin Akses** memungkinkan Admin untuk mengatur hak akses setiap role pengguna terhadap modul-modul dalam sistem. Dengan fitur ini, Admin dapat mengontrol siapa yang bisa melihat, membuat, mengedit, menghapus, export, dan approve data di setiap modul.

---

## 🎯 Fitur Utama

### 1. **Manajemen Permission per Role**
- Atur izin akses untuk 5 role: Admin, Petugas, Pimpinan, Koperasi, Anggota
- Kontrol 6 jenis aksi: View, Create, Edit, Delete, Export, Approve
- Konfigurasi untuk 15+ modul sistem

### 2. **Dashboard Izin Akses**
- Lihat ringkasan izin untuk semua role
- Statistik modul aktif dan total izin per role
- Preview 5 modul teratas dengan izin aktif

### 3. **Editor Permission**
- Interface tabel yang mudah digunakan
- Checkbox untuk setiap kombinasi modul dan aksi
- Tombol "Select All" untuk mempercepat konfigurasi
- Tombol "Set Default" untuk mengatur izin standar

---

## 📍 Cara Mengakses

### Dari Sidebar Admin:
1. Login sebagai **Admin**
2. Buka menu **PENGATURAN** di sidebar
3. Klik **Izin Akses** (icon shield)

### Dari URL Langsung:
```
http://127.0.0.1:8000/admin/izin-akses
```

---

## 🔧 Cara Menggunakan

### A. Melihat Ringkasan Izin Akses

1. **Akses Halaman Utama**
   - Buka menu **Izin Akses** dari sidebar
   - Anda akan melihat 5 card untuk setiap role

2. **Informasi di Card Role:**
   - **Icon Role**: Visual identifier untuk setiap role
   - **Nama Role**: Administrator, Petugas, Pimpinan, dll
   - **Statistik**:
     - Modul Aktif: Jumlah modul yang memiliki izin
     - Total Izin: Jumlah total permission yang aktif
   - **Daftar Modul**: Preview 5 modul dengan badge permission
   - **Tombol Kelola**: Akses ke halaman edit permission

---

### B. Mengatur Izin Akses untuk Role

#### 1. **Masuk ke Editor Permission**
   - Klik tombol **"Kelola Izin Akses"** pada card role yang ingin diatur
   - Anda akan masuk ke halaman editor dengan tabel permission

#### 2. **Memahami Tabel Permission**

**Kolom Tabel:**
- **Modul**: Nama modul sistem (Koperasi, Anggota, Berita, dll)
- **View** 👁️: Hak untuk melihat/membaca data
- **Create** ➕: Hak untuk membuat data baru
- **Edit** ✏️: Hak untuk mengubah data
- **Delete** 🗑️: Hak untuk menghapus data
- **Export** 📥: Hak untuk export data (Excel, PDF, Word)
- **Approve** ✅: Hak untuk approve/verifikasi data

#### 3. **Mengatur Permission Manual**
   - **Centang checkbox** untuk memberikan izin
   - **Hapus centang** untuk mencabut izin
   - Anda bisa mengatur per modul atau per aksi

#### 4. **Menggunakan Tombol Pilih Cepat**

Di bagian atas tabel, tersedia tombol untuk mempercepat konfigurasi:

- **Semua View**: Centang semua permission "View"
- **Semua Create**: Centang semua permission "Create"
- **Semua Edit**: Centang semua permission "Edit"
- **Semua Delete**: Centang semua permission "Delete"
- **Semua Export**: Centang semua permission "Export"
- **Semua Approve**: Centang semua permission "Approve"
- **Hapus Semua**: Hapus semua centang (reset)

**Contoh Penggunaan:**
```
Scenario: Memberikan akses View untuk semua modul
1. Klik tombol "Semua View"
2. Semua checkbox di kolom View akan tercentang
3. Klik "Simpan Perubahan"
```

#### 5. **Menggunakan Set Default**

Tombol **"Set Default"** akan mengatur izin sesuai standar role:

**Default Permission per Role:**

**Admin:**
- ✅ Full access ke semua modul
- ✅ Semua aksi (View, Create, Edit, Delete, Export, Approve)

**Petugas:**
- ✅ View, Create, Edit, Export untuk Koperasi, Anggota, Bantuan
- ❌ Tidak ada akses Delete dan Approve
- ✅ Akses penuh untuk Berita, Pengumuman, Jadwal

**Pimpinan:**
- ✅ View dan Export untuk Koperasi, Anggota, Bantuan, Laporan
- ✅ Approve untuk Koperasi, Anggota, Bantuan
- ❌ Tidak ada akses Create, Edit, Delete

**Koperasi:**
- ✅ View dan Create untuk Bantuan
- ✅ View dan Create untuk Chat
- ❌ Akses terbatas hanya untuk modul tertentu

**Anggota:**
- ✅ View dan Create untuk Chat
- ❌ Akses sangat terbatas

**Cara Menggunakan:**
1. Klik tombol **"Set Default"**
2. Konfirmasi di popup SweetAlert
3. Sistem akan mengatur izin sesuai standar role
4. Anda bisa modifikasi lagi sesuai kebutuhan

#### 6. **Menyimpan Perubahan**
   - Setelah selesai mengatur permission
   - Klik tombol **"Simpan Perubahan"** (hijau, pojok kanan bawah)
   - Konfirmasi di popup SweetAlert
   - Tunggu hingga muncul notifikasi sukses

#### 7. **Membatalkan Perubahan**
   - Klik tombol **"Batal"** (abu-abu, pojok kiri bawah)
   - Anda akan kembali ke halaman utama
   - Perubahan yang belum disimpan akan hilang

---

### C. Contoh Skenario Penggunaan

#### Skenario 1: Memberikan Akses Penuh untuk Petugas
```
Tujuan: Petugas bisa mengelola Koperasi dan Anggota secara penuh

Langkah:
1. Buka Izin Akses > Klik "Kelola Izin" pada card Petugas
2. Cari baris "Manajemen Koperasi"
3. Centang: View, Create, Edit, Delete, Export
4. Cari baris "Manajemen Anggota"
5. Centang: View, Create, Edit, Delete, Export
6. Klik "Simpan Perubahan"
```

#### Skenario 2: Membatasi Akses Pimpinan (Hanya View dan Export)
```
Tujuan: Pimpinan hanya bisa melihat dan export laporan

Langkah:
1. Buka Izin Akses > Klik "Kelola Izin" pada card Pimpinan
2. Klik tombol "Hapus Semua" untuk reset
3. Klik tombol "Semua View" untuk centang semua View
4. Klik tombol "Semua Export" untuk centang semua Export
5. Klik "Simpan Perubahan"
```

#### Skenario 3: Memberikan Akses Approve untuk Pimpinan
```
Tujuan: Pimpinan bisa approve Koperasi dan Bantuan

Langkah:
1. Buka Izin Akses > Klik "Kelola Izin" pada card Pimpinan
2. Cari baris "Manajemen Koperasi"
3. Centang: Approve
4. Cari baris "Distribusi Bantuan"
5. Centang: Approve
6. Klik "Simpan Perubahan"
```

#### Skenario 4: Reset Permission ke Default
```
Tujuan: Mengembalikan izin ke pengaturan standar

Langkah:
1. Buka Izin Akses > Klik "Kelola Izin" pada role yang ingin direset
2. Klik tombol "Set Default"
3. Konfirmasi di popup
4. Sistem akan mengatur ulang ke default
5. Klik "Simpan Perubahan" jika sudah sesuai
```

---

## 📊 Daftar Modul yang Bisa Diatur

| No | Modul | Keterangan |
|----|-------|------------|
| 1 | Manajemen Koperasi | CRUD koperasi, verifikasi, dokumen |
| 2 | Manajemen Anggota | CRUD anggota, verifikasi, kartu |
| 3 | Distribusi Bantuan | CRUD bantuan, penerima, validasi |
| 4 | Berita & Artikel | CRUD berita, publish |
| 5 | Pengumuman | CRUD pengumuman, download |
| 6 | Galeri Kegiatan | CRUD foto/video galeri |
| 7 | Jadwal Kegiatan | CRUD jadwal, update status |
| 8 | Pelatihan | CRUD pelatihan, peserta |
| 9 | Laporan | View dan export laporan |
| 10 | Manajemen User | CRUD user, toggle status |
| 11 | Pengaturan Sistem | Konfigurasi sistem |
| 12 | Chat & Pesan | Chat antar user |
| 13 | Kontak Masuk | Pesan dari public |
| 14 | Struktur Organisasi | CRUD struktur |
| 15 | Halaman Statis | CRUD halaman custom |

---

## 🎨 Penjelasan Jenis Permission

### 1. **View (Lihat)** 👁️
- Hak untuk melihat/membaca data
- Akses ke halaman index dan detail
- Warna badge: **Biru**

**Contoh:**
- Melihat daftar koperasi
- Membaca detail anggota
- Melihat laporan

### 2. **Create (Tambah)** ➕
- Hak untuk membuat data baru
- Akses ke form create dan proses store
- Warna badge: **Hijau**

**Contoh:**
- Menambah koperasi baru
- Membuat berita baru
- Menambah user baru

### 3. **Edit (Ubah)** ✏️
- Hak untuk mengubah data existing
- Akses ke form edit dan proses update
- Warna badge: **Kuning/Orange**

**Contoh:**
- Mengubah data koperasi
- Edit profil anggota
- Update pengumuman

### 4. **Delete (Hapus)** 🗑️
- Hak untuk menghapus data
- Akses ke proses destroy
- Warna badge: **Merah**

**Contoh:**
- Menghapus koperasi
- Hapus berita
- Delete user

### 5. **Export (Ekspor)** 📥
- Hak untuk export data ke file
- Akses ke export Excel, PDF, Word
- Warna badge: **Ungu**

**Contoh:**
- Export daftar koperasi ke Excel
- Download laporan PDF
- Export data anggota

### 6. **Approve (Setujui)** ✅
- Hak untuk approve/verifikasi data
- Akses ke proses approval
- Warna badge: **Pink**

**Contoh:**
- Verifikasi koperasi
- Approve pengajuan bantuan
- Validasi penerima bantuan

---

## ⚠️ Catatan Penting

### 1. **Hierarki Permission**
- **View** adalah permission dasar
- Untuk Create/Edit/Delete, sebaiknya juga berikan View
- Approve biasanya memerlukan View

### 2. **Role Admin**
- Admin sebaiknya memiliki full access
- Jangan batasi akses Admin terlalu ketat
- Admin perlu akses untuk manage permission

### 3. **Testing Permission**
- Setelah mengatur permission, test dengan login sebagai role tersebut
- Pastikan menu dan tombol sesuai dengan permission
- Cek apakah ada error akses

### 4. **Backup Permission**
- Catat konfigurasi permission yang sudah diatur
- Gunakan "Set Default" jika terjadi kesalahan
- Bisa reset per role tanpa mempengaruhi role lain

### 5. **Keamanan**
- Jangan berikan akses Delete ke semua role
- Approve sebaiknya hanya untuk Pimpinan/Admin
- Batasi akses ke Pengaturan Sistem

---

## 🔍 Troubleshooting

### Problem 1: Permission tidak tersimpan
**Solusi:**
- Pastikan Anda klik "Simpan Perubahan"
- Cek apakah ada error di console browser
- Refresh halaman dan cek lagi

### Problem 2: User masih bisa akses meskipun permission dicabut
**Solusi:**
- User perlu logout dan login ulang
- Clear cache browser
- Pastikan middleware permission sudah diterapkan

### Problem 3: Tombol "Set Default" tidak bekerja
**Solusi:**
- Cek koneksi internet
- Refresh halaman
- Coba manual setting permission

### Problem 4: Checkbox tidak bisa dicentang
**Solusi:**
- Refresh halaman
- Clear cache browser
- Cek apakah JavaScript error di console

---

## 📱 Responsive Design

Fitur Izin Akses sudah responsive dan bisa diakses dari:
- ✅ Desktop/Laptop
- ✅ Tablet
- ✅ Mobile (dengan scroll horizontal untuk tabel)

---

## 🎯 Best Practices

1. **Mulai dengan Set Default**
   - Gunakan "Set Default" sebagai starting point
   - Modifikasi sesuai kebutuhan spesifik

2. **Test Setelah Perubahan**
   - Login sebagai role yang diubah
   - Test semua fitur yang terpengaruh

3. **Dokumentasi Perubahan**
   - Catat perubahan permission yang dilakukan
   - Simpan screenshot konfigurasi

4. **Review Berkala**
   - Review permission setiap bulan
   - Sesuaikan dengan kebutuhan organisasi

5. **Principle of Least Privilege**
   - Berikan akses minimal yang dibutuhkan
   - Tambahkan permission sesuai kebutuhan

---

## 📞 Bantuan

Jika mengalami kesulitan:
1. Baca dokumentasi ini dengan teliti
2. Cek bagian Troubleshooting
3. Hubungi Administrator Sistem
4. Gunakan fitur "Set Default" untuk reset

---

**Dibuat:** 17 April 2026  
**Versi:** 1.0  
**Status:** ✅ Aktif dan Siap Digunakan

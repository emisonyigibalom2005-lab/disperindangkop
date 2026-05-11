# 👨‍💼 PANDUAN ADMIN: VERIFIKASI PENDAFTARAN ANGGOTA

## 🎯 AKSES HALAMAN VERIFIKASI

**URL**: `/admin/anggota-verifikasi`

**Cara Akses**:
1. Login sebagai Admin
2. Klik menu sidebar: **"Verifikasi Anggota"** (di bawah menu Anggota)
3. Atau langsung buka: `http://localhost:8000/admin/anggota-verifikasi`

---

## 📊 DASHBOARD VERIFIKASI

### **Stats Cards** (3 Kartu Statistik)

1. **⏳ Menunggu Verifikasi** (Orange)
   - Jumlah pendaftar baru yang perlu ditinjau
   - Prioritas untuk diproses

2. **✅ Disetujui** (Green)
   - Jumlah anggota yang sudah diverifikasi dan aktif
   - Data tersimpan di sistem

3. **📊 Total Pendaftar** (Blue)
   - Total semua data (Pending + Aktif)
   - Overview keseluruhan

---

## 🔍 FILTER & PENCARIAN

### **Filter by Status**
- **Semua Status**: Tampilkan semua data
- **⏳ Menunggu Verifikasi**: Hanya yang belum diverifikasi
- **✅ Disetujui**: Hanya yang sudah disetujui

### **Search**
Cari berdasarkan:
- Nama anggota
- No. Anggota (AGT2026XXXX)

**Cara Pakai**:
1. Pilih status (opsional)
2. Ketik nama/no. anggota di search box
3. Klik tombol **"Cari"**

---

## 📋 CARD PENDAFTAR

Setiap card menampilkan informasi:

### **Bagian Atas**
- **Badge Status**: 
  - 🟡 Menunggu (kuning)
  - 🟢 Disetujui (hijau)

### **Bagian Tengah**
- **Foto Anggota**: Foto yang diupload saat pendaftaran
- **No. Anggota**: Badge biru dengan nomor unik
- **Data Pribadi**:
  - 📛 Nama Lengkap
  - 🆔 NIK (16 digit)
  - 📞 No. HP
  - 📍 Alamat (Distrik, Kabupaten)
  - 🏪 Nama Usaha
  - 📅 Tanggal Pendaftaran

### **Bagian Bawah**
- **Catatan Admin**: Jika ada catatan sebelumnya
- **Tombol Aksi**: Lihat Detail / Terima / Tolak

---

## ⚡ AKSI VERIFIKASI

### 1️⃣ **LIHAT DETAIL** 👁️

**Fungsi**: Melihat semua data lengkap pendaftar

**Cara Pakai**:
1. Klik tombol **"Lihat Detail"** (biru)
2. Modal popup akan muncul
3. Review semua data:
   - ✅ Data Pribadi lengkap
   - ✅ Alamat detail
   - ✅ Data Usaha
   - ✅ Data Keuangan (Bank, Rekening, NPWP)
   - ✅ Data Ahli Waris
   - ✅ Simpanan Pokok & Wajib
   - ✅ Foto-foto dokumen

**Tips**: Pastikan semua data sesuai dan lengkap sebelum memutuskan terima/tolak

---

### 2️⃣ **TERIMA PENDAFTARAN** ✅

**Fungsi**: Menyetujui pendaftaran dan mengaktifkan anggota

**Cara Pakai**:
1. Klik tombol **"Terima"** (hijau)
2. Modal konfirmasi muncul
3. **(Opsional)** Tambahkan catatan untuk anggota
   - Contoh: "Selamat bergabung! Jangan lupa ikut rapat perdana."
4. Klik **"Ya, Terima"**

**Yang Terjadi**:
- ✅ Status berubah: `Pending` → `Aktif`
- ✅ Tanggal verifikasi dicatat
- ✅ Catatan admin tersimpan
- ✅ **Data TERSIMPAN** di database
- ✅ Notifikasi otomatis terkirim ke anggota:
  ```
  Judul: Pendaftaran Anggota Disetujui ✅
  Pesan: Selamat! Pendaftaran Anda disetujui. 
         No. Anggota: AGT2026XXXX
  ```
- ✅ Anggota bisa akses dashboard lengkap
- ✅ Anggota bisa lihat kartu anggota digital

**Pesan Sukses**:
```
Pendaftaran disetujui! Data anggota telah tersimpan dengan No. Anggota: AGT2026XXXX
```

---

### 3️⃣ **TOLAK PENDAFTARAN** ❌

**Fungsi**: Menolak pendaftaran dan menghapus data dari sistem

**Cara Pakai**:
1. Klik tombol **"Tolak"** (merah)
2. Modal konfirmasi muncul
3. **WAJIB** isi alasan penolakan
   - Contoh: "Data NIK tidak sesuai dengan KTP"
   - Contoh: "Foto tidak jelas, mohon upload ulang"
   - Contoh: "Alamat usaha tidak lengkap"
4. Klik **"Ya, Tolak"**

**Yang Terjadi**:
- ❌ Notifikasi penolakan terkirim ke anggota:
  ```
  Judul: Pendaftaran Anggota Ditolak ❌
  Pesan: Mohon maaf, pendaftaran ditolak. 
         Alasan: [catatan admin]
  ```
- ❌ **Semua foto DIHAPUS** dari storage
- ❌ **Data anggota DIHAPUS** dari database
- ❌ **User account DIHAPUS** dari sistem
- ✅ Anggota **BISA DAFTAR ULANG** dengan NIK yang sama

**Pesan Sukses**:
```
Pendaftaran ditolak. Data anggota dan akun telah dihapus dari sistem. 
Anggota dapat mendaftar ulang.
```

---

## ⚠️ PENTING: PERBEDAAN TERIMA vs TOLAK

| Aspek | ✅ TERIMA | ❌ TOLAK |
|-------|----------|---------|
| **Data Anggota** | TERSIMPAN | DIHAPUS |
| **User Account** | TETAP ADA | DIHAPUS |
| **Foto-foto** | TERSIMPAN | DIHAPUS |
| **Status** | Aktif | - (tidak ada) |
| **Akses Dashboard** | BISA | TIDAK BISA |
| **Daftar Ulang** | TIDAK PERLU | BISA |
| **Notifikasi** | Sukses ✅ | Penolakan ❌ |

---

## 📝 CHECKLIST VERIFIKASI

Sebelum memutuskan TERIMA/TOLAK, pastikan cek:

### ✅ **Data Pribadi**
- [ ] NIK 16 digit valid
- [ ] Nama sesuai KTP
- [ ] Tempat/Tanggal lahir jelas
- [ ] No. HP aktif
- [ ] Email valid (jika ada)

### ✅ **Alamat**
- [ ] Desa/Distrik jelas
- [ ] Alamat lengkap detail
- [ ] Koordinat GPS (jika ada)

### ✅ **Data Usaha**
- [ ] Nama usaha jelas
- [ ] Bidang usaha sesuai
- [ ] Modal & omzet realistis
- [ ] Alamat usaha detail

### ✅ **Data Keuangan**
- [ ] Nama bank valid
- [ ] Nomor rekening benar
- [ ] Nama pemilik rekening sesuai
- [ ] NPWP valid (jika ada)

### ✅ **Ahli Waris**
- [ ] Nama ahli waris jelas
- [ ] Hubungan keluarga valid
- [ ] No. HP ahli waris aktif
- [ ] NIK ahli waris 16 digit

### ✅ **Simpanan**
- [ ] Simpanan pokok sesuai ketentuan
- [ ] Simpanan wajib sesuai ketentuan

### ✅ **Dokumen**
- [ ] Foto diri jelas dan sesuai
- [ ] Foto tidak blur
- [ ] Ukuran foto sesuai (max 2MB)

---

## 🎯 TIPS VERIFIKASI CEPAT

### **Prioritas Verifikasi**
1. **Urgent**: Pendaftar yang sudah menunggu >3 hari
2. **Normal**: Pendaftar baru (<3 hari)

### **Batch Processing**
- Buka 5-10 detail sekaligus di tab berbeda
- Review semua data
- Proses verifikasi berurutan

### **Komunikasi**
- Gunakan catatan admin untuk memberikan informasi tambahan
- Jika tolak, berikan alasan yang jelas dan konstruktif
- Jika terima, bisa tambahkan ucapan selamat

### **Quality Control**
- Jangan terburu-buru
- Pastikan data valid sebelum approve
- Lebih baik tolak dan minta perbaikan daripada approve data salah

---

## 🚨 TROUBLESHOOTING

### **Problem**: Data tidak muncul di halaman verifikasi
**Solusi**: 
- Cek filter status (pastikan tidak filter "Disetujui" saja)
- Cek search box (pastikan kosong atau sesuai)
- Refresh halaman (F5)

### **Problem**: Tombol "Terima" tidak muncul
**Solusi**: 
- Pastikan status anggota masih "Pending"
- Jika sudah "Aktif", tombol tidak akan muncul

### **Problem**: Modal tidak muncul saat klik tombol
**Solusi**: 
- Pastikan JavaScript aktif di browser
- Clear cache browser (Ctrl+Shift+Del)
- Coba browser lain

### **Problem**: Notifikasi tidak terkirim
**Solusi**: 
- Cek koneksi database
- Cek table `notifikasi` di database
- Pastikan `user_id` anggota valid

---

## 📞 KONTAK SUPPORT

Jika ada masalah teknis:
1. Screenshot error message
2. Catat langkah yang dilakukan
3. Hubungi IT Support

---

## 📚 REFERENSI

- **Dokumentasi Lengkap**: `SISTEM_VERIFIKASI_ANGGOTA.md`
- **Database Structure**: Lihat migration files
- **Source Code**: 
  - Controller: `app/Http/Controllers/Admin/AnggotaController.php`
  - View: `resources/views/admin/anggota/verifikasi.blade.php`

---

**Dibuat oleh**: Kiro AI Assistant  
**Tanggal**: 10 April 2026  
**Versi**: 1.0.0  
**Update Terakhir**: 10 April 2026

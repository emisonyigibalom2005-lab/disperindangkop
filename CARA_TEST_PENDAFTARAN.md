# Cara Test Pendaftaran Anggota - Panduan Lengkap

## ✅ Perbaikan yang Sudah Dilakukan

1. ✅ Dropdown Status Perkawinan diperbaiki (Belum Kawin, Kawin, Cerai Hidup, Cerai Mati)
2. ✅ Validasi field required diperbaiki
3. ✅ Error messages lebih jelas dan spesifik
4. ✅ Error handling lebih baik
5. ✅ Cache sudah dibersihkan

---

## 🚀 Langkah-Langkah Test

### 1. Buka Browser
```
http://localhost/pendaftaran
atau
http://127.0.0.1:8000/pendaftaran
```

### 2. Refresh Browser (Penting!)
```
Tekan: Ctrl + Shift + R (Windows)
atau: Cmd + Shift + R (Mac)
```
Ini untuk memastikan form yang baru dimuat, bukan cache lama.

---

## 📝 Data Test yang Bisa Digunakan

### STEP 1: Data Pribadi

```
NIK: 9113211112309001
Nama Lengkap: EMISON JIGIBALOMI
Tempat Lahir: Benari
Tanggal Lahir: 17/04/2000 (pilih tanggal di masa lalu)
Jenis Kelamin: Laki-laki
Status Perkawinan: Kawin ← PENTING! Pilih "Kawin" bukan "Menikah"
Pendidikan Terakhir: SMP
Agama: Islam
No. HP/WhatsApp: 081234567890
Email: emison.test@gmail.com (gunakan email unik)
Password: 123456
Konfirmasi Password: 123456
```

**Klik "Selanjutnya"**

---

### STEP 2: Alamat

```
Desa: (kosongkan, opsional)
Distrik: Karubaga ← WAJIB DIISI
Kabupaten: Tolikara (sudah terisi otomatis)
Alamat Lengkap: (kosongkan, opsional)
Kode Pos: (kosongkan, opsional)
Koordinat GPS: (kosongkan, opsional)
Status Kepemilikan Rumah: (kosongkan, opsional)
```

**Klik "Selanjutnya"**

---

### STEP 3: Data Usaha & Ahli Waris

#### Data Usaha
```
Nama Usaha: Toko Sembako Emison
Bidang Usaha: Perdagangan
Lama Berdiri Usaha: 5 (opsional)
Jumlah Karyawan: 2 (opsional)
Modal Usaha: 10000000 (opsional)
Omzet per Bulan: 5000000 (opsional)
Alamat Tempat Usaha: (opsional)
Legalitas Usaha: (opsional)
Keterangan Usaha: (opsional)
```

#### Data Ahli Waris (WAJIB)
```
Nama Ahli Waris: Maria Jigibalomi
Hubungan Keluarga: Suami/Istri
No. HP Ahli Waris: 081234567891
NIK Ahli Waris: 9113211112309002
```

**Klik "Selanjutnya"**

---

### STEP 4: Upload Foto

```
1. Klik tombol "Choose File" atau "Pilih File"
2. Pilih foto diri Anda (JPG/PNG, max 2MB)
3. Pastikan foto muncul preview
```

**Klik "Daftar Sekarang"**

---

## ✅ Hasil yang Diharapkan

### Jika Berhasil:
```
✅ Redirect ke dashboard anggota
✅ URL berubah menjadi: /anggota/dashboard
✅ Muncul pesan sukses:
   "Selamat! Pendaftaran Anda berhasil dengan nomor anggota: AGT202604XXXX. 
    Silakan tunggu verifikasi dari admin."
✅ Anda sudah login otomatis
✅ Bisa akses menu anggota
```

### Jika Ada Error:
```
❌ Tetap di halaman form
❌ Muncul alert merah di atas form
❌ Field yang error ditandai dengan border merah
❌ Muncul pesan error spesifik di bawah field
```

---

## 🔍 Troubleshooting

### Error 1: "The selected status perkawinan is invalid"

**Penyebab**: Masih menggunakan cache lama

**Solusi**:
1. Refresh browser dengan Ctrl+Shift+R
2. Atau buka Incognito/Private Window
3. Pastikan pilih "Kawin" bukan "Menikah"
4. Jika masih error, jalankan:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

---

### Error 2: "NIK sudah terdaftar"

**Penyebab**: NIK yang Anda gunakan sudah ada di database

**Solusi**:
1. Gunakan NIK yang berbeda, contoh:
   - 9113211112309003
   - 9113211112309004
   - 9113211112309005
2. Atau hapus data test dari database:
   ```sql
   DELETE FROM anggotas WHERE nik = '9113211112309001';
   DELETE FROM users WHERE email = 'emison.test@gmail.com';
   ```

---

### Error 3: "Email sudah terdaftar"

**Penyebab**: Email yang Anda gunakan sudah ada di database

**Solusi**:
1. Gunakan email yang berbeda, contoh:
   - emison.test2@gmail.com
   - emison.test3@gmail.com
   - emison.jigibalomi@gmail.com
2. Atau hapus data test dari database (lihat Error 2)

---

### Error 4: "Pendidikan terakhir wajib dipilih"

**Penyebab**: Field pendidikan tidak dipilih

**Solusi**:
1. Scroll ke atas ke Step 1
2. Pilih salah satu: SD, SMP, SMA/SMK, D3, S1, S2, S3
3. Klik "Selanjutnya" lagi

---

### Error 5: "Agama wajib dipilih"

**Penyebab**: Field agama tidak dipilih

**Solusi**:
1. Scroll ke atas ke Step 1
2. Pilih salah satu: Kristen, Islam, Katolik, Hindu, Buddha
3. Klik "Selanjutnya" lagi

---

### Error 6: "Foto diri wajib diupload"

**Penyebab**: Belum upload foto di Step 4

**Solusi**:
1. Klik tombol "Choose File"
2. Pilih foto (JPG/PNG, max 2MB)
3. Tunggu sampai muncul preview
4. Klik "Daftar Sekarang"

---

### Error 7: "Ukuran foto maksimal 2MB"

**Penyebab**: Foto yang diupload terlalu besar

**Solusi**:
1. Compress foto menggunakan:
   - https://tinypng.com
   - https://compressor.io
   - Atau aplikasi photo editor
2. Upload foto yang sudah dikompres

---

### Error 8: Form tidak bisa submit / Loading terus

**Penyebab**: JavaScript error atau koneksi terputus

**Solusi**:
1. Buka Console Browser (F12)
2. Lihat tab "Console" untuk error JavaScript
3. Refresh browser (Ctrl+F5)
4. Cek koneksi internet
5. Coba browser lain (Chrome, Firefox, Edge)

---

## 🎯 Checklist Sebelum Submit

Pastikan semua ini sudah diisi:

### Step 1: Data Pribadi
- [ ] NIK (16 digit)
- [ ] Nama Lengkap
- [ ] Tempat Lahir
- [ ] Tanggal Lahir (tanggal di masa lalu)
- [ ] Jenis Kelamin (pilih salah satu)
- [ ] Status Perkawinan (pilih: Belum Kawin/Kawin/Cerai Hidup/Cerai Mati)
- [ ] Pendidikan Terakhir (pilih salah satu)
- [ ] Agama (pilih salah satu)
- [ ] No. HP/WhatsApp
- [ ] Email (unik, belum terdaftar)
- [ ] Password (minimal 6 karakter)
- [ ] Konfirmasi Password (sama dengan password)

### Step 2: Alamat
- [ ] Distrik (wajib diisi)

### Step 3: Data Usaha & Ahli Waris
- [ ] Nama Usaha
- [ ] Bidang Usaha (pilih salah satu)
- [ ] Nama Ahli Waris
- [ ] Hubungan Keluarga (pilih salah satu)
- [ ] No. HP Ahli Waris
- [ ] NIK Ahli Waris (16 digit)

### Step 4: Upload Dokumen
- [ ] Foto Diri (JPG/PNG, max 2MB)

---

## 📊 Test Scenarios

### Scenario 1: Happy Path (Semua Benar)
```
1. Isi semua field dengan benar
2. Upload foto valid
3. Submit
4. ✅ Berhasil → Redirect ke dashboard
```

### Scenario 2: NIK Duplicate
```
1. Gunakan NIK yang sudah terdaftar
2. Submit
3. ❌ Error: "NIK sudah terdaftar"
4. Ganti NIK
5. Submit lagi
6. ✅ Berhasil
```

### Scenario 3: Email Duplicate
```
1. Gunakan email yang sudah terdaftar
2. Submit
3. ❌ Error: "Email sudah terdaftar"
4. Ganti email
5. Submit lagi
6. ✅ Berhasil
```

### Scenario 4: Status Perkawinan Salah
```
1. Jika masih ada opsi "Menikah" (cache lama)
2. Refresh browser (Ctrl+Shift+R)
3. Sekarang harus muncul "Kawin"
4. Pilih "Kawin"
5. Submit
6. ✅ Berhasil
```

### Scenario 5: Field Required Kosong
```
1. Kosongkan field Status Perkawinan
2. Klik "Selanjutnya"
3. ❌ Error: "Status perkawinan wajib dipilih"
4. Isi field
5. Klik "Selanjutnya" lagi
6. ✅ Lanjut ke step berikutnya
```

---

## 🔧 Command untuk Reset Test Data

Jika ingin reset data test untuk test ulang:

```sql
-- Hapus anggota test
DELETE FROM anggotas WHERE nik LIKE '911321111230900%';

-- Hapus user test
DELETE FROM users WHERE email LIKE 'emison%@%';

-- Reset auto increment (opsional)
ALTER TABLE anggotas AUTO_INCREMENT = 1;
ALTER TABLE users AUTO_INCREMENT = 1;
```

Atau via Artisan:
```bash
php artisan tinker
>>> App\Models\Anggota::where('nik', 'like', '911321111230900%')->delete();
>>> App\Models\User::where('email', 'like', 'emison%@%')->delete();
```

---

## 📱 Test di Mobile

### Browser Mobile
1. Buka browser di HP
2. Akses: http://[IP-KOMPUTER]:8000/pendaftaran
3. Isi form (sama seperti di desktop)
4. Submit

### Responsive Design
- Form harus responsive
- Dropdown harus mudah diklik
- Upload foto harus berfungsi
- Navigation buttons harus terlihat

---

## 🎉 Setelah Berhasil Daftar

### Apa yang Terjadi?
1. ✅ Akun dibuat otomatis
2. ✅ Auto-login ke dashboard anggota
3. ✅ Nomor anggota di-generate: AGT202604XXXX
4. ✅ Status: Pending (Menunggu Verifikasi)
5. ✅ Email notifikasi dikirim (jika sudah setup)

### Apa yang Bisa Dilakukan?
1. ✅ Lihat profil anggota
2. ✅ Lihat status pendaftaran
3. ✅ Lihat nomor anggota
4. ⏳ Tunggu verifikasi admin
5. ⏳ Setelah diverifikasi, status berubah "Aktif"

### Menu yang Tersedia
- Dashboard Anggota
- Profil Saya
- Riwayat Simpanan (setelah diverifikasi)
- Pengajuan Bantuan (setelah diverifikasi)
- Notifikasi
- Logout

---

## 📞 Jika Masih Ada Masalah

### Cek Log Error
```bash
# Lihat log Laravel
tail -f storage/logs/laravel.log

# Atau buka file
storage/logs/laravel-2026-04-18.log
```

### Cek Database
```sql
-- Cek data anggota terakhir
SELECT * FROM anggotas ORDER BY id DESC LIMIT 5;

-- Cek user terakhir
SELECT * FROM users ORDER BY id DESC LIMIT 5;

-- Cek periode aktif
SELECT * FROM periode_pendaftarans WHERE is_buka = 1;
```

### Hubungi Developer
Jika masih error, kirim screenshot:
1. Screenshot form dengan error
2. Screenshot Console Browser (F12 → Console)
3. Screenshot Network tab (F12 → Network)
4. Copy error message dari log

---

## ✅ Summary

### Yang Sudah Diperbaiki:
1. ✅ Dropdown Status Perkawinan (Belum Kawin, Kawin, Cerai Hidup, Cerai Mati)
2. ✅ Validasi required untuk Pendidikan dan Agama
3. ✅ Error messages lebih jelas
4. ✅ Error handling lebih baik
5. ✅ Cache sudah dibersihkan

### Yang Perlu Dilakukan:
1. 🔄 Test pendaftaran dengan data di atas
2. 🔄 Pastikan tidak ada error
3. 🔄 Verifikasi data masuk ke database
4. 🔄 Test auto-login setelah daftar
5. 🔄 Test dashboard anggota

### Expected Result:
✅ Pendaftaran berjalan lancar tanpa error
✅ User bisa daftar dan langsung login
✅ Data tersimpan dengan benar di database
✅ Status: Pending (menunggu verifikasi admin)

---

**Selamat Testing!** 🚀

Jika ada pertanyaan atau masalah, silakan hubungi developer.

# Cara Membuat Pengumuman yang Tampil di Halaman Publik

## Langkah-langkah:

### 1. Login sebagai Admin
- Akses halaman `/admin/pengumuman`

### 2. Klik "Tambah Pengumuman"
- Isi form pengumuman:
  - **Judul**: Judul pengumuman
  - **Isi**: Konten pengumuman (detail lengkap)
  - **Jenis**: Pilih jenis (Info/Penting/Urgent)
  - **Tanggal, Hari, Jam, Tahun**: Waktu pengumuman (opsional)
  - **Pembuat**: Nama pembuat/penandatangan
  - **Foto**: Upload foto pendukung (opsional)
  - **Link**: Link terkait (opsional)

### 3. PENTING: Pengaturan Tampil
- ✅ **Centang "Aktif"** agar pengumuman ditampilkan
- ✅ **Pilih "Tampil Di"**: 
  - **Semua** = Tampil untuk semua user (publik, admin, koperasi, anggota)
  - **Admin** = Hanya admin yang bisa lihat
  - **Koperasi** = Hanya koperasi yang bisa lihat
  - **Anggota** = Hanya anggota yang bisa lihat

### 4. Simpan Pengumuman
- Klik tombol "Simpan"
- Pengumuman akan otomatis muncul di halaman publik

## Cara User Melihat Pengumuman:

1. Akses website (tidak perlu login)
2. Klik menu **"Pengumuman"** di navbar
3. Atau langsung ke `/pengumuman`
4. Semua pengumuman aktif akan ditampilkan

## Filter Pengumuman di Publik:

Pengumuman yang ditampilkan:
- ✅ `is_aktif = true` (dicentang "Aktif")
- ✅ `tampil_di = "semua"` atau `"anggota"`
- ✅ Dalam periode tampil (jika diset)
- ❌ Pengumuman tidak aktif tidak ditampilkan
- ❌ Pengumuman dengan `tampil_di = "admin"` atau `"koperasi"` tidak ditampilkan di publik

## Desain Features:

1. **Responsive Design**: Mobile-friendly
2. **Hover Effects**: Card naik saat di-hover
3. **Gradient Colors**: Navy blue dan gold
4. **Official Look**: Desain seperti surat resmi
5. **Print-Friendly**: Tombol action hilang saat print
6. **Share Function**: Native share API atau copy link
7. **Pagination**: Menampilkan 10 pengumuman per halaman

## Troubleshooting:

### Pengumuman tidak muncul di publik?
1. Pastikan checkbox **"Aktif"** sudah dicentang
2. Pastikan **"Tampil Di"** dipilih "Halaman" atau "Keduanya"
3. Cek periode tampil (mulai_tampil dan selesai_tampil)
4. Refresh halaman `/pengumuman`

### Cara mengubah pengumuman menjadi publik:
1. Buka halaman `/admin/pengumuman`
2. Klik tombol **Edit** pada pengumuman
3. Centang checkbox **"Aktif"**
4. Pilih **"Tampil Di"** = "Halaman" atau "Keduanya"
5. Klik **Simpan**

---

**Catatan**: 
- Pengumuman dengan `tampil_di = "popup"` hanya muncul sebagai popup di homepage, tidak di halaman `/pengumuman`
- Pengumuman dengan `tampil_di = "keduanya"` akan muncul di kedua tempat
- Urutan pengumuman diatur berdasarkan field `urutan` (ascending)

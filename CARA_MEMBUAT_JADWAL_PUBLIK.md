# Cara Membuat Jadwal yang Bisa Dilihat Anggota

## Langkah-langkah:

### 1. Login sebagai Admin
- Akses halaman `/admin/jadwal`

### 2. Klik "Buat Jadwal Baru"
- Isi form jadwal:
  - **Judul**: Nama kegiatan
  - **Jenis**: Pilih jenis kegiatan (Verifikasi, Pelatihan, Penilaian Bantuan, Rapat)
  - **Tanggal**: Tanggal kegiatan
  - **Jam Mulai**: Waktu mulai
  - **Jam Selesai**: Waktu selesai (opsional)
  - **Lokasi**: Tempat kegiatan
  - **Deskripsi**: Detail kegiatan
  - **Status**: Dijadwalkan/Berlangsung/Selesai
  - **Petugas**: Pilih petugas yang bertanggung jawab

### 3. PENTING: Centang "Tampilkan ke Publik"
- ✅ **Centang checkbox "Tampilkan ke Publik"** agar jadwal bisa dilihat oleh anggota
- ❌ Jika tidak dicentang, jadwal hanya untuk internal admin

### 4. Simpan Jadwal
- Klik tombol "Simpan"
- Jadwal akan otomatis muncul di halaman anggota

## Cara Anggota Melihat Jadwal:

1. Login sebagai Anggota
2. Akses menu **"Jadwal Kegiatan"** di sidebar
3. Atau langsung ke `/anggota-portal/jadwal`
4. Semua jadwal publik akan ditampilkan dengan:
   - Stats cards (Total, Dijadwalkan, Akan Datang, Selesai)
   - Daftar jadwal dalam bentuk card
   - Tombol "Detail Lengkap" untuk melihat informasi lengkap

## Filter Jadwal di Anggota:

Jadwal yang ditampilkan ke anggota:
- ✅ `is_publik = true` (dicentang "Tampilkan ke Publik")
- ✅ Status: Dijadwalkan, Berlangsung, atau Selesai
- ❌ Status "Dibatalkan" tidak ditampilkan

## Fitur Jadwal Anggota:

1. **Stats Cards**: Menampilkan statistik jadwal
2. **Card Layout**: Setiap jadwal ditampilkan dalam card yang menarik
3. **Badge Status**: Menampilkan jenis dan status jadwal dengan warna
4. **Detail Modal**: Klik "Detail Lengkap" untuk melihat informasi lengkap
5. **Responsive**: Tampilan mobile-friendly
6. **Pagination**: Menampilkan 12 jadwal per halaman

## Troubleshooting:

### Jadwal tidak muncul di anggota?
1. Pastikan checkbox **"Tampilkan ke Publik"** sudah dicentang
2. Pastikan status jadwal bukan "Dibatalkan"
3. Refresh halaman anggota

### Cara mengubah jadwal menjadi publik:
1. Buka halaman `/admin/jadwal`
2. Klik tombol **Edit** pada jadwal yang ingin diubah
3. Centang checkbox **"Tampilkan ke Publik"**
4. Klik **Simpan**

---

**Catatan**: Hanya jadwal dengan status "Dijadwalkan", "Berlangsung", atau "Selesai" yang akan ditampilkan ke anggota. Jadwal dengan status "Dibatalkan" tidak akan muncul.

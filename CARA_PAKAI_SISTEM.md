# 📖 CARA PAKAI SISTEM ANGGOTA KOPERASI

## 🎯 PANDUAN SINGKAT UNTUK ADMIN

---

## 1️⃣ VERIFIKASI PENDAFTARAN BARU

### Kapan Digunakan?
Saat ada anggota baru yang mendaftar dan perlu diverifikasi.

### Cara Menggunakan:

**Langkah 1**: Login sebagai Admin

**Langkah 2**: Buka menu **Admin → Verifikasi Pendaftaran**

**Langkah 3**: Anda akan melihat daftar pendaftaran baru:
```
┌─────────────────────────────────────────────────────────┐
│  VERIFIKASI PENDAFTARAN                                 │
├─────────────────────────────────────────────────────────┤
│  📋 Menunggu Verifikasi: 5 anggota                      │
│  ❌ Ditolak: 0 anggota                                  │
│  ✅ Sudah Diverifikasi: 5 anggota                       │
├─────────────────────────────────────────────────────────┤
│  No. Anggota    │ Nama              │ Status  │ Aksi   │
│  AGT2026040004  │ EMISON JIGIBALOM  │ Pending │ Detail │
│  AGT2026050001  │ EMISON JIGIBALOM  │ Pending │ Detail │
│  AGT2026050002  │ Emison Yigibalom  │ Pending │ Detail │
│  AGT2026050003  │ Emison Yigibalom  │ Pending │ Detail │
│  AG2026050001   │ Emison Yigibalom  │ Pending │ Detail │
└─────────────────────────────────────────────────────────┘
```

**Langkah 4**: Klik **"Detail"** untuk melihat data lengkap anggota

**Langkah 5**: Pilih aksi:
- **TERIMA** → Anggota disetujui, pindah ke Data Anggota Koperasi
- **TOLAK** → Anggota ditolak, tetap di Verifikasi Pendaftaran

### Hasil Setelah TERIMA:
```
✅ Anggota disetujui!
├─ Status: Aktif
├─ tanggal_bergabung: Terisi (sekarang)
├─ Pindah ke: Data Anggota Koperasi
└─ Notifikasi: "✅ Selamat! Pendaftaran Lulus"
```

### Hasil Setelah TOLAK:
```
❌ Anggota ditolak!
├─ Status: Ditolak
├─ tanggal_bergabung: Tetap NULL
├─ Tetap di: Verifikasi Pendaftaran
└─ Notifikasi: "❌ Pendaftaran Tidak Disetujui"
```

---

## 2️⃣ DATA ANGGOTA KOPERASI

### Kapan Digunakan?
Untuk mengelola anggota yang sudah diverifikasi dan diterima.

### Cara Menggunakan:

**Langkah 1**: Login sebagai Admin

**Langkah 2**: Buka menu **Admin → Data Anggota Koperasi**

**Langkah 3**: Anda akan melihat daftar anggota yang sudah diverifikasi:
```
┌─────────────────────────────────────────────────────────┐
│  DATA ANGGOTA KOPERASI                                  │
├─────────────────────────────────────────────────────────┤
│  📊 Total: 5 anggota                                    │
│  ✅ Aktif: 5 anggota                                    │
│  ⏳ Pending: 0 anggota                                  │
│  ⚠️ Nonaktif: 0 anggota                                 │
├─────────────────────────────────────────────────────────┤
│  No. Anggota    │ Nama              │ Status │ Aksi    │
│  AGT20260014    │ EMISON LANNY      │ Aktif  │ Edit    │
│  AGT20260015    │ EMISON LANNY L.   │ Aktif  │ Edit    │
│  AGT20260017    │ Dera Kogoya       │ Aktif  │ Edit    │
│  AGT2026040003  │ Mully             │ Aktif  │ Edit    │
│  AGT2026050004  │ Emison Yigibalom  │ Aktif  │ Edit    │
└─────────────────────────────────────────────────────────┘
```

**Langkah 4**: Klik **"Edit"** untuk mengubah data atau status anggota

**Langkah 5**: Anda bisa:
- Edit data pribadi anggota
- Ubah status (Aktif/Pending/Nonaktif)
- Cetak kartu anggota
- Hapus anggota

### Ubah Status Anggota:
```
Contoh: Anggota kurang aktif
├─ Edit anggota
├─ Ubah status: Aktif → Pending
├─ Simpan
└─ Hasil:
    ├─ Status: Pending
    ├─ tanggal_bergabung: TETAP TERISI
    ├─ Lokasi: TETAP di Data Anggota Koperasi
    └─ Notifikasi: "⏳ Status Keanggotaan: PENDING"
```

---

## 3️⃣ PERBEDAAN KEDUA HALAMAN

### Verifikasi Pendaftaran
```
┌─────────────────────────────────────────────────────────┐
│  📋 VERIFIKASI PENDAFTARAN                              │
├─────────────────────────────────────────────────────────┤
│  Fungsi:                                                │
│  - Menampilkan pendaftaran BARU                         │
│  - Belum diverifikasi oleh admin                        │
│                                                         │
│  Kriteria:                                              │
│  - tanggal_bergabung = NULL                             │
│  - Status: Pending atau Ditolak                         │
│                                                         │
│  Aksi:                                                  │
│  - TERIMA → Pindah ke Data Anggota Koperasi             │
│  - TOLAK → Tetap di Verifikasi Pendaftaran              │
│                                                         │
│  Saat ini: 5 anggota                                    │
└─────────────────────────────────────────────────────────┘
```

### Data Anggota Koperasi
```
┌─────────────────────────────────────────────────────────┐
│  📁 DATA ANGGOTA KOPERASI                               │
├─────────────────────────────────────────────────────────┤
│  Fungsi:                                                │
│  - Menampilkan anggota yang SUDAH diverifikasi          │
│  - Sudah diterima oleh admin                            │
│                                                         │
│  Kriteria:                                              │
│  - tanggal_bergabung = TERISI                           │
│  - Status: Aktif, Pending, atau Nonaktif                │
│                                                         │
│  Aksi:                                                  │
│  - Edit data anggota                                    │
│  - Ubah status (Aktif/Pending/Nonaktif)                 │
│  - Cetak kartu anggota                                  │
│  - Hapus anggota                                        │
│                                                         │
│  Saat ini: 5 anggota                                    │
└─────────────────────────────────────────────────────────┘
```

---

## 4️⃣ ALUR LENGKAP

### Dari Pendaftaran sampai Jadi Anggota Resmi

```
┌─────────────────────────────────────────────────────────┐
│  STEP 1: PENDAFTARAN BARU                               │
│  - Anggota baru daftar                                  │
│  - Masuk ke: VERIFIKASI PENDAFTARAN                     │
│  - Status: Pending                                      │
└─────────────────────────────────────────────────────────┘
                         ↓
┌─────────────────────────────────────────────────────────┐
│  STEP 2: ADMIN VERIFIKASI                               │
│  - Admin buka: Verifikasi Pendaftaran                   │
│  - Admin lihat data anggota                             │
│  - Admin pilih: TERIMA atau TOLAK                       │
└─────────────────────────────────────────────────────────┘
                         ↓
         ┌───────────────┴───────────────┐
         ↓                               ↓
┌──────────────────────┐       ┌──────────────────────┐
│  STEP 3a: TERIMA     │       │  STEP 3b: TOLAK      │
│  ✅ Disetujui        │       │  ❌ Ditolak          │
│  - Status: Aktif     │       │  - Status: Ditolak   │
│  - Pindah ke:        │       │  - Tetap di:         │
│    Data Anggota      │       │    Verifikasi        │
└──────────────────────┘       └──────────────────────┘
         ↓                               ↓
┌──────────────────────┐       ┌──────────────────────┐
│  STEP 4a: ANGGOTA    │       │  STEP 4b: PERBAIKAN  │
│  RESMI               │       │  - Anggota lengkapi  │
│  - Bisa dikelola     │       │    data              │
│  - Cetak kartu       │       │  - Submit ulang      │
│  - Ubah status       │       │  - Verifikasi lagi   │
└──────────────────────┘       └──────────────────────┘
```

---

## 5️⃣ TIPS UNTUK ADMIN

### ✅ DO (Lakukan):
1. **Verifikasi data dengan teliti** sebelum menerima pendaftaran
2. **Cek kelengkapan dokumen** (KTP, KK, foto, dll)
3. **Beri catatan** saat menolak pendaftaran agar anggota tahu apa yang perlu diperbaiki
4. **Ubah status anggota** (Aktif/Pending/Nonaktif) sesuai kondisi aktual
5. **Refresh browser** dengan Ctrl+Shift+R setelah melakukan perubahan

### ❌ DON'T (Jangan):
1. **Jangan terima pendaftaran** tanpa verifikasi data
2. **Jangan hapus anggota** yang masih aktif atau punya simpanan
3. **Jangan ubah status sembarangan** tanpa alasan yang jelas
4. **Jangan lupa kirim notifikasi** saat mengubah status anggota

---

## 6️⃣ PERTANYAAN UMUM

### Q: Bagaimana cara menerima pendaftaran baru?
**A**: Buka Verifikasi Pendaftaran → Klik Detail → Klik Terima

### Q: Apa yang terjadi setelah pendaftaran diterima?
**A**: Anggota pindah ke Data Anggota Koperasi dengan status Aktif

### Q: Bagaimana jika data anggota tidak lengkap?
**A**: Tolak pendaftaran dan beri catatan apa yang perlu diperbaiki

### Q: Apakah anggota yang ditolak bisa daftar lagi?
**A**: Ya, anggota bisa lengkapi data dan submit ulang

### Q: Bagaimana cara mengubah status anggota?
**A**: Buka Data Anggota Koperasi → Edit anggota → Ubah status → Simpan

### Q: Apakah anggota yang statusnya diubah pindah ke Verifikasi?
**A**: Tidak, anggota tetap di Data Anggota Koperasi

---

## 🎯 CHECKLIST UNTUK ADMIN

### Setiap Hari:
- [ ] Cek Verifikasi Pendaftaran untuk pendaftaran baru
- [ ] Verifikasi data anggota yang mendaftar
- [ ] Terima atau tolak pendaftaran sesuai kelengkapan data

### Setiap Minggu:
- [ ] Review status anggota di Data Anggota Koperasi
- [ ] Ubah status anggota yang kurang aktif menjadi Pending
- [ ] Ubah status anggota yang tidak aktif menjadi Nonaktif

### Setiap Bulan:
- [ ] Cetak laporan anggota
- [ ] Review anggota Pending dan Nonaktif
- [ ] Aktifkan kembali anggota yang sudah aktif

---

## 🎉 SELAMAT MENGGUNAKAN SISTEM!

Sistem sudah berfungsi dengan sempurna. Silakan:

1. **Refresh browser** dengan Ctrl+Shift+R
2. **Login sebagai admin**
3. **Cek Verifikasi Pendaftaran** → 5 anggota Pending
4. **Cek Data Anggota Koperasi** → 5 anggota Aktif
5. **Verifikasi pendaftaran** sesuai kebutuhan

---

**Dibuat**: 7 Mei 2026, Kamis  
**Status**: ✅ SISTEM SIAP DIGUNAKAN  
**Pesan**: Panduan lengkap untuk admin! 📖

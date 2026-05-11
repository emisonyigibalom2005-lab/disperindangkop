# 📊 DIAGRAM ALUR SISTEM ANGGOTA KOPERASI

## 🎯 ALUR LENGKAP DARI PENDAFTARAN SAMPAI PERUBAHAN STATUS

```
┌─────────────────────────────────────────────────────────────────────────┐
│                         PENDAFTARAN ANGGOTA BARU                        │
└─────────────────────────────────────────────────────────────────────────┘
                                    │
                                    ▼
                    ┌───────────────────────────────┐
                    │   Anggota Baru Daftar         │
                    │   - Status: Pending           │
                    │   - tanggal_bergabung: NULL   │
                    └───────────────────────────────┘
                                    │
                                    ▼
        ┌───────────────────────────────────────────────────────┐
        │         📋 VERIFIKASI PENDAFTARAN                     │
        │         (tanggal_bergabung = NULL)                    │
        │                                                       │
        │   Menampilkan:                                        │
        │   - Pendaftaran baru yang belum diverifikasi          │
        │   - Status: Pending atau Ditolak                      │
        └───────────────────────────────────────────────────────┘
                                    │
                    ┌───────────────┴───────────────┐
                    │                               │
                    ▼                               ▼
        ┌─────────────────────┐       ┌─────────────────────┐
        │   Admin TERIMA      │       │   Admin TOLAK       │
        │   ✅ Disetujui      │       │   ❌ Ditolak        │
        └─────────────────────┘       └─────────────────────┘
                    │                               │
                    ▼                               ▼
        ┌─────────────────────┐       ┌─────────────────────┐
        │ Status: Aktif       │       │ Status: Ditolak     │
        │ tanggal_bergabung:  │       │ tanggal_bergabung:  │
        │ 2026-05-07 (TERISI) │       │ NULL (TETAP KOSONG) │
        └─────────────────────┘       └─────────────────────┘
                    │                               │
                    ▼                               ▼
        ┌─────────────────────┐       ┌─────────────────────┐
        │ PINDAH KE:          │       │ TETAP DI:           │
        │ Data Anggota        │       │ Verifikasi          │
        │ Koperasi            │       │ Pendaftaran         │
        └─────────────────────┘       └─────────────────────┘
                    │                               │
                    ▼                               ▼
        ┌─────────────────────┐       ┌─────────────────────┐
        │ Notifikasi:         │       │ Notifikasi:         │
        │ "✅ Selamat!        │       │ "❌ Pendaftaran     │
        │ Pendaftaran Lulus"  │       │ Tidak Disetujui"    │
        └─────────────────────┘       └─────────────────────┘
                    │                               │
                    │                               ▼
                    │               ┌─────────────────────────────┐
                    │               │ Anggota bisa:               │
                    │               │ - Lengkapi data             │
                    │               │ - Submit ulang              │
                    │               │ - Masuk lagi ke Verifikasi  │
                    │               └─────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────────────────────────────────────────┐
│                      📁 DATA ANGGOTA KOPERASI                           │
│                      (tanggal_bergabung = TERISI)                       │
│                                                                         │
│   Menampilkan:                                                          │
│   - Anggota yang SUDAH PERNAH DIVERIFIKASI                              │
│   - Status: Aktif, Pending, Nonaktif                                    │
│   - Semua punya tanggal_bergabung (sudah resmi jadi anggota)            │
└─────────────────────────────────────────────────────────────────────────┘
                                    │
                    ┌───────────────┼───────────────┐
                    │               │               │
                    ▼               ▼               ▼
        ┌─────────────────┐ ┌─────────────────┐ ┌─────────────────┐
        │  Status: AKTIF  │ │ Status: PENDING │ │Status: NONAKTIF │
        │  ✅ Aktif       │ │ ⏳ Dalam Review │ │ ⚠️ Tidak Aktif  │
        └─────────────────┘ └─────────────────┘ └─────────────────┘
                                    │
                                    │
                    ┌───────────────┴───────────────┐
                    │                               │
                    ▼                               ▼
        ┌─────────────────────┐       ┌─────────────────────┐
        │ Admin ubah ke:      │       │ Admin ubah ke:      │
        │ PENDING/NONAKTIF    │       │ AKTIF               │
        └─────────────────────┘       └─────────────────────┘
                    │                               │
                    ▼                               ▼
        ┌─────────────────────┐       ┌─────────────────────┐
        │ Status berubah      │       │ Status berubah      │
        │ tanggal_bergabung:  │       │ tanggal_bergabung:  │
        │ TETAP TERISI        │       │ TETAP TERISI        │
        └─────────────────────┘       └─────────────────────┘
                    │                               │
                    ▼                               ▼
        ┌─────────────────────┐       ┌─────────────────────┐
        │ TETAP DI:           │       │ TETAP DI:           │
        │ Data Anggota        │       │ Data Anggota        │
        │ Koperasi            │       │ Koperasi            │
        │ (TIDAK PINDAH!)     │       │ (TIDAK PINDAH!)     │
        └─────────────────────┘       └─────────────────────┘
                    │                               │
                    ▼                               ▼
        ┌─────────────────────┐       ┌─────────────────────┐
        │ Notifikasi:         │       │ Notifikasi:         │
        │ "⏳ Status:         │       │ "✅ Status:         │
        │ PENDING" atau       │       │ AKTIF"              │
        │ "⚠️ Status:         │       │                     │
        │ NONAKTIF"           │       │                     │
        └─────────────────────┘       └─────────────────────┘
```

---

## 🔍 PENJELASAN DETAIL SETIAP TAHAP

### 1️⃣ PENDAFTARAN BARU
```
Input: Anggota mengisi form pendaftaran
Output: Data masuk ke database
Status: Pending
tanggal_bergabung: NULL
Lokasi: VERIFIKASI PENDAFTARAN
```

### 2️⃣ VERIFIKASI PENDAFTARAN (Admin)
```
Admin melihat: Daftar pendaftaran baru
Kriteria: tanggal_bergabung = NULL
Pilihan:
  ├─ TERIMA → Status Aktif, tanggal_bergabung terisi, pindah ke Data Anggota
  └─ TOLAK → Status Ditolak, tanggal_bergabung tetap NULL, tetap di Verifikasi
```

### 3️⃣ DATA ANGGOTA KOPERASI
```
Admin melihat: Daftar anggota yang sudah diverifikasi
Kriteria: tanggal_bergabung = TERISI (NOT NULL)
Status yang muncul:
  ├─ Aktif: Anggota aktif dan berjalan normal
  ├─ Pending: Anggota dalam review (kurang aktif, kurang laporan, dll)
  └─ Nonaktif: Anggota tidak aktif
```

### 4️⃣ PERUBAHAN STATUS (Admin)
```
Admin bisa ubah status anggota yang sudah diverifikasi:
  ├─ Aktif → Pending (karena kurang aktif, kurang laporan)
  ├─ Aktif → Nonaktif (karena tidak aktif sama sekali)
  ├─ Pending → Aktif (sudah aktif kembali)
  ├─ Pending → Nonaktif (benar-benar tidak aktif)
  ├─ Nonaktif → Aktif (diaktifkan kembali)
  └─ Nonaktif → Pending (sedang dalam review)

PENTING: 
- tanggal_bergabung TETAP TERISI
- Anggota TETAP di Data Anggota Koperasi
- TIDAK PINDAH ke Verifikasi Pendaftaran
- Notifikasi otomatis terkirim
```

---

## 📊 CONTOH DATA SAAT INI (7 Mei 2026)

### DATA ANGGOTA KOPERASI (10 anggota)
```
┌────────────────┬──────────────────────────┬─────────┬──────────────────┐
│ No. Anggota    │ Nama                     │ Status  │ Tanggal Bergabung│
├────────────────┼──────────────────────────┼─────────┼──────────────────┤
│ AGT20260014    │ EMISON LANNY             │ ✅ Aktif│ 2026-04-15       │
│ AGT20260015    │ EMISON LANNY LANNY       │ ✅ Aktif│ 2026-04-15       │
│ AGT20260017    │ Dera Kogoya              │ ✅ Aktif│ 2026-04-13       │
│ AGT2026040003  │ Mully                    │ ✅ Aktif│ 2026-04-20       │
├────────────────┼──────────────────────────┼─────────┼──────────────────┤
│ AGT2026040004  │ EMISON JIGIBALOM         │⏳Pending│ 2026-04-27       │
│ AGT2026050001  │ EMISON JIGIBALOM         │⏳Pending│ 2026-05-04       │
│ AGT2026050002  │ Emison Yigibalom         │⏳Pending│ 2026-05-06       │
│ AGT2026050003  │ Emison Yigibalom         │⏳Pending│ 2026-05-06       │
│ AG2026050001   │ Emison Yigibalom         │⏳Pending│ 2026-05-06       │
├────────────────┼──────────────────────────┼─────────┼──────────────────┤
│ AGT2026050004  │ Emison Yigibalom12312312 │⚠️Nonaktif│ 2026-05-07      │
└────────────────┴──────────────────────────┴─────────┴──────────────────┘

CATATAN:
- Semua 10 anggota punya tanggal_bergabung (TERISI)
- 5 anggota Pending BUKAN pendaftaran baru
- Mereka adalah anggota lama yang statusnya diubah admin
```

### VERIFIKASI PENDAFTARAN (0 anggota)
```
┌────────────────┬──────────────────────────┬─────────┬──────────────────┐
│ No. Anggota    │ Nama                     │ Status  │ Tanggal Bergabung│
├────────────────┼──────────────────────────┼─────────┼──────────────────┤
│ (Kosong)       │ (Tidak ada data)         │    -    │       NULL       │
└────────────────┴──────────────────────────┴─────────┴──────────────────┘

CATATAN:
- Tidak ada pendaftaran baru saat ini
- Jika ada pendaftaran baru, akan muncul di sini
- tanggal_bergabung = NULL
```

---

## 🎯 KESIMPULAN VISUAL

### ✅ YANG BENAR:
```
Pendaftaran Baru (tanggal_bergabung NULL)
    ↓
VERIFIKASI PENDAFTARAN
    ↓
Admin Terima (tanggal_bergabung TERISI)
    ↓
DATA ANGGOTA KOPERASI (Status: Aktif)
    ↓
Admin Ubah Status (tanggal_bergabung TETAP TERISI)
    ↓
DATA ANGGOTA KOPERASI (Status: Pending/Nonaktif)
    ↑
    └─ TETAP DI SINI, TIDAK PINDAH!
```

### ❌ YANG SALAH (TIDAK TERJADI):
```
DATA ANGGOTA KOPERASI (Status: Aktif)
    ↓
Admin Ubah Status ke Pending
    ↓
PINDAH KE VERIFIKASI PENDAFTARAN ← TIDAK TERJADI!
    ↓
tanggal_bergabung jadi NULL ← TIDAK TERJADI!
```

---

## 💡 TIPS MEMAHAMI SISTEM

### Kunci Pemahaman:
1. **tanggal_bergabung = NULL** → Belum pernah diverifikasi → Verifikasi Pendaftaran
2. **tanggal_bergabung = TERISI** → Sudah pernah diverifikasi → Data Anggota Koperasi
3. **Status Pending di Data Anggota** → Anggota lama yang sedang direview
4. **Status Pending di Verifikasi** → Pendaftaran baru yang belum diverifikasi

### Cara Cepat Cek:
- Lihat tanggal bergabung → Jika terisi = sudah diverifikasi
- Lihat lokasi → Data Anggota = sudah diverifikasi
- Lihat lokasi → Verifikasi = belum diverifikasi

---

**Dibuat**: 7 Mei 2026
**Status**: ✅ SISTEM BERFUNGSI DENGAN BENAR
**Pesan**: Diagram ini menjelaskan alur lengkap sistem yang sudah berfungsi dengan sempurna!

# TEST PERMISSION PIMPINAN - REKAP BANTUAN

## 🧪 CARA TEST PERMISSION

### TEST 1: Cek Permission di Halaman Bantuan

1. **Login sebagai Pimpinan**
2. **Buka halaman:** `/pimpinan/laporan/bantuan`
3. **Lihat alert di bagian atas:**

#### ✅ JIKA SUDAH DIBERI IZIN:
Akan muncul alert **BIRU** seperti ini:

```
🛡️ Status Izin Akses Anda

✓ Lihat Detail      (hijau, tebal)
✓ Tambah Bantuan    (hijau, tebal)
✓ Edit Data         (hijau, tebal)
✓ Hapus Data        (hijau, tebal)

ℹ️ Tombol yang tidak diizinkan tidak akan tampil di tabel.
```

#### ❌ JIKA BELUM DIBERI IZIN:
Akan muncul alert **KUNING** seperti ini:

```
⚠️ Akses Terbatas

Anda belum memiliki izin untuk mengelola Laporan Bantuan.
Silakan hubungi Administrator untuk mendapatkan akses berikut:
• Lihat Detail Bantuan
• Tambah Program Bantuan
• Edit Data Bantuan
• Hapus Data Bantuan
```

---

### TEST 2: Cek Tombol di Header

**Lokasi:** Di atas tabel, sebelah kanan "1 Program"

#### ✅ JIKA ADA IZIN CREATE:
```
[+ Tambah Program]  ← Tombol biru, bisa diklik
```

#### ❌ JIKA TIDAK ADA IZIN CREATE:
```
[🔒 Tidak Ada Izin Tambah]  ← Badge abu-abu
```

---

### TEST 3: Cek Tombol di Tabel (Kolom AKSI)

**Lokasi:** Kolom paling kanan di setiap baris data

#### ✅ JIKA SEMUA IZIN ADA:
```
[👁️] [✏️] [🗑️]
Detail Edit Hapus
```

#### ✅ JIKA HANYA IZIN VIEW:
```
[👁️]
Detail
```

#### ✅ JIKA HANYA IZIN VIEW + EDIT:
```
[👁️] [✏️]
Detail Edit
```

#### ❌ JIKA TIDAK ADA IZIN SAMA SEKALI:
```
[🔒 Tidak Ada Akses]  ← Badge abu-abu
```

---

### TEST 4: Cek Fungsi Tombol

#### Test Tombol "Tambah Program":
1. Klik tombol **"Tambah Program"**
2. **Hasil yang diharapkan:**
   - Redirect ke halaman form tambah
   - URL: `/pimpinan/laporan/bantuan/create`
   - Form dengan 9 field input muncul

#### Test Tombol "Detail":
1. Klik tombol **"Detail"** (icon mata)
2. **Hasil yang diharapkan:**
   - Modal popup muncul
   - Menampilkan detail program bantuan
   - Ada tombol "Tutup" di bawah

#### Test Tombol "Edit":
1. Klik tombol **"Edit"** (icon pensil)
2. **Hasil yang diharapkan:**
   - Redirect ke halaman form edit
   - URL: `/pimpinan/laporan/bantuan/{id}/edit`
   - Form sudah terisi dengan data existing

#### Test Tombol "Hapus":
1. Klik tombol **"Hapus"** (icon tempat sampah)
2. **Hasil yang diharapkan:**
   - SweetAlert konfirmasi muncul
   - Judul: "Hapus Program Bantuan?"
   - Text: "Data program bantuan akan dihapus permanen dari sistem!"
   - Ada tombol "Ya, Hapus!" dan "Batal"

---

## 📊 TABEL HASIL TEST

| Test | Kondisi | Hasil yang Diharapkan | Status |
|------|---------|----------------------|--------|
| 1. Alert Status | Sudah diberi izin | Alert BIRU dengan ✓ hijau | ⬜ |
| 2. Alert Status | Belum diberi izin | Alert KUNING dengan warning | ⬜ |
| 3. Tombol Tambah | Ada izin create | Tombol biru muncul | ⬜ |
| 4. Tombol Tambah | Tidak ada izin | Badge abu-abu muncul | ⬜ |
| 5. Tombol Detail | Ada izin view | Icon mata muncul | ⬜ |
| 6. Tombol Edit | Ada izin edit | Icon pensil muncul | ⬜ |
| 7. Tombol Hapus | Ada izin delete | Icon tempat sampah muncul | ⬜ |
| 8. Klik Tambah | Ada izin | Redirect ke form create | ⬜ |
| 9. Klik Detail | Ada izin | Modal detail muncul | ⬜ |
| 10. Klik Edit | Ada izin | Redirect ke form edit | ⬜ |
| 11. Klik Hapus | Ada izin | SweetAlert konfirmasi muncul | ⬜ |

**Cara mengisi:** Centang (✓) jika berhasil, Silang (✗) jika gagal

---

## 🔍 CEK LOG FILE

Setelah membuka halaman bantuan, cek file log:

**Lokasi:** `storage/logs/laravel.log`

**Cari baris dengan text:** `Bantuan Page`

**Contoh log yang BENAR:**
```
[2025-01-20 10:30:45] local.INFO: Bantuan Page - User: John Doe
[2025-01-20 10:30:45] local.INFO: Bantuan Page - Role: pimpinan
[2025-01-20 10:30:45] local.INFO: Bantuan Page - can_view: YES
[2025-01-20 10:30:45] local.INFO: Bantuan Page - can_create: YES
[2025-01-20 10:30:45] local.INFO: Bantuan Page - can_edit: YES
[2025-01-20 10:30:45] local.INFO: Bantuan Page - can_delete: YES
```

**Jika log menunjukkan NO:**
```
[2025-01-20 10:30:45] local.INFO: Bantuan Page - can_view: NO
[2025-01-20 10:30:45] local.INFO: Bantuan Page - can_create: NO
[2025-01-20 10:30:45] local.INFO: Bantuan Page - can_edit: NO
[2025-01-20 10:30:45] local.INFO: Bantuan Page - can_delete: NO
```

**Artinya:** Permission belum di-set di database. Perlu set ulang dari Admin.

---

## 🎯 SKENARIO TEST LENGKAP

### SKENARIO 1: Tidak Ada Izin Sama Sekali

**Setup:**
1. Admin TIDAK memberikan izin apapun
2. Table `role_permissions` tidak ada record untuk role=pimpinan, module=laporan

**Expected Result:**
- ❌ Alert kuning muncul
- ❌ Tombol "Tambah Program" tidak muncul (diganti badge abu-abu)
- ❌ Tombol Detail tidak muncul
- ❌ Tombol Edit tidak muncul
- ❌ Tombol Hapus tidak muncul
- ❌ Kolom Aksi menampilkan "Tidak Ada Akses"

---

### SKENARIO 2: Hanya Izin View

**Setup:**
1. Admin memberikan izin: ☑ View, ☐ Create, ☐ Edit, ☐ Delete
2. Database: can_view=1, can_create=0, can_edit=0, can_delete=0

**Expected Result:**
- ✅ Alert biru muncul
- ✅ Status View: ✓ (hijau)
- ❌ Status Create: ✗ (abu-abu)
- ❌ Status Edit: ✗ (abu-abu)
- ❌ Status Delete: ✗ (abu-abu)
- ❌ Tombol "Tambah Program" tidak muncul
- ✅ Tombol Detail muncul
- ❌ Tombol Edit tidak muncul
- ❌ Tombol Hapus tidak muncul

---

### SKENARIO 3: Izin View + Create

**Setup:**
1. Admin memberikan izin: ☑ View, ☑ Create, ☐ Edit, ☐ Delete
2. Database: can_view=1, can_create=1, can_edit=0, can_delete=0

**Expected Result:**
- ✅ Alert biru muncul
- ✅ Status View: ✓ (hijau)
- ✅ Status Create: ✓ (hijau)
- ❌ Status Edit: ✗ (abu-abu)
- ❌ Status Delete: ✗ (abu-abu)
- ✅ Tombol "Tambah Program" muncul
- ✅ Tombol Detail muncul
- ❌ Tombol Edit tidak muncul
- ❌ Tombol Hapus tidak muncul

---

### SKENARIO 4: Semua Izin

**Setup:**
1. Admin memberikan izin: ☑ View, ☑ Create, ☑ Edit, ☑ Delete
2. Database: can_view=1, can_create=1, can_edit=1, can_delete=1

**Expected Result:**
- ✅ Alert biru muncul
- ✅ Status View: ✓ (hijau)
- ✅ Status Create: ✓ (hijau)
- ✅ Status Edit: ✓ (hijau)
- ✅ Status Delete: ✓ (hijau)
- ✅ Tombol "Tambah Program" muncul
- ✅ Tombol Detail muncul
- ✅ Tombol Edit muncul
- ✅ Tombol Hapus muncul
- ✅ Semua tombol berfungsi dengan baik

---

## 📸 SCREENSHOT YANG DIBUTUHKAN

Jika masih ada masalah, ambil screenshot:

1. **Screenshot Alert Status** (bagian atas halaman)
2. **Screenshot Tombol Header** (tombol "Tambah Program")
3. **Screenshot Kolom Aksi** (tombol Detail, Edit, Hapus)
4. **Screenshot Log File** (dari `storage/logs/laravel.log`)
5. **Screenshot Database** (table `role_permissions`)

---

## ✅ CHECKLIST SEBELUM LAPOR MASALAH

- [ ] Sudah login sebagai Pimpinan (bukan Admin)
- [ ] Sudah buka halaman `/pimpinan/laporan/bantuan`
- [ ] Sudah refresh halaman (Ctrl+F5)
- [ ] Sudah cek alert status di bagian atas
- [ ] Sudah cek tombol di header
- [ ] Sudah cek tombol di kolom aksi
- [ ] Sudah cek log file
- [ ] Sudah ambil screenshot
- [ ] Sudah jalankan `php artisan optimize:clear`

---

**Dokumentasi Test:** {{ date('d F Y, H:i') }}
**Status:** ✅ READY FOR TESTING

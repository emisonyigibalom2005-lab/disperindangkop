# 🛡️ Implementasi Sistem Izin Akses untuk Petugas

## ✅ Status Implementasi

### Controllers yang Sudah Diimplementasikan:

1. ✅ **AnggotaKoperasiController** - LENGKAP
   - index() - can_view('anggota')
   - show() - can_view('anggota')
   - create() - can_create('anggota')
   - store() - can_create('anggota')
   - edit() - can_edit('anggota')
   - update() - can_edit('anggota')
   - destroy() - can_delete('anggota')

2. ✅ **KoperasiController** - LENGKAP
   - index() - can_view('koperasi')
   - show() - can_view('koperasi')
   - create() - can_create('koperasi')
   - store() - can_create('koperasi')
   - edit() - can_edit('koperasi')
   - update() - can_edit('koperasi')
   - destroy() - can_delete('koperasi')

3. ✅ **BantuanController** - SUDAH ADA
   - Semua method sudah memiliki permission checks

4. ✅ **BeritaController** - SUDAH ADA
   - Semua method sudah memiliki permission checks

5. ✅ **PengumumanController** - SUDAH ADA
   - Semua method sudah memiliki permission checks

6. ✅ **KontakController** - SUDAH ADA
   - Sudah memiliki permission checks

### Views yang Sudah Diimplementasikan:

1. ✅ **anggota-koperasi/index.blade.php**
   - Tombol "Tambah Anggota" - @if(can_create('anggota'))
   - Tombol Export (Excel, PDF, Word, Print) - @if(can_export('anggota'))
   - Tombol Detail - @if(can_view('anggota'))
   - Tombol Edit - @if(can_edit('anggota'))
   - Tombol Hapus - @if(can_delete('anggota'))

---

## 📋 Cara Kerja Sistem

### 1. Admin Mengatur Izin

1. Login sebagai **Administrator**
2. Buka menu **Sistem** → **Izin Akses**
3. Pilih role **"Petugas"**
4. Klik **"Kelola Izin"**
5. Centang izin yang ingin diberikan untuk setiap modul
6. Klik **"Simpan Perubahan"**

### 2. Petugas Mengakses Fitur

**Jika Petugas MEMILIKI izin:**
- ✅ Dapat mengakses fitur normal
- ✅ Tombol aksi muncul (Tambah, Edit, Hapus, Export)
- ✅ Dapat melakukan operasi sesuai izin

**Jika Petugas TIDAK MEMILIKI izin:**
- ❌ Redirect ke dashboard dengan pesan error
- ❌ Tombol aksi disembunyikan
- ❌ Tidak dapat mengakses URL langsung

---

## 🎯 Contoh Skenario

### Skenario 1: Petugas Hanya Bisa Lihat Data Anggota

**Admin Setting:**
- ✅ View (Lihat) - AKTIF
- ❌ Create (Tambah) - NONAKTIF
- ❌ Edit (Ubah) - NONAKTIF
- ❌ Delete (Hapus) - NONAKTIF
- ❌ Export (Ekspor) - NONAKTIF

**Hasil untuk Petugas:**
- ✅ Dapat melihat daftar anggota
- ✅ Dapat melihat detail anggota
- ❌ Tombol "Tambah Anggota" TIDAK MUNCUL
- ❌ Tombol "Edit" TIDAK MUNCUL
- ❌ Tombol "Hapus" TIDAK MUNCUL
- ❌ Tombol "Export" TIDAK MUNCUL
- ❌ Jika akses URL create/edit/delete langsung → REDIRECT dengan error

### Skenario 2: Petugas Bisa Tambah dan Edit, Tapi Tidak Bisa Hapus

**Admin Setting:**
- ✅ View (Lihat) - AKTIF
- ✅ Create (Tambah) - AKTIF
- ✅ Edit (Ubah) - AKTIF
- ❌ Delete (Hapus) - NONAKTIF
- ✅ Export (Ekspor) - AKTIF

**Hasil untuk Petugas:**
- ✅ Dapat melihat daftar anggota
- ✅ Tombol "Tambah Anggota" MUNCUL
- ✅ Tombol "Edit" MUNCUL
- ❌ Tombol "Hapus" TIDAK MUNCUL
- ✅ Tombol "Export" MUNCUL
- ❌ Jika akses URL delete langsung → REDIRECT dengan error

### Skenario 3: Petugas Tidak Punya Akses Sama Sekali

**Admin Setting:**
- ❌ Semua izin NONAKTIF

**Hasil untuk Petugas:**
- ❌ Akses menu "Data Anggota Koperasi" → REDIRECT ke dashboard
- ❌ Pesan error: "Anda tidak memiliki izin untuk melihat data anggota. Hubungi Administrator untuk mendapatkan akses."

---

## 🔧 Implementasi Teknis

### Di Controller:

```php
public function index()
{
    // Check permission
    if (!can_view('anggota')) {
        return redirect()->route('petugas.dashboard')
            ->with('error', 'Anda tidak memiliki izin untuk melihat data anggota. Hubungi Administrator untuk mendapatkan akses.');
    }
    
    // Kode normal...
}

public function create()
{
    // Check permission
    if (!can_create('anggota')) {
        return redirect()->route('petugas.anggota-koperasi.index')
            ->with('error', 'Anda tidak memiliki izin untuk menambah anggota. Hubungi Administrator untuk mendapatkan akses.');
    }
    
    // Kode normal...
}

public function edit($id)
{
    // Check permission
    if (!can_edit('anggota')) {
        return redirect()->route('petugas.anggota-koperasi.index')
            ->with('error', 'Anda tidak memiliki izin untuk mengubah data anggota. Hubungi Administrator untuk mendapatkan akses.');
    }
    
    // Kode normal...
}

public function destroy($id)
{
    // Check permission
    if (!can_delete('anggota')) {
        return redirect()->route('petugas.anggota-koperasi.index')
            ->with('error', 'Anda tidak memiliki izin untuk menghapus anggota. Hubungi Administrator untuk mendapatkan akses.');
    }
    
    // Kode normal...
}
```

### Di View (Blade):

```blade
{{-- Tombol Tambah --}}
@if(can_create('anggota'))
<a href="{{ route('petugas.anggota-koperasi.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Tambah Anggota
</a>
@endif

{{-- Tombol Export --}}
@if(can_export('anggota'))
<button type="button" class="btn btn-success" onclick="exportExcel()">
    <i class="fas fa-file-excel"></i> Excel
</button>
@endif

{{-- Tombol Edit --}}
@if(can_edit('anggota'))
<a href="{{ route('petugas.anggota-koperasi.edit', $anggota->id) }}" class="btn btn-warning">
    <i class="fas fa-edit"></i>
</a>
@endif

{{-- Tombol Hapus --}}
@if(can_delete('anggota'))
<form action="{{ route('petugas.anggota-koperasi.destroy', $anggota->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
        <i class="fas fa-trash"></i>
    </button>
</form>
@endif
```

---

## 📊 Daftar Module untuk Petugas

| No | Module | Nama Modul | Fitur |
|----|--------|------------|-------|
| 1 | `anggota` | Manajemen Anggota | View, Create, Edit, Delete, Export |
| 2 | `koperasi` | Manajemen Koperasi | View, Create, Edit, Delete, Export |
| 3 | `bantuan` | Distribusi Bantuan | View, Create, Edit, Delete, Export |
| 4 | `berita` | Berita & Artikel | View, Create, Edit, Delete |
| 5 | `pengumuman` | Pengumuman | View, Create, Edit, Delete |
| 6 | `galeri` | Galeri Kegiatan | View, Create, Edit, Delete |
| 7 | `jadwal` | Jadwal Kegiatan | View, Create, Edit, Delete, Export |
| 8 | `pelatihan` | Pelatihan | View, Create, Edit, Delete |
| 9 | `laporan` | Laporan | View, Export |
| 10 | `user` | Manajemen User | View, Create, Edit, Delete |
| 11 | `chat` | Chat & Pesan | View, Create |
| 12 | `kontak` | Kontak Masuk | View, Edit, Delete |
| 13 | `struktur` | Struktur Organisasi | View, Create, Edit, Delete |
| 14 | `halaman_statis` | Halaman Statis | View, Create, Edit, Delete |

---

## 🧪 Testing

### Test Case 1: Akses Tanpa Izin View

**Steps:**
1. Login sebagai Admin
2. Buka Izin Akses → Petugas
3. Hapus centang "View" untuk modul "Anggota"
4. Simpan
5. Login sebagai Petugas
6. Coba akses menu "Data Anggota Koperasi"

**Expected Result:**
- ❌ Redirect ke dashboard
- ❌ Muncul pesan: "Anda tidak memiliki izin untuk melihat data anggota. Hubungi Administrator untuk mendapatkan akses."

### Test Case 2: Akses Tanpa Izin Create

**Steps:**
1. Login sebagai Admin
2. Buka Izin Akses → Petugas
3. Centang "View" tapi hapus "Create" untuk modul "Anggota"
4. Simpan
5. Login sebagai Petugas
6. Buka halaman Data Anggota Koperasi

**Expected Result:**
- ✅ Dapat melihat daftar anggota
- ❌ Tombol "Tambah Anggota" TIDAK MUNCUL
- ❌ Jika akses URL `/petugas/anggota-koperasi/create` langsung → REDIRECT dengan error

### Test Case 3: Akses Tanpa Izin Edit

**Steps:**
1. Login sebagai Admin
2. Buka Izin Akses → Petugas
3. Centang "View" tapi hapus "Edit" untuk modul "Anggota"
4. Simpan
5. Login sebagai Petugas
6. Buka halaman Data Anggota Koperasi

**Expected Result:**
- ✅ Dapat melihat daftar anggota
- ❌ Tombol "Edit" TIDAK MUNCUL di setiap row
- ❌ Jika akses URL `/petugas/anggota-koperasi/{id}/edit` langsung → REDIRECT dengan error

### Test Case 4: Akses Tanpa Izin Delete

**Steps:**
1. Login sebagai Admin
2. Buka Izin Akses → Petugas
3. Centang "View" tapi hapus "Delete" untuk modul "Anggota"
4. Simpan
5. Login sebagai Petugas
6. Buka halaman Data Anggota Koperasi

**Expected Result:**
- ✅ Dapat melihat daftar anggota
- ❌ Tombol "Hapus" TIDAK MUNCUL di setiap row
- ❌ Jika submit form delete langsung → REDIRECT dengan error

### Test Case 5: Akses Tanpa Izin Export

**Steps:**
1. Login sebagai Admin
2. Buka Izin Akses → Petugas
3. Centang "View" tapi hapus "Export" untuk modul "Anggota"
4. Simpan
5. Login sebagai Petugas
6. Buka halaman Data Anggota Koperasi

**Expected Result:**
- ✅ Dapat melihat daftar anggota
- ❌ Tombol Export (Excel, PDF, Word, Print) TIDAK MUNCUL

---

## 🎓 Panduan untuk Admin

### Memberikan Izin Penuh ke Petugas:

1. Login sebagai Admin
2. Buka **Sistem** → **Izin Akses**
3. Pilih role **"Petugas"**
4. Klik **"Kelola Izin"**
5. Klik tombol **"Pilih Semua Izin"**
6. Klik **"Simpan Perubahan"**

### Memberikan Izin Terbatas (Hanya View):

1. Login sebagai Admin
2. Buka **Sistem** → **Izin Akses**
3. Pilih role **"Petugas"**
4. Klik **"Kelola Izin"**
5. Untuk setiap modul, centang HANYA **"Lihat"**
6. Klik **"Simpan Perubahan"**

### Mencabut Semua Izin:

1. Login sebagai Admin
2. Buka **Sistem** → **Izin Akses**
3. Pilih role **"Petugas"**
4. Klik **"Kelola Izin"**
5. Klik tombol **"Hapus Semua Pilihan"**
6. Klik **"Simpan Perubahan"**

### Mengembalikan ke Default:

1. Login sebagai Admin
2. Buka **Sistem** → **Izin Akses**
3. Pilih role **"Petugas"**
4. Klik tombol **"Set Default"**
5. Konfirmasi

---

## 🔒 Keamanan

### Proteksi Berlapis:

1. **Controller Level** - Cek izin di awal setiap method
2. **View Level** - Sembunyikan tombol jika tidak ada izin
3. **Route Level** - Bisa ditambahkan middleware (opsional)

### Catatan Penting:

- ✅ Admin SELALU memiliki full access (tidak perlu cek izin)
- ✅ Petugas HARUS mendapat izin dari Admin
- ✅ Izin dicek di controller (tidak bisa dibypass)
- ✅ Tombol disembunyikan di view (UX lebih baik)
- ✅ Pesan error jelas dan informatif
- ✅ Redirect ke halaman yang sesuai

---

## 📞 Troubleshooting

### Problem: Petugas tidak bisa akses fitur apapun

**Solution:**
1. Login sebagai Admin
2. Buka Izin Akses → Petugas
3. Pastikan izin sudah diberikan
4. Klik "Simpan Perubahan"
5. Petugas logout dan login kembali

### Problem: Tombol masih muncul padahal izin sudah dicabut

**Solution:**
1. Clear browser cache
2. Logout dan login kembali
3. Periksa kode view, pastikan menggunakan `@if(can_xxx('module'))`

### Problem: Error "Call to undefined function can_view()"

**Solution:**
1. Pastikan file `app/Helpers/PermissionHelper.php` ada
2. Pastikan helper sudah di-load di `composer.json`
3. Run `composer dump-autoload`

---

**Dibuat oleh:** Tim Development Disperindagkop Tolikara  
**Terakhir Diperbarui:** 19 April 2026  
**Versi:** 1.0.0

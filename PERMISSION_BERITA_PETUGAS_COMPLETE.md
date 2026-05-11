# ✅ IMPLEMENTASI PERMISSION SYSTEM - BERITA PETUGAS

## STATUS: SELESAI ✅

---

## PERUBAHAN YANG DILAKUKAN

### 1. **Update View: Berita Table (Petugas)**
**File**: `resources/views/petugas/berita/index-table.blade.php`

#### ❌ SEBELUM (Baris 164-195):
```blade
<td style="padding:20px;text-align:center">
    <div class="btn-group" role="group">
        <a href="{{ route('petugas.berita.show', $item->id) }}" 
           class="btn btn-sm btn-outline-success">
            <i class="fas fa-eye"></i>
        </a>
        
        @if($item->createdBy && $item->createdBy->role == 'petugas')
            <!-- Tombol Edit & Hapus hanya untuk berita dari Petugas -->
            <a href="{{ route('petugas.berita.edit', $item->id) }}" 
               class="btn btn-sm btn-outline-info">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('petugas.berita.destroy', $item->id) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        @else
            <!-- Icon Lock untuk berita dari Admin -->
            <span class="btn btn-sm btn-outline-secondary disabled">
                <i class="fas fa-lock mr-1"></i>{{ ucfirst($item->createdBy->role ?? 'Admin') }}
            </span>
        @endif
    </div>
</td>
```

**MASALAH**:
- ❌ Petugas tidak bisa edit/hapus berita dari Admin
- ❌ Ada icon lock yang membingungkan
- ❌ Tidak menggunakan permission system
- ❌ Hardcoded role check

---

#### ✅ SESUDAH (Baris 166-199):
```blade
<td style="padding:20px;text-align:center">
    <div class="btn-group" role="group">
        {{-- Tombol Detail - Tampil jika ada izin view --}}
        @canView('berita')
            <a href="{{ route('petugas.berita.show', $item->id) }}" 
               class="btn btn-sm btn-outline-success" 
               style="border-radius:6px;padding:8px 12px;margin-right:4px"
               title="Lihat Detail">
                <i class="fas fa-eye"></i>
            </a>
        @endcanView
        
        {{-- Tombol Edit - Tampil jika ada izin edit --}}
        @canEdit('berita')
            <a href="{{ route('petugas.berita.edit', $item->id) }}" 
               class="btn btn-sm btn-outline-info" 
               style="border-radius:6px;padding:8px 12px;margin-right:4px"
               title="Edit">
                <i class="fas fa-edit"></i>
            </a>
        @endcanEdit
        
        {{-- Tombol Hapus - Tampil jika ada izin delete --}}
        @canDelete('berita')
            <button type="button"
                    class="btn btn-sm btn-outline-danger" 
                    style="border-radius:6px;padding:8px 12px"
                    onclick="confirmDelete({{ $item->id }})"
                    title="Hapus">
                <i class="fas fa-trash"></i>
            </button>
        @endcanDelete
    </div>
</td>
```

**PERBAIKAN**:
- ✅ Menggunakan Blade directives: `@canView`, `@canEdit`, `@canDelete`
- ✅ Tombol hanya tampil jika ada izin (tidak ada disabled/lock)
- ✅ Petugas bisa edit/hapus SEMUA berita jika Admin sudah izinkan
- ✅ Prinsip: **"Permission Over Ownership"**
- ✅ Styling lebih rapi dengan margin dan border-radius

---

### 2. **Tambah SweetAlert2 untuk Konfirmasi Delete**
**File**: `resources/views/petugas/berita/index-table.blade.php`

#### Ditambahkan di bagian bawah (setelah `</style>`):
```blade
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Berita?',
        text: 'Berita yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash mr-1"></i> Ya, Hapus!',
        cancelButtonText: '<i class="fas fa-times mr-1"></i> Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Menghapus...',
                html: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Submit delete form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/petugas/berita/${id}`;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

// Success & Error messages
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{ session('error') }}',
        confirmButtonColor: '#10b981'
    });
@endif
</script>
@endpush
```

**FITUR**:
- ✅ Konfirmasi hapus dengan popup modern
- ✅ Loading state saat menghapus
- ✅ Success/error notification otomatis
- ✅ Styling konsisten dengan tema hijau (#10b981)

---

## CARA KERJA PERMISSION SYSTEM

### 1. **Admin Mengatur Izin**
- Admin masuk ke menu **"Izin Akses"** (sidebar → PENGATURAN)
- Pilih role **"Petugas"**
- Centang izin untuk modul **"Berita"**:
  - ✅ View (Lihat)
  - ✅ Create (Buat)
  - ✅ Edit (Ubah)
  - ✅ Delete (Hapus)
- Klik **"Simpan Perubahan"**

### 2. **Petugas Mengakses Berita**
- Login sebagai **Petugas**
- Masuk ke menu **"Berita"**
- Jika Admin sudah izinkan:
  - ✅ Tombol **"Buat Berita"** tampil
  - ✅ Tombol **"Detail"** tampil untuk semua berita
  - ✅ Tombol **"Edit"** tampil untuk SEMUA berita (termasuk dari Admin)
  - ✅ Tombol **"Hapus"** tampil untuk SEMUA berita (termasuk dari Admin)
- Jika Admin belum izinkan:
  - ❌ Tombol tidak tampil sama sekali (bukan disabled)

### 3. **Prinsip: "Permission Over Ownership"**
- **TIDAK PEDULI** siapa yang buat berita (Admin/Petugas)
- **HANYA CEK** apakah user punya izin atau tidak
- Jika punya izin → bisa edit/hapus SEMUA data
- Jika tidak punya izin → tombol tidak tampil

---

## KONSISTENSI DENGAN PENGUMUMAN

### Pengumuman (Sudah Selesai) ✅
- File: `resources/views/petugas/pengumuman/index-table.blade.php`
- Menggunakan: `@canView`, `@canEdit`, `@canDelete`
- SweetAlert2: ✅ Ada
- Permission Over Ownership: ✅ Diterapkan

### Berita (Baru Selesai) ✅
- File: `resources/views/petugas/berita/index-table.blade.php`
- Menggunakan: `@canView`, `@canEdit`, `@canDelete`
- SweetAlert2: ✅ Ada
- Permission Over Ownership: ✅ Diterapkan

**KEDUA MODUL SEKARANG KONSISTEN!** 🎉

---

## TESTING CHECKLIST

### ✅ Test 1: Admin Belum Izinkan
1. Login sebagai Admin
2. Masuk ke **Izin Akses** → Edit Petugas
3. **Uncheck** semua izin Berita
4. Logout, login sebagai Petugas
5. Masuk ke menu Berita
6. **EXPECTED**: Tidak ada tombol Buat/Edit/Hapus

### ✅ Test 2: Admin Izinkan View Saja
1. Login sebagai Admin
2. Masuk ke **Izin Akses** → Edit Petugas
3. **Check** hanya "View" untuk Berita
4. Logout, login sebagai Petugas
5. Masuk ke menu Berita
6. **EXPECTED**: Hanya tombol "Detail" yang tampil

### ✅ Test 3: Admin Izinkan Semua
1. Login sebagai Admin
2. Masuk ke **Izin Akses** → Edit Petugas
3. **Check** semua izin Berita (View, Create, Edit, Delete)
4. Logout, login sebagai Petugas
5. Masuk ke menu Berita
6. **EXPECTED**: 
   - Tombol "Buat Berita" tampil
   - Tombol "Detail", "Edit", "Hapus" tampil untuk SEMUA berita
   - Bisa edit/hapus berita dari Admin

### ✅ Test 4: Konfirmasi Delete
1. Login sebagai Petugas (dengan izin Delete)
2. Klik tombol "Hapus" pada berita
3. **EXPECTED**: 
   - Popup SweetAlert2 muncul
   - Klik "Ya, Hapus!" → Loading → Redirect dengan success message
   - Klik "Batal" → Popup tutup, tidak ada perubahan

---

## FILES YANG DIUBAH

1. ✅ `resources/views/petugas/berita/index-table.blade.php`
   - Baris 166-199: Ganti role check dengan permission check
   - Baris 220-290: Tambah SweetAlert2 scripts

---

## SUMMARY

### ✅ SELESAI:
1. ✅ Hapus pengecekan role pembuat berita
2. ✅ Implementasi Blade directives (`@canView`, `@canEdit`, `@canDelete`)
3. ✅ Tombol hanya tampil jika ada izin (tidak ada disabled/lock)
4. ✅ Petugas bisa edit/hapus SEMUA berita jika Admin izinkan
5. ✅ Tambah SweetAlert2 untuk konfirmasi delete
6. ✅ Konsisten dengan implementasi Pengumuman

### 🎯 PRINSIP YANG DITERAPKAN:
- **"Permission Over Ownership"**: Izin lebih penting dari kepemilikan
- **"Show or Hide"**: Tombol tampil atau tidak tampil (bukan disabled)
- **"Centralized Control"**: Admin mengontrol semua izin dari satu tempat

---

## NEXT STEPS (OPSIONAL)

Jika ingin menerapkan permission system ke modul lain:
1. **Anggota** (Admin & Petugas)
2. **Koperasi** (Admin & Petugas)
3. **Jadwal** (Admin & Petugas)
4. **Bantuan** (Admin & Petugas)
5. **Galeri** (Admin)
6. **Laporan** (Admin & Pimpinan)

**Cara yang sama**:
- Ganti role check dengan `@canView`, `@canEdit`, `@canDelete`
- Tambah SweetAlert2 untuk konfirmasi delete
- Pastikan controller sudah ada permission check

---

**DOKUMENTASI DIBUAT**: 17 April 2026
**STATUS**: ✅ COMPLETE

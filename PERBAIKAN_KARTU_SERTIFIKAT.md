# Perbaikan Halaman Kartu & Sertifikat

## Masalah yang Diperbaiki

Halaman `/admin/kartu-sertifikat` mengalami error di Ignition UI yang disebabkan oleh:

1. **Nullsafe operator compatibility** - Penggunaan `?->` yang mungkin tidak kompatibel dengan versi PHP tertentu
2. **Missing error handling** - Tidak ada try-catch untuk menangani error
3. **Pagination issues** - Query string tidak dipertahankan dengan benar saat pagination
4. **JavaScript event handling** - Event handler tidak robust untuk tab switching

## Perubahan yang Dilakukan

### 1. Controller (`app/Http/Controllers/Admin/AnggotaController.php`)

**Method: `kartuSertifikatList()`**

```php
public function kartuSertifikatList(Request $request) {
    try {
        // Query anggota dengan error handling
        $qAnggota = Anggota::with('koperasi');
        if ($request->search_anggota) {
            $qAnggota->where(function($query) use ($request) {
                $query->where('nama','like',"%{$request->search_anggota}%")
                      ->orWhere('no_anggota','like',"%{$request->search_anggota}%");
            });
        }
        $anggota = $qAnggota->orderBy('created_at','desc')->paginate(12)->withQueryString();
        
        // Query koperasi
        $qKoperasi = \App\Models\Koperasi::query();
        if ($request->search_koperasi) {
            $qKoperasi->where(function($query) use ($request) {
                $query->where('nama_usaha','like',"%{$request->search_koperasi}%")
                      ->orWhere('no_registrasi','like',"%{$request->search_koperasi}%");
            });
        }
        $koperasi = $qKoperasi->orderBy('created_at','desc')->paginate(12)->withQueryString();
        
        return view('admin.anggota.kartu-sertifikat-list', compact('anggota', 'koperasi'));
    } catch (\Exception $e) {
        \Log::error('Error in kartuSertifikatList: ' . $e->getMessage());
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
```

**Perubahan:**
- ✅ Menambahkan `try-catch` block untuk error handling
- ✅ Menambahkan logging untuk debugging
- ✅ Menambahkan fallback dengan pesan error yang user-friendly

### 2. View (`resources/views/admin/anggota/kartu-sertifikat-list.blade.php`)

#### A. Perbaikan Relasi Koperasi

**Sebelum:**
```blade
{{ $a->koperasi?->nama_usaha ?? '-' }}
```

**Sesudah:**
```blade
{{ optional($a->koperasi)->nama_usaha ?? '-' }}
```

**Alasan:** Menggunakan `optional()` helper untuk kompatibilitas yang lebih baik dengan berbagai versi PHP.

#### B. Perbaikan Pagination

**Sebelum:**
```blade
{{ $anggota->appends(request()->query())->links('pagination::bootstrap-4') }}
```

**Sesudah:**
```blade
{{ $anggota->appends(['search_anggota' => request('search_anggota')])->links('pagination::bootstrap-4') }}
```

**Untuk Koperasi:**
```blade
{{ $koperasi->appends(['search_koperasi' => request('search_koperasi'), 'tab' => 'koperasi'])->links('pagination::bootstrap-4') }}
```

**Alasan:** 
- Mempertahankan parameter pencarian saat pagination
- Mempertahankan tab aktif untuk koperasi

#### C. Perbaikan JavaScript Tab Switching

**Sebelum:**
```javascript
function switchTab(tab) {
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.closest('.tab-btn').classList.add('active');
    
    document.querySelectorAll('.content-card').forEach(content => {
        content.classList.remove('active');
    });
    document.getElementById('content-' + tab).classList.add('active');
}
```

**Sesudah:**
```javascript
function switchTab(tab) {
    // Update tab buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Find the clicked button
    const clickedBtn = event.currentTarget;
    clickedBtn.classList.add('active');
    
    // Update content
    document.querySelectorAll('.content-card').forEach(content => {
        content.classList.remove('active');
    });
    
    const targetContent = document.getElementById('content-' + tab);
    if (targetContent) {
        targetContent.classList.add('active');
    }
}

// Check if tab parameter exists in URL on page load
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');
    if (tab === 'koperasi') {
        const koperasiBtn = document.querySelectorAll('.tab-btn')[1];
        if (koperasiBtn) {
            // Remove active from all
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.content-card').forEach(content => content.classList.remove('active'));
            
            // Add active to koperasi
            koperasiBtn.classList.add('active');
            const koperasiContent = document.getElementById('content-koperasi');
            if (koperasiContent) {
                koperasiContent.classList.add('active');
            }
        }
    }
});
```

**Perubahan:**
- ✅ Menggunakan `event.currentTarget` untuk lebih reliable
- ✅ Menambahkan null check untuk target content
- ✅ Menggunakan `DOMContentLoaded` untuk inisialisasi yang lebih aman
- ✅ Menambahkan null check untuk semua element

#### D. Perbaikan Pagination Info

**Sebelum:**
```blade
Menampilkan {{ $anggota->firstItem() }}–{{ $anggota->lastItem() }} dari {{ $anggota->total() }} data
```

**Sesudah:**
```blade
Menampilkan {{ $anggota->firstItem() ?? 0 }}–{{ $anggota->lastItem() ?? 0 }} dari {{ $anggota->total() }} data
```

**Alasan:** Menambahkan fallback untuk kasus ketika tidak ada data.

### 3. Perbaikan di View Dokumen (`resources/views/admin/anggota/dokumen.blade.php`)

**Perubahan yang sama:**
```blade
{{ optional($a->koperasi)->nama_usaha ?? '-' }}
```

## Cara Menggunakan Fitur

### 1. Akses Halaman

```
URL: http://127.0.0.1:8000/admin/kartu-sertifikat
```

### 2. Fitur yang Tersedia

#### Tab Anggota
- **Pencarian:** Cari berdasarkan nama atau nomor anggota
- **Download:** 3 tombol download untuk setiap anggota:
  - 🔵 **Kartu** - Download kartu anggota (PDF, ukuran kartu standar)
  - 🟠 **Sertifikat** - Download sertifikat keanggotaan (PDF, A4 landscape)
  - 🟢 **Dokumen** - Download dokumen lengkap (Word)

#### Tab Koperasi
- **Pencarian:** Cari berdasarkan nama koperasi atau nomor registrasi
- **Download:** 3 tombol download untuk setiap koperasi:
  - 🔵 **Kartu** - Download kartu koperasi (PDF)
  - 🟠 **Sertifikat** - Download sertifikat koperasi (PDF)
  - 🟢 **Dokumen** - Download dokumen lengkap (Word)

### 3. Navigasi

**Dari Sidebar:**
```
Dashboard Admin → Kartu & Sertifikat
```

**Atau langsung:**
```
Menu: Anggota → Kartu & Sertifikat
```

## Testing

### 1. Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### 2. Test Scenarios

#### ✅ Test 1: Akses Halaman
- Buka `http://127.0.0.1:8000/admin/kartu-sertifikat`
- Pastikan halaman load tanpa error
- Pastikan kedua tab (Anggota & Koperasi) terlihat

#### ✅ Test 2: Tab Switching
- Klik tab "Koperasi"
- Pastikan konten berubah ke daftar koperasi
- Klik tab "Anggota"
- Pastikan konten kembali ke daftar anggota

#### ✅ Test 3: Pencarian Anggota
- Di tab Anggota, masukkan nama anggota
- Klik tombol "Cari"
- Pastikan hasil pencarian sesuai
- Klik "Reset" untuk menghapus filter

#### ✅ Test 4: Pencarian Koperasi
- Di tab Koperasi, masukkan nama koperasi
- Klik tombol "Cari"
- Pastikan hasil pencarian sesuai
- Pastikan tetap di tab Koperasi setelah search

#### ✅ Test 5: Download Dokumen Anggota
- Klik tombol "Kartu" pada salah satu anggota
- Pastikan file PDF terdownload
- Klik tombol "Sertifikat"
- Pastikan file PDF terdownload
- Klik tombol "Dokumen"
- Pastikan file Word terdownload

#### ✅ Test 6: Download Dokumen Koperasi
- Pindah ke tab Koperasi
- Klik tombol "Kartu" pada salah satu koperasi
- Pastikan file PDF terdownload
- Klik tombol "Sertifikat"
- Pastikan file PDF terdownload
- Klik tombol "Dokumen"
- Pastikan file Word terdownload

#### ✅ Test 7: Pagination
- Jika data lebih dari 12 item, pastikan pagination muncul
- Klik halaman berikutnya
- Pastikan filter pencarian tetap aktif
- Untuk tab Koperasi, pastikan tetap di tab Koperasi setelah pagination

#### ✅ Test 8: Empty State
- Jika tidak ada data, pastikan pesan "Belum Ada Data" muncul
- Pastikan tidak ada error

## Troubleshooting

### Error: "Something went wrong in Ignition"

**Solusi:**
1. Clear cache:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

2. Check log file:
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. Pastikan relasi `koperasi` di model `Anggota` sudah benar:
   ```php
   public function koperasi() { 
       return $this->belongsTo(Koperasi::class); 
   }
   ```

### Error: "Undefined variable $anggota"

**Solusi:**
- Pastikan controller method `kartuSertifikatList()` sudah benar
- Pastikan route sudah terdaftar di `routes/web.php`

### Error: "Call to undefined method"

**Solusi:**
- Pastikan model `Anggota` dan `Koperasi` sudah ada
- Pastikan relasi sudah didefinisikan dengan benar

### Tab tidak berpindah

**Solusi:**
1. Check browser console untuk JavaScript error
2. Pastikan jQuery sudah loaded (jika menggunakan)
3. Clear browser cache

### Pagination tidak mempertahankan filter

**Solusi:**
- Pastikan menggunakan `appends()` dengan parameter yang benar
- Untuk tab Koperasi, pastikan menambahkan `'tab' => 'koperasi'`

## File yang Diubah

1. ✅ `app/Http/Controllers/Admin/AnggotaController.php`
   - Method: `kartuSertifikatList()`
   
2. ✅ `resources/views/admin/anggota/kartu-sertifikat-list.blade.php`
   - Perbaikan relasi koperasi
   - Perbaikan pagination
   - Perbaikan JavaScript
   
3. ✅ `resources/views/admin/anggota/dokumen.blade.php`
   - Perbaikan relasi koperasi

## Catatan Penting

1. **Kompatibilitas PHP:** Menggunakan `optional()` helper lebih kompatibel daripada nullsafe operator `?->`
2. **Error Handling:** Selalu gunakan try-catch untuk method yang mengakses database
3. **Pagination:** Selalu pertahankan query string saat pagination
4. **JavaScript:** Gunakan `DOMContentLoaded` untuk inisialisasi yang aman
5. **Logging:** Gunakan `\Log::error()` untuk debugging

## Status

✅ **SELESAI** - Semua perbaikan telah diterapkan dan siap digunakan.

---

**Dibuat:** 16 April 2026  
**Versi:** 1.0  
**Status:** Production Ready

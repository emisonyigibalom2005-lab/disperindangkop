# Cara Generate Data Koperasi untuk Testing

## 📊 Mengisi Data Koperasi Otomatis

Untuk melihat grafik dan statistik koperasi dengan data yang lengkap, Anda bisa menggunakan seeder yang sudah dibuat.

### Langkah-langkah:

1. **Jalankan Seeder**
   ```bash
   php artisan db:seed --class=KoperasiSeeder
   ```

2. **Refresh Halaman Statistik**
   Buka browser dan akses: `http://127.0.0.1:8000/statistik-koperasi`

### ✨ Apa yang Akan Dibuat?

Seeder akan membuat **50 data koperasi contoh** dengan:

- ✅ 10 Distrik berbeda (Karubaga, Tiom, Kembu, dll)
- ✅ 10 Jenis usaha berbeda (Simpan Pinjam, Konsumen, Produsen, dll)
- ✅ 3 Kategori (Mikro, Kecil, Menengah)
- ✅ Status verifikasi (Pending, Diverifikasi)
- ✅ Status usaha (Aktif, Tidak Aktif)
- ✅ Data tersebar dalam 12 bulan terakhir
- ✅ Modal dan omset sesuai kategori
- ✅ Jumlah karyawan 3-50 orang

### 📈 Grafik yang Akan Muncul:

1. **Trend Pendaftaran** - Line chart 12 bulan terakhir
2. **Status Verifikasi** - Doughnut chart
3. **Kategori Koperasi** - Pie chart
4. **Top 10 Distrik** - Bar chart
5. **Top 10 Jenis Usaha** - Horizontal bar chart

### 🔄 Menghapus Data Testing

Jika ingin menghapus data testing:

```bash
php artisan tinker
```

Kemudian jalankan:
```php
App\Models\Koperasi::truncate();
App\Models\User::where('role', 'koperasi')->delete();
exit
```

### 📝 Catatan:

- Data yang dibuat adalah data contoh untuk testing
- Semua grafik akan otomatis update sesuai data real di database
- Sistem sudah siap untuk data production
- Tidak perlu konfigurasi tambahan

### 🎯 Fitur Otomatis:

✅ **Perhitungan Otomatis:**
- Total koperasi
- Koperasi terverifikasi
- Koperasi aktif
- Total karyawan
- Total modal
- Total omset

✅ **Grafik Otomatis:**
- Semua grafik akan ter-generate otomatis
- Warna dan style sudah disesuaikan
- Responsive untuk semua device
- Interactive tooltips

✅ **Update Real-time:**
- Data akan selalu update sesuai database
- Tidak perlu refresh manual
- Perhitungan dilakukan di backend

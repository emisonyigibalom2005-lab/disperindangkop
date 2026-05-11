# Perbaikan File Chat - Nama File Asli & Preview

## Masalah Sebelumnya
1. File yang dikirim menampilkan nama hash (contoh: `bWXD4IdAxQ2hZBo8lFTx4ylagnusVQkoRCvq659.pdf`)
2. File tidak bisa dibuka/preview dengan benar
3. Download file menggunakan nama hash

## Solusi yang Diterapkan

### 1. Database Migration
- Menambahkan kolom `original_filename` pada tabel `chats`
- File: `database/migrations/2026_04_11_100000_add_original_filename_to_chats_table.php`

### 2. Model Update
- Menambahkan `original_filename` ke fillable di model `Chat`
- File: `app/Models/Chat.php`

### 3. Controller Update
- Menyimpan nama file asli saat upload
- Menambahkan method `viewFile()` untuk preview file
- Method `downloadFile()` menggunakan nama file asli
- File: `app/Http/Controllers/Anggota/ChatController.php`

### 4. Routes
- `GET /anggota-portal/chat-file/{id}/view` - Preview file di browser
- `GET /anggota-portal/chat-file/{id}/download` - Download file dengan nama asli
- File: `routes/web.php`

### 5. View Update
- Menampilkan nama file asli (`original_filename`)
- Tombol "Lihat" menggunakan route view
- Tombol "Download" menggunakan route download
- File: `resources/views/anggota/chat/show.blade.php`

## Cara Kerja

### Upload File
```php
// Controller menyimpan file dengan hash di storage
$filePath = $file->store('chat-files', 'public');

// Tapi juga menyimpan nama asli
$originalName = $file->getClientOriginalName();

// Keduanya disimpan ke database
$data['file'] = $filePath; // hash path
$data['original_filename'] = $originalName; // nama asli
```

### Preview File (Lihat)
```php
// Method viewFile() di controller
return response()->file($filePath, [
    'Content-Type' => $mimeType,
    'Content-Disposition' => 'inline; filename="' . $fileName . '"'
]);
```

### Download File
```php
// Method downloadFile() di controller
return response()->download($filePath, $fileName);
```

## Hasil
✅ Nama file ditampilkan dengan nama asli (contoh: `Laporan_Keuangan.pdf`)
✅ Tombol "Lihat" membuka file di tab baru untuk preview
✅ Tombol "Download" mendownload file dengan nama asli
✅ Mendukung semua jenis file (PDF, Word, Excel, gambar, video, dll)
✅ File tersimpan aman dengan hash di server
✅ User experience seperti WhatsApp atau aplikasi chat modern

## Migration
Jalankan migration untuk menambahkan kolom baru:
```bash
php artisan migrate
```

## Catatan
- File lama yang sudah ada sebelum update ini akan menggunakan `basename($message->file)` sebagai fallback
- File baru akan otomatis menyimpan nama asli
- Storage link harus sudah dibuat: `php artisan storage:link`

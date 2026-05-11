<?php
/**
 * FIX PERMISSION BANTUAN UNTUK PIMPINAN
 * 
 * Cara menjalankan:
 * php fix-permission.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "===========================================\n";
echo "FIX PERMISSION REKAP BANTUAN - PIMPINAN\n";
echo "===========================================\n\n";

// Step 1: Cek permission saat ini
echo "STEP 1: Cek permission saat ini...\n";
$current = DB::table('role_permissions')
    ->where('role', 'pimpinan')
    ->where('module', 'laporan')
    ->first();

if ($current) {
    echo "Permission ditemukan:\n";
    echo "  - can_view: " . ($current->can_view ? 'YES' : 'NO') . "\n";
    echo "  - can_create: " . ($current->can_create ? 'YES' : 'NO') . "\n";
    echo "  - can_edit: " . ($current->can_edit ? 'YES' : 'NO') . "\n";
    echo "  - can_delete: " . ($current->can_delete ? 'YES' : 'NO') . "\n";
    echo "\n";
} else {
    echo "Permission TIDAK ditemukan!\n\n";
}

// Step 2: Hapus permission lama
echo "STEP 2: Hapus permission lama...\n";
$deleted = DB::table('role_permissions')
    ->where('role', 'pimpinan')
    ->where('module', 'laporan')
    ->delete();
echo "Deleted: $deleted row(s)\n\n";

// Step 3: Insert permission baru dengan SEMUA akses
echo "STEP 3: Insert permission baru...\n";
$inserted = DB::table('role_permissions')->insert([
    'role' => 'pimpinan',
    'module' => 'laporan',
    'can_view' => 1,
    'can_create' => 1,
    'can_edit' => 1,
    'can_delete' => 1,
    'can_export' => 1,
    'can_approve' => 0,
    'created_at' => now(),
    'updated_at' => now(),
]);

if ($inserted) {
    echo "✓ Permission berhasil di-insert!\n\n";
} else {
    echo "✗ Gagal insert permission!\n\n";
    exit(1);
}

// Step 4: Verifikasi hasil
echo "STEP 4: Verifikasi hasil...\n";
$result = DB::table('role_permissions')
    ->where('role', 'pimpinan')
    ->where('module', 'laporan')
    ->first();

if ($result) {
    echo "Permission setelah update:\n";
    echo "  - can_view: " . ($result->can_view ? '✓ YES' : '✗ NO') . "\n";
    echo "  - can_create: " . ($result->can_create ? '✓ YES' : '✗ NO') . "\n";
    echo "  - can_edit: " . ($result->can_edit ? '✓ YES' : '✗ NO') . "\n";
    echo "  - can_delete: " . ($result->can_delete ? '✓ YES' : '✗ NO') . "\n";
    echo "  - can_export: " . ($result->can_export ? '✓ YES' : '✗ NO') . "\n";
    echo "\n";
    
    // Cek apakah semua permission aktif
    if ($result->can_view && $result->can_create && $result->can_edit && $result->can_delete) {
        echo "✓✓✓ SEMUA PERMISSION AKTIF! ✓✓✓\n\n";
    } else {
        echo "⚠ Ada permission yang belum aktif!\n\n";
    }
} else {
    echo "✗ Permission tidak ditemukan setelah insert!\n\n";
    exit(1);
}

// Step 5: Clear cache
echo "STEP 5: Clear cache...\n";
Artisan::call('optimize:clear');
echo "✓ Cache cleared!\n\n";

echo "===========================================\n";
echo "SELESAI!\n";
echo "===========================================\n\n";

echo "LANGKAH SELANJUTNYA:\n";
echo "1. Logout dari akun Pimpinan\n";
echo "2. Login ulang\n";
echo "3. Buka halaman: /pimpinan/laporan/bantuan\n";
echo "4. Refresh dengan Ctrl+F5\n";
echo "5. Cek alert status - semua harus ✓ (hijau)\n";
echo "6. Cek tombol di tabel - harus ada 3 tombol\n\n";

echo "Jika masih belum muncul, cek log file:\n";
echo "storage/logs/laravel.log\n\n";

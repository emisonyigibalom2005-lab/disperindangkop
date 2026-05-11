<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Anggota;

echo "===========================================\n";
echo "VERIFIKASI KODE SAAT INI\n";
echo "===========================================\n\n";

echo "1. DATA ANGGOTA KOPERASI (whereNotNull('tanggal_bergabung')):\n";
echo "─────────────────────────────────────────\n";
$dataAnggota = Anggota::whereNotNull('tanggal_bergabung')->get();
echo "Total: " . $dataAnggota->count() . "\n";
foreach ($dataAnggota->groupBy('status') as $status => $items) {
    echo "  - {$status}: " . $items->count() . "\n";
}
echo "\n";

echo "2. VERIFIKASI PENDAFTARAN (whereNull('tanggal_bergabung')):\n";
echo "─────────────────────────────────────────\n";
$verifikasi = Anggota::whereNull('tanggal_bergabung')->get();
echo "Total: " . $verifikasi->count() . "\n";
if ($verifikasi->count() > 0) {
    foreach ($verifikasi->groupBy('status') as $status => $items) {
        echo "  - {$status}: " . $items->count() . "\n";
    }
} else {
    echo "  (Kosong - tidak ada pendaftaran baru)\n";
}
echo "\n";

echo "===========================================\n";
echo "KESIMPULAN:\n";
echo "===========================================\n\n";

if ($dataAnggota->count() > 0 && $verifikasi->count() == 0) {
    echo "✅ KODE SUDAH BENAR!\n";
    echo "✅ Semua anggota yang sudah diverifikasi ada di Data Anggota\n";
    echo "✅ Tidak ada pendaftaran baru di Verifikasi\n";
} else {
    echo "Status:\n";
    echo "- Data Anggota: " . $dataAnggota->count() . " anggota\n";
    echo "- Verifikasi: " . $verifikasi->count() . " anggota\n";
}

echo "\n===========================================\n";

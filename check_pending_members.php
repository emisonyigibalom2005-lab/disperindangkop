<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Anggota;

echo "===========================================\n";
echo "CEK ANGGOTA DENGAN STATUS PENDING\n";
echo "===========================================\n\n";

$pending = Anggota::where('status', 'Pending')->get();

echo "Total Anggota Pending: " . $pending->count() . "\n\n";

foreach ($pending as $a) {
    echo "─────────────────────────────────────────\n";
    echo "Nama: " . $a->nama . "\n";
    echo "No. Anggota: " . $a->no_anggota . "\n";
    echo "Status: " . $a->status . "\n";
    echo "tanggal_bergabung: " . ($a->tanggal_bergabung ? $a->tanggal_bergabung : 'NULL') . "\n";
    echo "Muncul di: " . ($a->tanggal_bergabung ? 'DATA ANGGOTA KOPERASI ✅' : 'VERIFIKASI PENDAFTARAN ✅') . "\n";
    echo "\n";
}

echo "===========================================\n";
echo "KESIMPULAN:\n";
echo "===========================================\n\n";

$pendingDenganTanggal = Anggota::where('status', 'Pending')->whereNotNull('tanggal_bergabung')->count();
$pendingTanpaTanggal = Anggota::where('status', 'Pending')->whereNull('tanggal_bergabung')->count();

echo "Pending dengan tanggal_bergabung (Muncul di Data Anggota): " . $pendingDenganTanggal . "\n";
echo "Pending tanpa tanggal_bergabung (Muncul di Verifikasi): " . $pendingTanpaTanggal . "\n\n";

if ($pendingDenganTanggal > 0) {
    echo "✅ SISTEM BENAR: Anggota Pending yang sudah pernah diverifikasi\n";
    echo "   muncul di DATA ANGGOTA KOPERASI (bukan di Verifikasi)\n\n";
}

if ($pendingTanpaTanggal > 0) {
    echo "✅ SISTEM BENAR: Anggota Pending yang belum pernah diverifikasi\n";
    echo "   muncul di VERIFIKASI PENDAFTARAN (bukan di Data Anggota)\n\n";
}

echo "===========================================\n";

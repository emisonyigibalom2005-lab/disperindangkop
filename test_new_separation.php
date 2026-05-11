<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Anggota;

echo "===========================================\n";
echo "TEST PEMISAHAN BARU - SEDERHANA\n";
echo "===========================================\n\n";

echo "PEMISAHAN BARU:\n";
echo "├─ DATA ANGGOTA KOPERASI = Status: Aktif, Nonaktif\n";
echo "└─ VERIFIKASI PENDAFTARAN = Status: Pending, Ditolak\n\n";

echo "===========================================\n";
echo "HASIL:\n";
echo "===========================================\n\n";

$dataAnggota = Anggota::whereIn('status', ['Aktif', 'Nonaktif'])->get();
$verifikasi = Anggota::whereIn('status', ['Pending', 'Ditolak'])->get();

echo "DATA ANGGOTA KOPERASI: " . $dataAnggota->count() . " anggota\n";
echo "─────────────────────────────────────────\n";
foreach ($dataAnggota as $a) {
    $statusBadge = $a->status === 'Aktif' ? '✅' : '⚠️';
    echo "{$statusBadge} {$a->nama} ({$a->no_anggota}) - Status: {$a->status}\n";
}
echo "\n";

echo "VERIFIKASI PENDAFTARAN: " . $verifikasi->count() . " anggota\n";
echo "─────────────────────────────────────────\n";
foreach ($verifikasi as $a) {
    $statusBadge = $a->status === 'Pending' ? '⏳' : '❌';
    echo "{$statusBadge} {$a->nama} ({$a->no_anggota}) - Status: {$a->status}\n";
}
echo "\n";

echo "===========================================\n";
echo "SUMMARY:\n";
echo "===========================================\n\n";

$aktif = Anggota::where('status', 'Aktif')->count();
$nonaktif = Anggota::where('status', 'Nonaktif')->count();
$pending = Anggota::where('status', 'Pending')->count();
$ditolak = Anggota::where('status', 'Ditolak')->count();

echo "Status Anggota:\n";
echo "├─ Aktif: {$aktif}\n";
echo "├─ Nonaktif: {$nonaktif}\n";
echo "├─ Pending: {$pending}\n";
echo "└─ Ditolak: {$ditolak}\n\n";

echo "Pemisahan:\n";
echo "├─ DATA ANGGOTA KOPERASI: " . ($aktif + $nonaktif) . " (Aktif + Nonaktif)\n";
echo "└─ VERIFIKASI PENDAFTARAN: " . ($pending + $ditolak) . " (Pending + Ditolak)\n\n";

echo "✅ PEMISAHAN SELESAI!\n";
echo "===========================================\n";

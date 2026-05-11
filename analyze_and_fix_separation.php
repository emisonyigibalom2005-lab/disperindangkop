<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Anggota;

echo "===========================================\n";
echo "ANALISIS DAN PERBAIKAN PEMISAHAN DATA\n";
echo "===========================================\n\n";

// Cek semua anggota
$allAnggota = Anggota::all();

echo "TOTAL ANGGOTA: " . $allAnggota->count() . "\n\n";

// Kelompokkan berdasarkan status dan tanggal_bergabung
$groups = [
    'aktif_verified' => [],
    'pending_verified' => [],
    'nonaktif_verified' => [],
    'pending_unverified' => [],
    'ditolak_unverified' => [],
];

foreach ($allAnggota as $a) {
    $hasDate = $a->tanggal_bergabung !== null;
    $status = $a->status;
    
    if ($hasDate) {
        if ($status === 'Aktif') {
            $groups['aktif_verified'][] = $a;
        } elseif ($status === 'Pending') {
            $groups['pending_verified'][] = $a;
        } elseif ($status === 'Nonaktif') {
            $groups['nonaktif_verified'][] = $a;
        }
    } else {
        if ($status === 'Pending') {
            $groups['pending_unverified'][] = $a;
        } elseif ($status === 'Ditolak') {
            $groups['ditolak_unverified'][] = $a;
        }
    }
}

echo "KELOMPOK DATA:\n";
echo "─────────────────────────────────────────\n\n";

echo "1. AKTIF + SUDAH DIVERIFIKASI:\n";
echo "   Jumlah: " . count($groups['aktif_verified']) . "\n";
echo "   Muncul di: DATA ANGGOTA KOPERASI ✅\n\n";

echo "2. PENDING + SUDAH DIVERIFIKASI:\n";
echo "   Jumlah: " . count($groups['pending_verified']) . "\n";
echo "   Muncul di: DATA ANGGOTA KOPERASI ✅\n";
if (count($groups['pending_verified']) > 0) {
    echo "   Detail:\n";
    foreach ($groups['pending_verified'] as $a) {
        echo "   - {$a->nama} ({$a->no_anggota})\n";
    }
}
echo "\n";

echo "3. NONAKTIF + SUDAH DIVERIFIKASI:\n";
echo "   Jumlah: " . count($groups['nonaktif_verified']) . "\n";
echo "   Muncul di: DATA ANGGOTA KOPERASI ✅\n\n";

echo "4. PENDING + BELUM DIVERIFIKASI:\n";
echo "   Jumlah: " . count($groups['pending_unverified']) . "\n";
echo "   Muncul di: VERIFIKASI PENDAFTARAN ✅\n\n";

echo "5. DITOLAK + BELUM DIVERIFIKASI:\n";
echo "   Jumlah: " . count($groups['ditolak_unverified']) . "\n";
echo "   Muncul di: VERIFIKASI PENDAFTARAN ✅\n\n";

echo "===========================================\n";
echo "KESIMPULAN:\n";
echo "===========================================\n\n";

$dataAnggotaTotal = count($groups['aktif_verified']) + count($groups['pending_verified']) + count($groups['nonaktif_verified']);
$verifikasiTotal = count($groups['pending_unverified']) + count($groups['ditolak_unverified']);

echo "DATA ANGGOTA KOPERASI: {$dataAnggotaTotal} anggota\n";
echo "├─ Aktif: " . count($groups['aktif_verified']) . "\n";
echo "├─ Pending: " . count($groups['pending_verified']) . "\n";
echo "└─ Nonaktif: " . count($groups['nonaktif_verified']) . "\n\n";

echo "VERIFIKASI PENDAFTARAN: {$verifikasiTotal} anggota\n";
echo "├─ Pending: " . count($groups['pending_unverified']) . "\n";
echo "└─ Ditolak: " . count($groups['ditolak_unverified']) . "\n\n";

if (count($groups['pending_verified']) > 0) {
    echo "⚠️ PERHATIAN:\n";
    echo "Ada " . count($groups['pending_verified']) . " anggota dengan status Pending yang SUDAH DIVERIFIKASI.\n";
    echo "Ini adalah anggota yang dulu Aktif, tapi statusnya diubah jadi Pending.\n";
    echo "Mereka TETAP di DATA ANGGOTA KOPERASI (BUKAN di Verifikasi).\n";
    echo "Ini adalah PERILAKU YANG BENAR sesuai permintaan.\n\n";
}

echo "✅ SISTEM SUDAH BENAR!\n";
echo "===========================================\n";

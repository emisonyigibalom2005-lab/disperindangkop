<?php
/**
 * Script untuk memperbaiki data tanggal_bergabung
 * Jalankan dengan: php fix_tanggal_bergabung.php
 * 
 * Script ini akan:
 * 1. Mengisi tanggal_bergabung untuk anggota dengan status Aktif yang tanggal_bergabung-nya NULL
 * 2. Menggunakan tanggal_verifikasi jika ada, atau created_at jika tidak ada
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Anggota;

echo "===========================================\n";
echo "FIX TANGGAL BERGABUNG - DATA ANGGOTA\n";
echo "===========================================\n\n";

// Cari anggota dengan status Aktif tapi tanggal_bergabung NULL
$anggotaAktif = Anggota::where('status', 'Aktif')
    ->whereNull('tanggal_bergabung')
    ->get();

echo "Ditemukan " . $anggotaAktif->count() . " anggota Aktif dengan tanggal_bergabung NULL\n\n";

if ($anggotaAktif->count() > 0) {
    echo "Memperbaiki data...\n";
    
    foreach ($anggotaAktif as $anggota) {
        // Gunakan tanggal_verifikasi jika ada, jika tidak gunakan created_at
        $tanggalBergabung = $anggota->tanggal_verifikasi ?? $anggota->created_at;
        
        $anggota->update([
            'tanggal_bergabung' => $tanggalBergabung
        ]);
        
        echo "✓ {$anggota->nama} ({$anggota->no_anggota}) - tanggal_bergabung diisi: {$tanggalBergabung}\n";
    }
    
    echo "\n✅ Selesai! {$anggotaAktif->count()} data berhasil diperbaiki.\n";
} else {
    echo "✅ Tidak ada data yang perlu diperbaiki.\n";
}

// Cari anggota dengan status Nonaktif/Pending yang sudah pernah Aktif (punya tanggal_verifikasi)
$anggotaLain = Anggota::whereIn('status', ['Nonaktif', 'Pending'])
    ->whereNull('tanggal_bergabung')
    ->whereNotNull('tanggal_verifikasi')
    ->get();

if ($anggotaLain->count() > 0) {
    echo "\n\nDitemukan " . $anggotaLain->count() . " anggota Nonaktif/Pending yang punya tanggal_verifikasi\n";
    echo "Memperbaiki data...\n";
    
    foreach ($anggotaLain as $anggota) {
        $tanggalBergabung = $anggota->tanggal_verifikasi;
        
        $anggota->update([
            'tanggal_bergabung' => $tanggalBergabung
        ]);
        
        echo "✓ {$anggota->nama} ({$anggota->no_anggota}) - Status: {$anggota->status} - tanggal_bergabung diisi: {$tanggalBergabung}\n";
    }
    
    echo "\n✅ Selesai! {$anggotaLain->count()} data berhasil diperbaiki.\n";
}

echo "\n===========================================\n";
echo "SUMMARY\n";
echo "===========================================\n";

$totalDenganTanggal = Anggota::whereNotNull('tanggal_bergabung')->count();
$totalTanpaTanggal = Anggota::whereNull('tanggal_bergabung')->count();

echo "Total anggota dengan tanggal_bergabung: {$totalDenganTanggal}\n";
echo "Total anggota tanpa tanggal_bergabung: {$totalTanpaTanggal}\n";

if ($totalTanpaTanggal > 0) {
    echo "\n📋 Anggota tanpa tanggal_bergabung (pendaftaran baru):\n";
    $pendaftaranBaru = Anggota::whereNull('tanggal_bergabung')->get();
    foreach ($pendaftaranBaru as $anggota) {
        echo "  - {$anggota->nama} ({$anggota->no_anggota}) - Status: {$anggota->status}\n";
    }
}

echo "\n✅ SELESAI!\n";
echo "===========================================\n";

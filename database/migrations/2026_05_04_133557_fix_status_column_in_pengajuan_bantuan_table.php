<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah kolom status dari ENUM yang mungkin salah menjadi VARCHAR
        DB::statement("ALTER TABLE `pengajuan_bantuan` MODIFY `status` VARCHAR(20) NOT NULL DEFAULT 'pending'");
        
        // Atau jika ingin tetap menggunakan ENUM, pastikan nilai-nilainya benar
        // DB::statement("ALTER TABLE `pengajuan_bantuan` MODIFY `status` ENUM('pending', 'diproses', 'disetujui', 'ditolak', 'selesai') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Kembalikan ke ENUM original jika diperlukan
        DB::statement("ALTER TABLE `pengajuan_bantuan` MODIFY `status` ENUM('pending', 'diterima', 'ditolak') NOT NULL DEFAULT 'pending'");
    }
};

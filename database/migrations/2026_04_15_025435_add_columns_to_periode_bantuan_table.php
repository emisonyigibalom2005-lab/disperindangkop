<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('periode_bantuan', function (Blueprint $table) {
            $table->string('nama_periode')->after('id');
            $table->text('deskripsi')->nullable()->after('nama_periode');
            $table->date('tanggal_mulai')->after('deskripsi');
            $table->date('tanggal_selesai')->after('tanggal_mulai');
            $table->enum('status', ['aktif', 'nonaktif'])->default('nonaktif')->after('tanggal_selesai');
            $table->integer('kuota_penerima')->nullable()->after('status');
            $table->decimal('anggaran_total', 15, 2)->nullable()->after('kuota_penerima');
            $table->foreignId('created_by')->nullable()->after('anggaran_total')->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('periode_bantuan', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn([
                'nama_periode',
                'deskripsi',
                'tanggal_mulai',
                'tanggal_selesai',
                'status',
                'kuota_penerima',
                'anggaran_total',
                'created_by',
            ]);
        });
    }
};

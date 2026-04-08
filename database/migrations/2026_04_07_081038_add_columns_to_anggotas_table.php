<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('anggotas', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->onDelete('set null');
            $table->text('catatan_admin')->nullable()->after('status');
            $table->timestamp('tanggal_verifikasi')->nullable()->after('catatan_admin');
        });
    }
    public function down() {
        Schema::table('anggotas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id','catatan_admin','tanggal_verifikasi']);
        });
    }
};

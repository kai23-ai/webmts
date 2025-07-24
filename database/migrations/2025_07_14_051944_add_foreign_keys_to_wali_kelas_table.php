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
        Schema::table('wali_kelas', function (Blueprint $table) {
            $table->foreign(['guru_id'])->references(['id'])->on('guru')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['kelas_id'])->references(['id'])->on('kelas')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wali_kelas', function (Blueprint $table) {
            $table->dropForeign('wali_kelas_guru_id_foreign');
            $table->dropForeign('wali_kelas_kelas_id_foreign');
        });
    }
};

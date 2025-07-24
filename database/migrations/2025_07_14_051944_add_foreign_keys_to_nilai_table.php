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
        Schema::table('nilai', function (Blueprint $table) {
            $table->foreign(['mapel_id'])->references(['id'])->on('mata_pelajaran')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['kelas_siswa_id'])->references(['id'])->on('kelas_siswa')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['wali_kelas_id'])->references(['id'])->on('wali_kelas')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['semester_id'])->references(['id'])->on('semester')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->dropForeign('nilai_mapel_id_foreign');
            $table->dropForeign('nilai_kelas_siswa_id_foreign');
            $table->dropForeign('nilai_wali_kelas_id_foreign');
            $table->dropForeign('nilai_semester_id_foreign');
        });
    }
};

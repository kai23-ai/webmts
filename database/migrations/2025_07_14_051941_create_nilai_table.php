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
        Schema::create('nilai', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kelas_siswa_id')->index('nilai_kelas_siswa_id_foreign');
            $table->unsignedBigInteger('wali_kelas_id')->index('nilai_wali_kelas_id_foreign');
            $table->unsignedBigInteger('mapel_id')->index('nilai_mapel_id_foreign');
            $table->unsignedBigInteger('semester_id')->index('nilai_semester_id_foreign');
            $table->integer('nilai_akhir');
            $table->text('capaian_kompetensi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};

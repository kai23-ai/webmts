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
        Schema::create('wali_kelas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('guru_id');
            $table->unsignedBigInteger('kelas_id')->index('wali_kelas_kelas_id_foreign');
            $table->unsignedBigInteger('tahun_ajaran_id');
            $table->enum('status', ['aktif', 'tidak'])->default('aktif');
            $table->timestamps();

            $table->unique(['guru_id', 'tahun_ajaran_id'], 'unique_guru_tahun');
            $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wali_kelas');
    }
};

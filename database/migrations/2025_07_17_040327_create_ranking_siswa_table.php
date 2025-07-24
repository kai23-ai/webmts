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
        Schema::create('ranking_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelas_siswa_id'); // Reference to kelas_siswa table (contains siswa_id and kelas_id)
            $table->unsignedBigInteger('wali_kelas_id'); // Reference to wali_kelas table (contains guru_id and kelas_id)
            $table->unsignedBigInteger('tahun_ajaran_id');
            $table->unsignedBigInteger('semester_id'); // Reference to semester table
            $table->integer('posisi');
            $table->decimal('nilai_rata_rata', 5, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('kelas_siswa_id')->references('id')->on('kelas_siswa')->onDelete('cascade');
            $table->foreign('wali_kelas_id')->references('id')->on('wali_kelas')->onDelete('cascade');
            $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajaran')->onDelete('cascade');
            $table->foreign('semester_id')->references('id')->on('semester')->onDelete('cascade');

            // Unique constraint to prevent duplicate rankings
            $table->unique(['kelas_siswa_id', 'wali_kelas_id', 'tahun_ajaran_id', 'semester_id'], 'unique_student_wali_year_semester_ranking');
            $table->unique(['wali_kelas_id', 'tahun_ajaran_id', 'semester_id', 'posisi'], 'unique_position_per_wali_year_semester');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ranking_siswa');
    }
};
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NilaiMuatanLokalTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('nilai_muatan_lokal')->insert([
            [
                'kelas_siswa_id' => 1,
                'wali_kelas_id' => 1,
                'muatan_lokal_id' => 1,
                'semester_id' => 1,
                'nilai_akhir' => 85,
                'capaian_kompetensi' => 'Baik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_siswa_id' => 2,
                'wali_kelas_id' => 2,
                'muatan_lokal_id' => 2,
                'semester_id' => 2,
                'nilai_akhir' => 90,
                'capaian_kompetensi' => 'Sangat Baik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NilaiTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('nilai')->insert([
            [
                'kelas_siswa_id' => 1,
                'wali_kelas_id' => 1,
                'mapel_id' => 1,
                'semester_id' => 1,
                'nilai_akhir' => 88,
                'capaian_kompetensi' => 'Sangat Baik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas_siswa_id' => 2,
                'wali_kelas_id' => 2,
                'mapel_id' => 2,
                'semester_id' => 2,
                'nilai_akhir' => 92,
                'capaian_kompetensi' => 'Baik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
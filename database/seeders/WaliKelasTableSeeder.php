<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WaliKelasTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('wali_kelas')->insert([
            [
                'guru_id' => 1,
                'kelas_id' => 1,
                'tahun_ajaran_id' => 1,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guru_id' => 2,
                'kelas_id' => 2,
                'tahun_ajaran_id' => 2,
                'status' => 'tidak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
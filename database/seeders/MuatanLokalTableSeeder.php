<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MuatanLokalTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('muatan_lokal')->insert([
            [
                'nama_muatan' => 'Bahasa Jawa',
                'kelompok_muatan' => 'Wajib',
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_muatan' => 'TIK',
                'kelompok_muatan' => 'Pilihan',
                'urutan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
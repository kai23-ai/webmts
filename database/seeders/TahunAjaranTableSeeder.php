<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TahunAjaranTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('tahun_ajaran')->insert([
            [
                'tahun' => '2022/2023',
                'aktif' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tahun' => '2023/2024',
                'aktif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
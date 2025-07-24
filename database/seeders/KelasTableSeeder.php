<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('kelas')->insert([
            [
                'nama_kelas' => 'VII A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kelas' => 'VII B',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
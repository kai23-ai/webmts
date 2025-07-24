<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('semester')->insert([
            [
                'nama' => 'Ganjil',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Genap',
                'status' => 'tidak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
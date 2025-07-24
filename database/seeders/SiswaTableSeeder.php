<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('siswa')->insert([
            [
                'no_induk' => 'S001',
                'nis' => '2023001',
                'nisn' => '1234567890',
                'nama' => 'Andi Wijaya',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2007-03-15',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Kenanga No. 3',
                'status' => 'aktif',
                'email' => 'andi.wijaya@email.com',
                'notelp' => '081234567890',
                'foto' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_induk' => 'S002',
                'nis' => '2023002',
                'nisn' => '0987654321',
                'nama' => 'Rina Lestari',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '2007-07-22',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Melati No. 5',
                'status' => 'aktif',
                'email' => 'rina.lestari@email.com',
                'notelp' => '081298765432',
                'foto' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
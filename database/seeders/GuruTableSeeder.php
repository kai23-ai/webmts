<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuruTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('guru')->insert([
            [
                'nip' => '1234567890',
                'nama' => 'Budi Santoso',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1980-01-01',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Merdeka No. 1',
                'status' => 'aktif',
                'email' => 'budi@email.com',
                'notelp' => '081234567890',
                'foto' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip' => '0987654321',
                'nama' => 'Siti Aminah',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1982-05-12',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Sudirman No. 2',
                'status' => 'aktif',
                'email' => 'siti@email.com',
                'notelp' => '081298765432',
                'foto' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
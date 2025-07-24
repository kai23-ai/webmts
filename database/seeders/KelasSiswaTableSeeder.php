<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class KelasSiswaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contoh data, sesuaikan id dengan data yang ada di tabel siswa, kelas, tahun_ajaran
        DB::table('kelas_siswa')->insert([
            [
                'siswa_id' => 1,
                'kelas_id' => 1,
                'tahun_ajaran_id' => 1,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 2,
                'kelas_id' => 2,
                'tahun_ajaran_id' => 2,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 
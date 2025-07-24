<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnnouncementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('announcements')->insert([
            [
                'judul' => 'Maintenance Server',
                'isi' => 'Akan ada maintenance server pada 20 Juli 2025, pukul 22:00-23:00 WIB.',
                'role' => 'admin',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Input Nilai Semester',
                'isi' => 'Penginputan nilai semester dibuka hingga 31 Juli 2025.',
                'role' => 'guru',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Penerimaan Siswa Baru',
                'isi' => 'Pendaftaran siswa baru dibuka mulai 1 Agustus 2025.',
                'role' => 'siswa',
                'status' => 'nonaktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

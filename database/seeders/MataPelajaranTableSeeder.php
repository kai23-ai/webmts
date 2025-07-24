<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;
use App\Models\Guru;

class MataPelajaranTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // PAI
            ['kode_mapel' => 'QH',    'nama_mapel' => 'Quran Hadits',                'jenis_mapel' => 'PAI'],
            ['kode_mapel' => 'AA',    'nama_mapel' => 'Akidah Akhlak',               'jenis_mapel' => 'PAI'],
            ['kode_mapel' => 'FIK',   'nama_mapel' => 'Fikih',                       'jenis_mapel' => 'PAI'],
            ['kode_mapel' => 'SKI',   'nama_mapel' => 'Sejarah Kebudayaan Islam',    'jenis_mapel' => 'PAI'],
            // UMUM
            ['kode_mapel' => 'BAR',   'nama_mapel' => 'Bahasa Arab',                 'jenis_mapel' => 'UMUM'],
            ['kode_mapel' => 'PP',    'nama_mapel' => 'Pendidikan Pancasila',        'jenis_mapel' => 'UMUM'],
            ['kode_mapel' => 'BINDO', 'nama_mapel' => 'Bahasa Indonesia',            'jenis_mapel' => 'UMUM'],
            ['kode_mapel' => 'MTK',   'nama_mapel' => 'Matematika',                  'jenis_mapel' => 'UMUM'],
            ['kode_mapel' => 'IPA',   'nama_mapel' => 'Ilmu Pengetahuan Alam',       'jenis_mapel' => 'UMUM'],
            ['kode_mapel' => 'IPS',   'nama_mapel' => 'Ilmu Pengetahuan Sosial',     'jenis_mapel' => 'UMUM'],
            ['kode_mapel' => 'BING',  'nama_mapel' => 'Bahasa Inggris',              'jenis_mapel' => 'UMUM'],
            ['kode_mapel' => 'PJOK',  'nama_mapel' => 'Pendidikan Jasmani dan Kesehatan', 'jenis_mapel' => 'UMUM'],
            ['kode_mapel' => 'INFO',  'nama_mapel' => 'Informatika',                 'jenis_mapel' => 'UMUM'],
            ['kode_mapel' => 'SBP',   'nama_mapel' => 'Seni Budaya dan Prakarya',    'jenis_mapel' => 'UMUM'],
            // MULOK
            ['kode_mapel' => 'BTTQ',  'nama_mapel' => 'Baca Tulis dan Tahfidz Quran','jenis_mapel' => 'MULOK'],
            ['kode_mapel' => 'MADUR', 'nama_mapel' => 'Bahasa Madura',               'jenis_mapel' => 'MULOK'],
        ];
        $urut = 1;
        foreach ($data as $row) {
            $row['urutan'] = $urut++;
            \App\Models\MataPelajaran::create($row);
        }
    }
}
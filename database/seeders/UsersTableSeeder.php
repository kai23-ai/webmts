<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'password' => Hash::make('siswa123'),
                'role' => 'siswa',
                'siswa_id' => 1,
                'guru_id' => null,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'password' => Hash::make('guru123'),
                'role' => 'guru',
                'siswa_id' => null,
                'guru_id' => 2,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'siswa_id' => null,
                'guru_id' => 1,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(KelasTableSeeder::class);
        $this->call(SiswaTableSeeder::class);
        $this->call(GuruTableSeeder::class);
        $this->call(MataPelajaranTableSeeder::class);
        $this->call(SemesterTableSeeder::class);
        $this->call(TahunAjaranTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(WaliKelasTableSeeder::class);
        $this->call(KelasSiswaTableSeeder::class);
        $this->call(NilaiTableSeeder::class);
        $this->call(AnnouncementTableSeeder::class);
    }
}

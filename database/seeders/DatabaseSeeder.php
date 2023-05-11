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
        $this->call(KabupatenTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(KecamatanTableSeeder::class);
        $this->call(DesaTableSeeder::class);
        $this->call(PuskesmasTableSeeder::class);
        $this->call(SekolahTableSeeder::class);
    }
}

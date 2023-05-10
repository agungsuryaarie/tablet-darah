<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama'    => "Admin",
            'kabupaten_id' => "1",
            'nik' => "1219000000",
            'nohp' => "081300000000",
            'email'    => 'admin@gmail.com',
            'password'    => bcrypt('secret123'),
            'role' => "1",
            'foto' => "",
        ]);
    }
}

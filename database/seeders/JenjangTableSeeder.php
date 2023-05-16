<?php

namespace Database\Seeders;

use App\Models\Jenjang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenjangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'SD',
            ],
            [
                'nama' => 'SMP',
            ],
            [
                'nama' => 'SMA',
            ],
            [
                'nama' => 'SMK',
            ],
        ];
        Jenjang::insert($data);
    }
}

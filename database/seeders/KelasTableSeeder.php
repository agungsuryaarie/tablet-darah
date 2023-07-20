<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'jenjang' => 'SMP',
                'nama' => 'VII',
            ],
            [
                'jenjang' => 'SMP',
                'nama' => 'VIII',
            ],
            [
                'jenjang' => 'SMP',
                'nama' => 'IX',
            ],
            [
                'jenjang' => 'SMA',
                'nama' => 'X',
            ],
            [
                'jenjang' => 'SMA',
                'nama' => 'XI',
            ],
            [
                'jenjang' => 'SMA',
                'nama' => 'XII',
            ],
            [
                'jenjang' => 'SMK',
                'nama' => 'X',
            ],
            [
                'jenjang' => 'SMK',
                'nama' => 'XI',
            ],
            [
                'jenjang' => 'SMK',
                'nama' => 'XII',
            ],
        ];
        Kelas::insert($data);
    }
}

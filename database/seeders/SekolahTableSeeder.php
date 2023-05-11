<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SekolahTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(public_path('data/sekolah.csv'), 'r');

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ';')) !== false) {
            if (!$firstline) {
                Sekolah::create([
                    'kecamatan_id' => $data['0'],
                    'puskesmas_id' => $data['1'],
                    'npsn' => $data['2'],
                    'sekolah' => $data['3'],
                    'jenjang' => $data['4'],
                    'status' => $data['5'],
                    'alamat_jalan' => $data['6'],
                    'lintang' => $data['7'],
                    'bujur' => $data['8'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KecamatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(public_path('data/kecamatan.csv'), 'r');

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ';')) !== false) {
            if (!$firstline) {
                Kecamatan::create([
                    'kabupaten_id' => $data['0'],
                    'kode_wilayah' => $data['1'],
                    'kecamatan' => $data['2'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}

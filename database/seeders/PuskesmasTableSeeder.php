<?php

namespace Database\Seeders;

use App\Models\Puskesmas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PuskesmasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(public_path('data/puskesmas.csv'), 'r');

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ';')) !== false) {
            if (!$firstline) {
                Puskesmas::create([
                    'kecamatan_id' => $data['0'],
                    'puskesmas' => $data['1'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}

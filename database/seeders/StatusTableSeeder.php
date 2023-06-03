<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'status' => 'N',
                'nama' => 'Negeri',
            ],
            [
                'status' => 'S',
                'nama' => 'Swasta',
            ],
        ];
        Status::insert($data);
    }
}

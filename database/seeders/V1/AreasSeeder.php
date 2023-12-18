<?php

namespace Database\Seeders\V1;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'area_name' => 'Area 1',
                'description' => "area 1"
            ],
            [
                'area_name' => 'Area 2',
                'description' => "area 2"
            ],
            [
                'area_name' => 'Area 3',
                'description' => "area 3"
            ],
            [
                'area_name' => 'Area 4',
                'description' => "area 4"
            ],
            [
                'area_name' => 'Area 5',
                'description' => "area 5"
            ],
            [
                'area_name' => 'Area 6',
                'description' => "area 6"
            ],
            [
                'area_name' => 'Area 7',
                'description' => "area 7"
            ],
        ];

        foreach ($data as $item) {
            DB::table('areas')->insert($item);
        }
    }
}

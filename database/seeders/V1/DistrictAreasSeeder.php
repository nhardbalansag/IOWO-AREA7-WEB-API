<?php

namespace Database\Seeders\V1;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictAreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'district_id' => 1,
                'area_id' => 1
            ],
            [
                'district_id' => 1,
                'area_id' => 2
            ],
            [
                'district_id' => 1,
                'area_id' => 3
            ],
            [
                'district_id' => 1,
                'area_id' => 4
            ],
            [
                'district_id' => 1,
                'area_id' => 5
            ],
            [
                'district_id' => 1,
                'area_id' => 6
            ],
            [
                'district_id' => 1,
                'area_id' => 7
            ],
        ];

        foreach ($data as $item) {
            DB::table('district_areas')->insert($item);
        }

    }
}

<?php

namespace Database\Seeders\V1;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChurchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'district_area_id' => 7,
                'church_name' => "Miramonte",
                'church_address' => "miramonte park subdivision brgy. 180 caloocan city"
            ],
            [
                'district_area_id' => 7,
                'church_name' => "Taguig",
                'church_address' => "maharlika road upper bicutan, taguig city"
            ],
            [
                'district_area_id' => 7,
                'church_name' => "Novaliches",
                'church_address' => "56 sta. veronica st. gulod novaliches quezon city"
            ],
            [
                'district_area_id' => 1,
                'church_name' => "church 1",
                'church_address' => "test church 1 address please ignore this."
            ],
            [
                'district_area_id' => 7,
                'church_name' => "church 2",
                'church_address' => "test church 2 address please ignore this."
            ]
        ];

        foreach ($data as $item) {
            DB::table('churches')->insert($item);
        }
    }
}

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
                'church_name' => "International One Way Outreach Miramonte",
                'church_address' => "miramonte park subdivision brgy. 180 caloocan city"
            ],
        ];

        foreach ($data as $item) {
            DB::table('churches')->insert($item);
        }
    }
}

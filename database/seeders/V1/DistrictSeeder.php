<?php

namespace Database\Seeders\V1;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'district_name' => 'District 4',
                'description' => "district 4"
            ],
            [
                'district_name' => 'test district',
                'description' => "test only"
            ]
        ];

        foreach ($data as $item) {
            DB::table('districts')->insert($item);
        }
    }
}

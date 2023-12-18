<?php

namespace Database\Seeders\V1;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivityCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'activity_name' => 'Regular Sunday Service',
                'description' => "regular sunday service"
            ],
        ];

        foreach ($data as $item) {
            DB::table('activity_categories')->insert($item);
        }
    }
}

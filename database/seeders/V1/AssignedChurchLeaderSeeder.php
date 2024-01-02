<?php

namespace Database\Seeders\V1;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignedChurchLeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // assigned test church 1 to this test account for pastor 1
            [
                'user_id' => 1, // test pastor 1
                'church_id' => 4 // test church 1
            ],
            [
                'user_id' => 2, // Pstr. mervin pabiran
                'church_id' => 2 // taguig church
            ],
            [
                'user_id' => 3, // Pstr. Bonyl
                'church_id' => 3 // novaliches church
            ],
            [
                'user_id' => 4, // Pstr. Pijime
                'church_id' => 1 // miramonte church
            ],
            [
                'user_id' => 4, // Pstr. Pijime
                'church_id' => 2 // taguig church
            ],
            [
                'user_id' => 4, // Pstr. Pijime
                'church_id' => 3 // novaliches church
            ],
            [
                'user_id' => 5, // Pstr. Daisy
                'church_id' => 1 // miramonte church
            ],
            // assigned test church 2 to this test account for pastor 2
            [
                'user_id' => 6, // Test pastor 2
                'church_id' => 5 // Test church 2
            ],
            // assigned 2 church to this test area overseer
            [
                'user_id' => 7, // test overseer 1
                'church_id' => 4 // test church 1
            ],
            [
                'user_id' => 7, // test overseer 1
                'church_id' => 5 // test church 2
            ],
        ];

        foreach ($data as $item) {
            DB::table('assigned_church_leaders')->insert($item);
        }
    }
}

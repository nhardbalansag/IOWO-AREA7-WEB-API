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
            [
                'user_id' => 1, // test acccount
                'church_id' => 4 // test church
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
                'user_id' => 5, // Pstr. Pijime
                'church_id' => 1 // miramonte church
            ],
            [
                'user_id' => 5, // Pstr. Pijime
                'church_id' => 5 // Test church
            ],
            [
                'user_id' => 6, // Bernard Test Account Pastor category
                'church_id' => 5 // Test church
            ],
        ];

        foreach ($data as $item) {
            DB::table('assigned_church_leaders')->insert($item);
        }
    }
}

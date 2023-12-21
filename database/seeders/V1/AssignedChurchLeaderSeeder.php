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
                'user_id' => 1,
                'church_id' => 1
            ],
            [
                'user_id' => 2,
                'church_id' => 2
            ],
        ];

        foreach ($data as $item) {
            DB::table('assigned_church_leaders')->insert($item);
        }
    }
}

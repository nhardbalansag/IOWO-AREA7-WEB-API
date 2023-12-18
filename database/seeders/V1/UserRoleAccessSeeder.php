<?php

namespace Database\Seeders\V1;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 1,
                'role_id' => 1,
                'access_type_id' => 1,
            ],
            [
                'user_id' => 1,
                'role_id' => 1,
                'access_type_id' => 2,
            ],
            [
                'user_id' => 1,
                'role_id' => 1,
                'access_type_id' => 3,
            ],
            [
                'user_id' => 1,
                'role_id' => 1,
                'access_type_id' => 4,
            ],
        ];

        foreach ($data as $item) {
            DB::table('user_role_accesses')->insert($item);
        }
    }
}





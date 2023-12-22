<?php

namespace Database\Seeders\V1;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users_data = [
            [
                'user_category_title' => 'pastor',
                'user_category_description' => "church pastor"
            ],
            [
                'user_category_title' => 'area_overseer',
                'user_category_description' => "area overseer pastor"
            ]
        ];

        DB::table('user_categories')->insert($users_data);
    }
}

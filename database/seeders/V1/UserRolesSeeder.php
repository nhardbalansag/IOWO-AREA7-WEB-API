<?php

namespace Database\Seeders\V1;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users_data = [
            [
                'role' => 'admin',
                'description' => "admin"
            ],
            [
                'role' => 'user',
                'description' => "user"
            ],
        ];

        foreach ($users_data as $user) {
            DB::table('user_roles')->insert($user);
        }

    }
}

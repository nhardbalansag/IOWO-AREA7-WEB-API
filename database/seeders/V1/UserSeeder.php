<?php

namespace Database\Seeders\V1;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // dd( Carbon::parse('1997-04-01')->format('y-m-d'));
        $users_data = [
            [
                'user_category_id' => 1,
                'firstname' => "admin first name",
                'lastname' => "admin last name",
                'middlename' => "admin middle",
                'birthday' => Carbon::parse('1997-04-01')->format('y-m-d'),
                'address' => "miramonte caloocan city",
                'contactnumber' => "+639214408767",
                'email' => "admin@email.com",
                'email_verified_at' => now(),
                'password' => Hash::make('admin')
            ],
            [
                'user_category_id' => 1,
                'firstname' => "mervin",
                'lastname' => "pabiran",
                'middlename' => "",
                'birthday' => Carbon::parse('1997-04-01')->format('y-m-d'),
                'address' => "none",
                'contactnumber' => "none",
                'email' => "mervinpabiran@gmail.com",
                'email_verified_at' => now(),
                'password' => Hash::make('mervinpabiran')
            ],
            [
                'user_category_id' => 1,
                'firstname' => "aballe",
                'lastname' => "bonyl",
                'middlename' => "",
                'birthday' => Carbon::parse('1997-04-01')->format('y-m-d'),
                'address' => "novaliches quezon city",
                'contactnumber' => "09922320650",
                'email' => "aballebonyl@gmail.com",
                'email_verified_at' => now(),
                'password' => Hash::make('motojea')
            ]
        ];

        DB::table('users')->insert($users_data);
    }
}

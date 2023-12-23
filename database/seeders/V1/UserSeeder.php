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
                'firstname' => "bernard",
                'lastname' => "balansag",
                'middlename' => "",
                'birthday' => Carbon::parse('1997-04-01')->format('y-m-d'),
                'address' => "miramonte caloocan city",
                'contactnumber' => "+639214408767",
                'email' => "admin@email.com",
                'email_verified_at' => now(),
                'password' => Hash::make('admin123')
            ],
            [
                'user_category_id' => 1,
                'firstname' => "mervin",
                'lastname' => "pabiran",
                'middlename' => "",
                'birthday' => null,
                'address' => "san jose del monte bulacan",
                'contactnumber' => null,
                'email' => "mervinpabiran@gmail.com",
                'email_verified_at' => now(),
                'password' => Hash::make('admin123')
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
                'password' => Hash::make('admin123')
            ],
            [
                'user_category_id' => 2,
                'firstname' => "pijeme",
                'lastname' => "walawala",
                'middlename' => "franco",
                'birthday' => Carbon::parse('1988-08-04')->format('y-m-d'),
                'address' => "zamboanga del sur",
                'contactnumber' => "09171655575",
                'email' => "pijeme.walawala@gmail.com",
                'email_verified_at' => now(),
                'password' => Hash::make('admin123')
            ],
            [
                'user_category_id' => 1,
                'firstname' => "daisy",
                'lastname' => "walawala",
                'middlename' => "",
                'birthday' => null,
                'address' => "zamboanga del sur",
                'contactnumber' => null,
                'email' => "walawala.daisy1988@yahoo.com",
                'email_verified_at' => now(),
                'password' => Hash::make('admin123')
            ]
        ];

        DB::table('users')->insert($users_data);
    }
}

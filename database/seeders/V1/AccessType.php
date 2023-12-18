<?php

namespace Database\Seeders\V1;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessType extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'access' => 'view',
                'description' => "view"
            ],
            [
                'access' => 'create',
                'description' => "create"
            ],
            [
                'access' => 'edit',
                'description' => "edit"
            ],
            [
                'access' => 'delete',
                'description' => "delete"
            ],
        ];

        foreach ($data as $item) {
            DB::table('access_types')->insert($item);
        }
    }
}

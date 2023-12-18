<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Database\Seeders\V1\UserCategorySeeder;
use Database\Seeders\V1\UserSeeder;
use Database\Seeders\V1\UserRolesSeeder;
use Database\Seeders\V1\AccessType;
use Database\Seeders\V1\UserRoleAccessSeeder;
use Database\Seeders\V1\DistrictSeeder;
use Database\Seeders\V1\AreasSeeder;
use Database\Seeders\V1\DistrictAreasSeeder;
use Database\Seeders\V1\ChurchSeeder;
use Database\Seeders\V1\AssignedChurchLeaderSeeder;
use Database\Seeders\V1\ActivityCategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserCategorySeeder::class);
        $this->call(UserRolesSeeder::class);
        $this->call(AccessType::class);
        $this->call(DistrictSeeder::class);
        $this->call(AreasSeeder::class);

        $this->call(DistrictAreasSeeder::class);
        $this->call(ChurchSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AssignedChurchLeaderSeeder::class);
        $this->call(ActivityCategorySeeder::class);

        $this->call(UserRoleAccessSeeder::class);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $this->call([
            UserSeeder::class,

            RankGroupSeeder::class,
            RankNameSeeder::class,
            RankItemSeeder::class,

            DepartmentSeeder::class,
            PositionSeeder::class,

            CharacterSeeder::class,

            StorySeeder::class,
        ]);

        activity()->enableLogging();
    }
}

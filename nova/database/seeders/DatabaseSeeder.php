<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected bool $useGenericSeeds = false;

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
        ]);

        // if ($this->useGenericSeeds) {
        //     $this->call([
        //         StorySeeder::class,
        //         PostSeeder::class,
        //     ]);
        // } else {
        //     $this->call([
        //         NimitzStorySeeder::class,
        //         NimitzPostSeeder::class,
        //     ]);
        // }

        activity()->enableLogging();
    }
}

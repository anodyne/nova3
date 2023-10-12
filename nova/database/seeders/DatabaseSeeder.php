<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $this->call([
            UserSeeder::class,
            NoteSeeder::class,

            RankGroupSeeder::class,
            RankNameSeeder::class,
            RankItemSeeder::class,

            DepartmentSeeder::class,
            PositionSeeder::class,

            CharacterSeeder::class,

            StorySeeder::class,
            // NimitzStorySeeder::class,
            PostSeeder::class,
        ]);

        activity()->enableLogging();
    }
}

<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        activity()->disableLogging();

        $this->call(UserSeeder::class);

        $this->call(RankGroupSeeder::class);
        $this->call(RankNameSeeder::class);
        $this->call(RankItemSeeder::class);

        $this->call(DepartmentSeeder::class);
        $this->call(PositionSeeder::class);

        $this->call(CharacterSeeder::class);

        $this->call(StorySeeder::class);

        activity()->enableLogging();
    }
}

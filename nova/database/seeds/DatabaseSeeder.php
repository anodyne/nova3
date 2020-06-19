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

        activity()->enableLogging();
    }
}

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
        $this->productionSeeders();

        $this->devSeeders();
    }

    protected function devSeeders()
    {
        if ($this->container->environment() === 'local') {
            $this->call(UserSeeder::class);
        }
    }

    protected function productionSeeders()
    {
        $this->call(PageSeeder::class);
        $this->call(ThemeSeeder::class);
    }
}

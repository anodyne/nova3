<?php

namespace Database\Seeders;

use Nova\Themes\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        activity()->disableLogging();

        Theme::factory()->count(10)->create();

        activity()->enableLogging();
    }
}

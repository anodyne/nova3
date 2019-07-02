<?php

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

        factory(Theme::class)->times(10)->create();

        activity()->enableLogging();
    }
}

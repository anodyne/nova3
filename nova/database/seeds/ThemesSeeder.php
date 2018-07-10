<?php

use Illuminate\Database\Seeder;
use Nova\Themes\Theme;

class ThemesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		factory(Theme::class)->states('pulsar')->create();
		factory(Theme::class)->times(4)->create();
    }
}

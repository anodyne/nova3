<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$this->call(PermissionsSeeder::class);
		$this->call(RolesSeeder::class);
		$this->call(GenreSeeder::class);
		$this->call(SettingsSeeder::class);

		if (app()->environment() == 'local') {
			$this->call(ThemesSeeder::class);
		}
    }
}

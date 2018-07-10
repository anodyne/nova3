<?php

use Nova\Pages\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$pages = [
			['name' => 'Home page', 'key' => 'home', 'uri' => '/', 'layout' => 'landing'],
			['name' => 'Sign In', 'key' => 'sign-in', 'uri' => 'sign-in', 'layout' => 'auth'],
		];

		Page::insert($pages);
	}
}

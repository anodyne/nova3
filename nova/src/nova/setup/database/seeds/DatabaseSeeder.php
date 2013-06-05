<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		
		$this->call('UserSeeder');
		$this->command->info('User seeding completed');

		$this->call('CharacterSeeder');
		$this->command->info('Character seeding completed');
	}

}
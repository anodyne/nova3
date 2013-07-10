<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		if (App::environment() == 'local')
		{
			// Make sure we don't run out of time
			set_time_limit(0);
			
			Eloquent::unguard();
			
			$this->call('UserSeeder');
			$this->command->info('User seeding completed');

			$this->call('CharacterSeeder');
			$this->command->info('Character seeding completed');

			//$this->call('ApplicationSeeder');
			//$this->command->info('ARC seeding completed');
		}
		else
		{
			$this->command->info("Database seeding is not available for this environment");
		}
	}

}
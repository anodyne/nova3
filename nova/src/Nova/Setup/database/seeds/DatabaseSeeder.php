<?php

class DatabaseSeeder extends Seeder {

	protected $seedUsers = false;
	protected $seedCharacters = false;
	protected $seedApplications = false;
	protected $seedForms = true;

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
			
			if ($this->seedUsers)
			{
				$this->call('UserSeeder');
				$this->command->info('User seeding completed');
			}

			if ($this->seedCharacters)
			{
				$this->call('CharacterSeeder');
				$this->command->info('Character seeding completed');
			}

			if ($this->seedApplications)
			{
				$this->call('ApplicationSeeder');
				$this->command->info('ARC seeding completed');
			}

			if ($this->seedForms)
			{
				$this->call('FormSeeder');
				$this->command->info('Dynamic form seeding completed');
			}
		}
		else
		{
			$this->command->info("Database seeding is not available for this environment");
		}
	}

}
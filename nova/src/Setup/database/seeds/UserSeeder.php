<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {

	public $userCount = 10;
	
	public function run()
	{
		$faker = \Faker\Factory::create();

		$userCreator = app('nova.userCreator');

		for ($i = 1; $i < $this->userCount; $i++)
		{
			$userCreator->create([
				'email' => $faker->safeEmail,
				'password' => 'password',
				'name' => $faker->name,
				'status' => $faker->numberBetween(1, 3),
			]);
		}
	}
}

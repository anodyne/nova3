<?php

class CharacterSeeder extends Seeder {

	protected $characterCount = 25;
	protected $userCount = 25;

	public function run()
	{
		$this->seedCharacters();
	}

	protected function seedCharacters()
	{
		// Create a new faker instance
		$faker = Faker\Factory::create();
		
		// Set the total count for the loop
		$total = $this->characterCount + 1;

		for ($i=2; $i <= $total; $i++)
		{ 
			// Create a new character
			$c = Character::create([
				'user_id'		=> $i,
				'first_name'	=> $faker->firstName,
				'last_name'		=> $faker->lastName,
				'rank_id'		=> rand(1, 150),
				'status'		=> User::find($i)->status,
			]);

			// Set the position
			$c->positions()->attach(rand(1, 78), ['primary' => (int) true]);
		}
	}

}
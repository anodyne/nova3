<?php

class CharacterSeeder extends Seeder {

	public function run()
	{
		$charNames = ['Melody Giddings', 'Barbara Cornwall', 'Alberta Shabazz', 'Alice Wiggins', 'Jacob Connors', 'Raymond Narvaez', 'Thomas Fletcher', 'Matt Pierre', 'Ellen Roland', 'Gregory Loeb', 'Mary Hendrix', 'Diana Herrick', 'Suzanne Green', 'Khalilah Gambrell', 'Mike Watson', 'Aimee Reed', 'Nicole Fontenot', 'Eugene Byler', 'Derrick Headrick', 'Walter Buenrostro', 'Armondo Foy', 'Isaac Gravitt', 'Arthur Hodges', 'Keith Shea', 'Gale Gould', 'Emily McCurry', 'Russell Anthony', 'Arthur Perry', 'Walter Greear', 'Amanda Jones', 'Grant Jaramillo', 'Dianne Soucy', 'Stella Olivares', 'Dominique Bogue', 'John Timmons', 'Brad Martini', 'Pauline Cook', 'Wendi Herb', 'Justin Spradlin', 'Dave Wilson', 'Shawn Noble', 'Nathan Williams', 'Frank Bess', 'Sarah Thompson', 'Edward Andrew', 'Kenneth Keffer', 'Deanna Gilmore', 'Francis Thornburg', 'Benjamin Roberson', 'James Dicky'];

		// Run the loop and create 25 characters
		for ($i=2; $i <= 26; $i++)
		{
			// Get a random character name
			$charKey = array_rand($charNames);

			// Get the character name
			$charName = explode(' ', $charNames[$charKey]);

			// Create a new character
			$c = Character::create([
				'user_id'		=> $i,
				'first_name'	=> $charName[0],
				'last_name'		=> $charName[1],
				'rank_id'		=> rand(1, 150),
				'status'		=> User::find($i)->status,
			]);

			// Set the position
			$c->positions()->attach(rand(1, 78), ['primary' => (int) true]);

			// Remove the used name
			unset($charNames[$charKey]);
		}
	}

}
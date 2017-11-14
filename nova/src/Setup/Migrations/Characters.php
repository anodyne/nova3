<?php namespace Nova\Setup\Migrations;

use Date;
use Status;
use Eloquent;
use Nova\Genres\Rank;
use Nova\Genres\Position;
use Nova\Characters\Character;

class Characters extends Migrator implements Migratable
{
	protected $users;
	protected $characters;
	protected $charactersDictionary;

	public function migrate()
	{
		// Grab all the characters from Nova 2
		$this->characters = $this->db->table('characters')->get();

		if (! $this->check()) {
			// Start the character dictionary
			$charactersDictionary = [];

			// Grab the users dictionary to use in the anonymous function
			$users = $this->users;

			// Get the Nova 2 genre
			$genre = config('nova2.genre');

			// Grab all of the positions from Nova 2
			$positions = $this->db->table("positions_{$genre}")->get();

			// Grab all of the ranks from Nova 2
			$ranks = $this->db->table("ranks_{$genre}")->get();

			// Because we're messing around with protected fields, we need
			// to unguard the Eloquent models
			Eloquent::unguard();

			// Grab the position and rank callbacks
			$assignPositions = $this->assignPositions();
			$assignRank = $this->assignRank();

			$this->characters->each(function ($character) use ($users, $positions, $ranks, &$charactersDictionary, $assignPositions, $assignRank) {
				// Grab the data from the user dictionary
				$user = array_get($users, "{$character->user}", null);

				// Build up an array of the names to combine into one field
				$nameArr = [
					$character->first_name,
					$character->middle_name,
					$character->last_name,
					$character->suffix
				];

				// Translate character status
				$status = ($character->crew_type == 'npc')
					? Status::ACTIVE
					: Status::toInt($character->crew_type);

				// Set the created_at field
				$createdAt = ($character->date_activate != 0)
					? Date::createFromTimeStampUTC($character->date_activate)
					: Date::now();

				// Create a new character with the old data
				$newCharacter = creator(Character::class)->with([
					'name' => implode(' ', array_filter($nameArr)),
					'user_id' => ($user !== null) ? $user['id'] : null,
					'status' => $status,
					'created_at' => $createdAt,
				])->create();

				// Figure out if we need to set the character as a main character
				if ($user !== null and $user['main_character'] == $character->charid) {
					$newCharacter->setAsPrimaryCharacter();
				}

				// Assign the position(s) to the new character
				$assignPositions($character, $newCharacter, $positions);

				// Assign the rank to the new character
				$assignRank($character, $newCharacter, $ranks);

				// Store the character info in the dictionary
				$charactersDictionary[$character->charid] = $newCharacter->id;
			});

			// Update the characters dictionary
			$this->characterDictionary = $charactersDictionary;

			// Turn the guarding back on for Eloquent models
			Eloquent::reguard();
		}

		return $this;
	}

	public function check()
	{
		return ((int)Character::count() === (int)$this->characters->count());
	}

	public function status()
	{
		if ($this->check()) {
			return ['status' => 'success', 'message' => ''];
		}

		return ['status' => 'failed', 'message' => 'All characters were not properly migrated.'];
	}

	public function getData()
	{
		// Grab the users dictionary from the session
		$this->users = session('nova2.users');

		return $this;
	}

	public function setData()
	{
		// Store the character dictionary in session
		session(['nova2.characters' => $this->charactersDictionary]);

		return $this;
	}

	protected function assignPositions()
	{
		return function ($oldCharacter, &$newCharacter, $positions) {
			// Create an array to track positions for syncing
			$newPositions = [];

			if (config('nova2.use_nova2_data') == 1) {
				// Get the positions dictionary out of session
				$positions = session('nova2.positions');

				if ($oldCharacter->position_1 != 0) {
					$newPositions[] = array_get($positions, $oldCharacter->position_1);
				}

				if ($oldCharacter->position_2 != 0) {
					$newPositions[] = array_get($positions, $oldCharacter->position_2);
				}
			} else {
				// Get the data of the first position
				$position1 = $positions->filter(function ($p) use ($oldCharacter) {
					return $p->pos_id == $oldCharacter->position_1;
				})->first();

				// Try to find the matching position in the new table
				$newPosition1 = Position::where('name', 'like', $position1->pos_name)->first();

				if ($newPosition1) {
					$newPositions[] = $newPosition1->id;
				}

				// Get the data of the second position
				if ($oldCharacter->position_2 != 0) {
					// Get the data of the second position
					$position2 = $positions->filter(function ($p) use ($oldCharacter) {
						return $p->pos_id == $oldCharacter->position_2;
					})->first();

					// Try to find the matching position in the new table
					$newPosition2 = Position::where('name', 'like', $position2->pos_name)->first();

					if ($newPosition2) {
						$newPositions[] = $newPosition2->id;
					}
				}
			}

			// Map the positions data to figure out what's the primary position
			$positionSync = collect($newPositions)->mapWithKeys(function ($p, $index) {
				return [$p => ['primary' => ($index == 0) ? (int) true : (int) false]];
			})->all();

			// Sync the positions to the pivot table
			$newCharacter->positions()->sync($positionSync);
		};
	}

	protected function assignRank()
	{
		return function ($oldCharacter, &$newCharacter, $ranks) {
			// Get the old rank image string
			$oldRank = $ranks->filter(function ($r) use ($oldCharacter) {
				return $r->rank_id == $oldCharacter->rank;
			})->first();

			// Create an array of pieces for the rank image
			$rankArr = explode('-', $oldRank->rank_image);

			// Make sure we have enough information to continue...
			if (count($rankArr) > 1) {
				// Pull out the individual pieces
				$color = $rankArr[0];
				// $grade = str_replace(substr($rankArr[1], strpos($rankArr[1], '.')), '', $rankArr[1]);
				$grade = $rankArr[1];

				// Find all ranks with the proper grade
				$newRanksWithGrade = Rank::where('overlay', 'like', "%{$grade}%")->get();

				// Find the rank that matches the color from Nova 2
				$newRank = $newRanksWithGrade->filter(function ($r) use ($color) {
					// Break the path to the base image at the directory separator
					$baseArr = explode('/', $r->base);

					// Get the last element of the base image array
					$image = end($baseArr);

					// We only need to check the first character of the image string
					return $image{0} == $color;
				})->first();

				if ($newRank) {
					// Assign the rank
					$newCharacter->update(['rank_id' => $newRank->id]);
				}
			}
		};
	}
}

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
		if (! $this->check()) {
			// Start the character dictionary
			$charactersDictionary = [];

			// Grab the users dictionary to use in the anonymous function
			$users = $this->users;

			// Get the Nova 2 genre
			$genre = config('nova2.genre');

			// Grab all of the positions from both systems
			$oldPositions = $this->db->table("positions_{$genre}")->get();
			$newPositions = Position::get();

			// Grab all of the ranks from both systems
			$oldRanks = $this->db->table("ranks_{$genre}")->get();
			$newRanks = Rank::get();

			// Because we're messing around with protected fields, we need
			// to unguard the Eloquent models
			Eloquent::unguard();

			// Grab the position and rank callbacks
			$assignPositions = $this->assignPositions();
			$assignRank = $this->assignRank();

			// We want to allow an update query if a record exists, but only once
			$allowUpdate = true;

			// Build up the query we need from Nova 2
			$query = $this->db->table('characters')->orderBy('charid');

			// Chunk the results into sections of 50
			$query->chunk(50, function ($characters) use ($users, $oldPositions, $oldRanks, $newPositions, $newRanks, &$charactersDictionary, $assignPositions, $assignRank, &$allowUpdate) {
					foreach ($characters as $character) {
						// Grab the data from the user dictionary
						$user = array_get($users, "{$character->user}", null);

						// Set the name of the character
						$name = htmlspecialchars_decode(implode(' ', array_filter([
							trim($character->first_name),
							trim($character->middle_name),
							trim($character->last_name),
							trim($character->suffix),
						])));

						// Translate character status
						$status = ($character->crew_type == 'npc')
							? Status::ACTIVE
							: Status::toInt($character->crew_type);

						// Set the created_at field
						$createdAt = ($character->date_activate != 0)
							? Date::createFromTimeStampUTC($character->date_activate)
							: Date::now();

						// Start with a null character object
						$newCharacter = null;

						// Are we allowed to do an update?
						if ($allowUpdate) {
							// See if we have a character by that name already
							$newCharacter = Character::where('name', $name)->first();

							// If we do, don't allow anymore updates
							if ($newCharacter) {
								$allowUpdate = false;
							}
						}

						// If we don't have a character, create a new one
						if ($newCharacter === null) {
							$newCharacter = new Character(['name' => $name]);
						}

						// Fill the character data with data from Nova 2
						$newCharacter->fill([
							'user_id' => ($user !== null) ? $user['id'] : null,
							'rank_id' => $assignRank($character, $oldRanks, $newRanks),
							'status' => $status,
							'created_at' => $createdAt,
						]);

						// And finally, save the character
						$newCharacter->save();

						// Figure out if we need to set the character as a main character
						if ($user !== null and $user['main_character'] == $character->charid) {
							$newCharacter->setAsPrimaryCharacter();
						}

						// Clear any positions we may have already for the character
						if ($newCharacter->positions->count() > 0) {
							$newCharacter->positions()->detach();
						}

						// Assign the position(s) to the new character
						$assignPositions($character, $newCharacter, $oldPositions, $newPositions);

						// Store the character info in the dictionary
						$charactersDictionary[$character->charid] = $newCharacter->id;
					}
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
		return ((int)Character::count() === (int)$this->db->table('characters')->count());
	}

	public function status()
	{
		if ($this->check()) {
			return ['status' => 'success', 'message' => ''];
		}

		$message = "%d of %d characters were migrated.";
		$newCount = (int)Character::count();
		$oldCount = (int)$this->characters->count();

		return [
			'status' => 'failed',
			'message' => sprintf($message, $newCount, $oldCount)
		];
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
		return function ($oldCharacter, &$newCharacter, $oldPositions, $newPositions) {
			// Create an array to track positions for syncing
			$newPositionsArr = [];

			if (config('nova2.use_nova2_data') == 1) {
				// Get the positions dictionary out of session
				$positions = session('nova2.positions');

				if ($oldCharacter->position_1 != 0) {
					$newPositionsArr[] = array_get($positions, $oldCharacter->position_1);
				}

				if ($oldCharacter->position_2 != 0) {
					$newPositionsArr[] = array_get($positions, $oldCharacter->position_2);
				}
			} else {
				// Get the data of the first position
				$position1 = $oldPositions->filter(function ($p) use ($oldCharacter) {
					return $p->pos_id == $oldCharacter->position_1;
				})->first();

				// Try to find the matching position in the new table
				$newPosition1 = $newPositions->where('name', $position1->pos_name)->first();

				if ($newPosition1) {
					$newPositionsArr[] = $newPosition1->id;
				}

				// Get the data of the second position
				if ($oldCharacter->position_2 != 0) {
					// Get the data of the second position
					$position2 = $oldPositions->filter(function ($p) use ($oldCharacter) {
						return $p->pos_id == $oldCharacter->position_2;
					})->first();

					// Try to find the matching position in the new table
					$newPosition2 = $newPositions->where('name', $position2->pos_name)->first();

					if ($newPosition2) {
						$newPositionsArr[] = $newPosition2->id;
					}
				}
			}

			// Map the positions data to figure out what's the primary position
			$positionSync = collect($newPositionsArr)->mapWithKeys(function ($p, $index) {
				return [$p => ['primary' => ($index == 0) ? (int) true : (int) false]];
			})->all();

			// Sync the positions to the pivot table
			$newCharacter->positions()->sync($positionSync);
		};
	}

	protected function assignRank()
	{
		return function ($oldCharacter, $oldRanks, $newRanks) {
			$oldRank = $oldRanks->filter(function ($r) use ($oldCharacter) {
				return $r->rank_id == $oldCharacter->rank;
			})->first();

			// Create an array of pieces for the rank image
			$rankArr = explode('-', $oldRank->rank_image);

			// Make sure we have enough information to continue...
			if (count($rankArr) > 1) {
				// Pull out the individual pieces
				$color = $rankArr[0];
				$grade = $rankArr[1];

				// Find all ranks with the proper grade
				$newRank = $newRanks->filter(function ($r) use ($grade) {
					return str_contains($r->overlay, $grade);
				})->filter(function ($r) use ($color) {
					// Break the path to the base image at the directory separator
					$baseArr = explode('/', $r->base);

					// Get the last element of the base image array
					$image = end($baseArr);

					// We only need to check the first character of the image string
					return $image{0} == $color;
				})->first();

				$oldRank = null;

				if ($newRank) {
					return $newRank->id;
				}

				return null;
			}
		};
	}
}

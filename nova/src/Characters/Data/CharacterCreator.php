<?php namespace Nova\Characters\Data;

use Str;
use Status;
use Nova\Characters\Events;
use Nova\Characters\Character;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Creatable;

class CharacterCreator implements Creatable
{
	use BindsData;

	protected $character;

	public function create()
	{
		// Create the character
		$character = $this->character = Character::create($this->data);

		// Handle anything related to positions with the character
		$character = $this->handlePositionUpdates($character);

		// Handle anything related to users with the character
		$character = $this->handleUserUpdates($character);

		// Fire any events we need to
		$this->fireEvents();

		return $character;
	}

	public function adminCreate()
	{
		// Make sure we set an active status on the character
		$this->with(['status' => Status::ACTIVE]);

		// Create the character
		$this->create();

		return $this->character;
	}

	protected function fireEvents()
	{
		//
	}

	protected function handlePositionUpdates(Character $character)
	{
		if (array_key_exists('positions', $this->data)) {
			// Map the positions data to figure out what's the primary position
			$positionSync = collect($this->data['positions'])->mapWithKeys(function ($p, $index) {
				return [$p => ['primary' => ($index == 0) ? (int) true : (int) false]];
			})->all();

			// Sync the positions to the pivot table
			$character->positions()->sync($positionSync);

			// Update position availability
			$character->fresh()->positions->each->removeAvailableSlot();
		}

		return $character->fresh();
	}

	protected function handleUserUpdates(Character $character)
	{
		// Get the assigned user
		$user = $character->user;

		// If the user doesn't have a primary character, set this one
		// as the primary character
		if ($user and ! $user->primaryCharacter) {
			$character->setAsPrimaryCharacter();
		}

		return $character->fresh();
	}
}

<?php namespace Nova\Characters\Data;

use Status;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Updatable;

class CharacterUpdater implements Updatable
{
	use BindsData;

	public function activate($character)
	{
		// Determine previous status
		$wasInactive = $character->isInactive();
		$wasPending = $character->isPending();

		// Update the character
		$character->update(['status' => Status::ACTIVE]);

		// Remove an available slot when activating the character
		$character->positions->each->removeAvailableSlot();

		if ($wasPending) {
			// Handle stuff that needs to happen when a pending character is
			// activated
		}

		if ($wasInactive) {
			// Handle stuff that needs to happen when a character was inactive
			// and is being re-activated
		}

		return $character->fresh();
	}

	public function deactivate($character)
	{
		// Update the character status
		$character->update(['status' => Status::INACTIVE]);

		// When a character is deactivated, add an available slot
		$character->positions->each->addAvailableSlot();

		// If the character is a user's primary character, reset their primary
		// character to something else
		if ($character->isPrimaryCharacter()) {
			$character->user->setPrimaryCharacter();
		}

		return $character->fresh();
	}

	public function update($character)
	{
		// Update the character
		$character->update($this->data);

		// Map the positions data to figure out what's the primary position
		$positionSync = collect($this->data['positions'])->mapWithKeys(function ($p, $index) {
			return [$p => ['primary' => ($index == 0) ? (int) true : (int) false]];
		})->all();

		// Sync the positions to the pivot table
		$character->positions()->sync($positionSync);

		// Add slots back in
		$this->data['old_positions']->each->addAvailableSlot();

		// Now sync them back up again
		$character->fresh()->positions->each->removeAvailableSlot();

		return $character->fresh();
	}
}

<?php namespace Nova\Characters\Data;

use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Updatable;

class CharacterUpdater implements Updatable
{
	use BindsData;

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

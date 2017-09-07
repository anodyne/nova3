<?php namespace Nova\Characters\Data;

use Status;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Deactivatable;

class CharacterDeactivator implements Deactivatable
{
	use BindsData;

	public function deactivate($character)
	{
		// Update the character status
		$character->update(['status' => Status::INACTIVE]);

		// If the character is a user's primary character, reset their primary
		// character to something else
		if ($character->isPrimaryCharacter()) {
			$this->character->user->setPrimaryCharacter();
		}

		// When a character is deactivated, add an available slot
		$character->positions->each->addAvailableSlot();

		return $character;
	}
}

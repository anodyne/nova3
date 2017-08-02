<?php namespace Nova\Characters\Data;

use Status;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Deletable;

class CharacterDeletor implements Deletable
{
	use BindsData;

	public function delete($character)
	{
		// Update the character status
		$character->update(['status' => Status::REMOVED]);

		// Delete the character
		$character->delete();

		return $character;
	}
}

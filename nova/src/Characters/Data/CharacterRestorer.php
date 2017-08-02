<?php namespace Nova\Characters\Data;

use Status;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Restorable;

class CharacterRestorer implements Restorable
{
	use BindsData;

	public function restore($character)
	{
		// Restore the character
		$character->restore();

		// Update their status
		$character->fresh()->update(['status' => Status::ACTIVE]);

		return $character->fresh();
	}
}

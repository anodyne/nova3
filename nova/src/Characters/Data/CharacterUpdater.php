<?php namespace Nova\Characters\Data;

use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Updatable;

class CharacterUpdater implements Updatable
{
	use BindsData;

	public function update($character)
	{
		$character->update($this->data);

		return $character->fresh();
	}
}

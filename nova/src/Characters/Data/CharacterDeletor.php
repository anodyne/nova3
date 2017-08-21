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

		// Delete any media the character has
		$character->media->each(function ($media) {
			deletor('Nova\Media\Media')->delete($media);
		});

		// TODO: when a character is deleted, we need to increment
		// the available positions

		// Delete the character
		$character->delete();

		return $character;
	}
}

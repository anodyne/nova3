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
}

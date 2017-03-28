<?php namespace Nova\Core\Characters;

use User;
use CharacterRepositoryContract;

class CharacterCreator
{
	protected $characterRepo;

	public function __construct(CharacterRepositoryContract $characters)
	{
		$this->characterRepo = $characters;
	}

	public function create(array $data, User $user = null)
	{
		// Create and return the character
		return $this->characterRepo->createForUser($data, $user);
	}
}

<?php namespace Nova\Core\Users;

use CharacterCreator, UserRepositoryContract;

class UserCreator {

	protected $userRepo;
	protected $characterCreator;

	public function __construct(UserRepositoryContract $users,
			CharacterCreator $creator)
	{
		$this->userRepo = $users;
		$this->characterCreator = $creator;
	}

	public function create(array $data)
	{
		// Hash the password
		$data['password'] = bcrypt($data['password']);

		// Create the user and return it
		return $this->userRepo->create(array_merge(
			$data,
			['api_token' => str_random(60)]
		));
	}

	public function createWithCharacter(array $data)
	{
		// Create the user
		$user = $this->create($data['user']);

		// Create the character
		$character = $this->characterCreator->create($data['character'], $user);

		if ($user and $character)
		{
			return true;
		}

		return false;
	}
}

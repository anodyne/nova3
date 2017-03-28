<?php namespace Nova\Core\Users;

use CharacterCreator;
use UserRepositoryContract;

class UserCreator
{
	protected $userRepo;
	protected $characterCreator;

	public function __construct(UserRepositoryContract $users, CharacterCreator $creator)
	{
		$this->userRepo = $users;
		$this->characterCreator = $creator;
	}

	public function create(array $data)
	{
		// Hash the password
		$data['password'] = bcrypt($data['password']);

		// Create the user
		$user = $this->userRepo->create(array_merge(
			$data,
			['api_token' => str_random(60)]
		));

		// Create the user's preferences
		app('PreferenceDefaultRepository')->all()->each(function ($default) use ($user) {
			app('UserPreferenceRepository')->create([
				'user_id' => $user->id,
				'key' => $default->key,
				'value' => $default->default,
			]);
		});

		return $user;
	}

	public function createWithCharacter(array $data)
	{
		// Create the user
		$user = $this->create($data['user']);

		// Create the character
		$character = $this->characterCreator->create($data['character'], $user);

		if ($user and $character) {
			return true;
		}

		return false;
	}
}

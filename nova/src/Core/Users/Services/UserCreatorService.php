<?php namespace Nova\Core\Users\Services;

use CharacterCreator,
	UserRepositoryContract;
use Nova\Core\Users\Events\UserCreated;
use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;

class UserCreatorService {

	protected $repo;
	protected $events;
	protected $characterCreator;

	public function __construct(UserRepositoryContract $users,
			CharacterCreator $creator,
			EventDispatcher $events)
	{
		$this->repo = $users;
		$this->events = $events;
		$this->characterCreator = $creator;
	}

	public function create(array $data)
	{
		$data['password'] = bcrypt($data['password']);

		return $this->repo->create(array_merge(
			$data,
			['api_token' => str_random(60)]
		));
	}

	public function createWithCharacter(array $data)
	{
		$data['user']['password'] = bcrypt($data['user']['password']);

		// Create the user
		$user = $this->repo->create(array_merge(
			$data['user'],
			['api_token' => str_random(60)]
		));

		// Create the character
		$character = $this->characterCreator->create($data['character'], $user);

		if ($user and $character)
		{
			return true;
		}

		return false;
	}
}

<?php namespace Nova\Core\Characters\Services;

use User, CharacterRepositoryContract;
use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;

class CharacterCreatorService {

	protected $repo;
	protected $events;

	public function __construct(CharacterRepositoryContract $characters,
			EventDispatcher $events)
	{
		$this->repo = $characters;
		$this->events = $events;
	}

	public function create(array $data, User $user = null)
	{
		// Create the character
		$character = $this->repo->createForUser($data, $user);

		// Fire the event
		$this->events->fire('nova.character.created', [$character]);

		return $character;
	}

}

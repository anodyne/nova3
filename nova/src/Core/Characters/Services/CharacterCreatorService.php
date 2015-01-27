<?php namespace Nova\Core\Characters\Services;

use CharacterRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;

class CharacterCreatorService {

	protected $repo;
	protected $events;

	public function __construct(CharacterRepositoryInterface $characters,
			EventDispatcher $events)
	{
		$this->repo = $characters;
		$this->events = $events;
	}

	public function create(array $data, User $user = null)
	{
		// Create the character
		$character = $this->repo->create($data, $user);

		// Fire the event
		$this->events->fire('nova.character.created', [$character]);

		return $character;
	}

}

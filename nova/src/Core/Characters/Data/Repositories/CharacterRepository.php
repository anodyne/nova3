<?php namespace Nova\Core\Characters\Data\Repositories;

use User,
	Character as Model,
	CharacterRepositoryInterface;
use Nova\Foundation\Data\Repositories\BaseRepository;

class CharacterRepository extends BaseRepository implements CharacterRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function createForUser(array $data, User $user = null)
	{
		$character = $this->create($data);

		if ($user)
		{
			// Associate the character to the user
			$user->characters()->save($character);
		}

		return $character;
	}

}
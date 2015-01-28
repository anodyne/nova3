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

	public function create(array $data, User $user = null)
	{
		// Create the character record
		$character = $this->model->create($data);

		if ($user)
		{
			// Associate the character to the user
			$user->characters()->save($character);

			// Save the user
			$user->save();
		}

		return $character;
	}

}
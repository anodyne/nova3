<?php namespace Nova\Core\Users\Data\Repositories;

use User as Model,
	UserRepositoryContract;
use Nova\Core\Users\Events;
use Nova\Foundation\Data\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryContract {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function create(array $data)
	{
		$role = (array_key_exists('role', $data)) ? (int) $data['role'] : null;

		unset($data['role']);

		$user = $this->model->create($data);

		if ($role)
		{
			$user->assignRole($role);
		}

		event(new Events\UserCreated($user));

		return $user;
	}

}

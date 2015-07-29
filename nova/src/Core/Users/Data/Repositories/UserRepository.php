<?php namespace Nova\Core\Users\Data\Repositories;

use User as Model,
	UserRepositoryInterface;
use Nova\Foundation\Data\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function create(array $data)
	{
		$role = (array_key_exists('role', $data)) ? $data['role'] : null;

		unset($data['role']);

		$user = $this->model->create($data);

		if ($role)
		{
			$user->attachRole($role);
		}

		return $user;
	}

}
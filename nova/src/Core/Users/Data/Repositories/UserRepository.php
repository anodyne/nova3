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
		return $this->model->create($data);
	}

}
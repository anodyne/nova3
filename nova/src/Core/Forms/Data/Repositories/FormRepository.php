<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaForm as Model,
	FormRepositoryInterface;
use Nova\Foundation\Data\Repositories\BaseRepository;

class FormRepository extends BaseRepository implements FormRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function find($id)
	{
		return $this->getById($id);
	}

	public function findByKey($key)
	{
		return $this->findFirstBy('key', $key);
	}

}

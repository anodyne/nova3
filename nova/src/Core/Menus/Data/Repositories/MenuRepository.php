<?php namespace Nova\Core\Menus\Data\Repositories;

use Menu as Model,
	MenuRepositoryInterface;
use Nova\Foundation\Data\Repositories\BaseRepository;

class MenuRepository extends BaseRepository implements MenuRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function find($id)
	{
		return $this->getById($id, ['menuItems']);
	}

}

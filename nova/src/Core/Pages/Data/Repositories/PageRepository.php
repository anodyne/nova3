<?php namespace Nova\Core\Pages\Data\Repositories;

use Page as Model,
	PageRepositoryInterface;
use Illuminate\Routing\Route;
use Nova\Foundation\Data\Repositories\BaseRepository;

class PageRepository extends BaseRepository implements PageRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function getByRoute(Route $route, $parameter = 'name')
	{
		return $this->getFirstBy($parameter, $route->get{ucfirst($parameter)});
	}

}
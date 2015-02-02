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

	public function create(array $data)
	{
		return $this->model->create($data);
	}

	public function getByRouteName(Route $route)
	{
		return $this->getFirstBy('name', $route->getName());
	}

	public function getByRouteUri(Route $route)
	{
		return $this->getFirstBy('uri', $route->getUri());
	}

}
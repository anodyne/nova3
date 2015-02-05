<?php namespace Nova\Core\Pages\Data\Repositories;

use PageContent as Model,
	PageContentRepositoryInterface;
use Nova\Foundation\Data\Repositories\BaseRepository;

class PageContentRepository extends BaseRepository implements PageContentRepositoryInterface {

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

<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaFormTab as Model,
	NovaFormTabRepositoryInterface;
use Nova\Foundation\Data\Repositories\BaseRepository;

class TabRepository extends BaseRepository implements NovaFormTabRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

}

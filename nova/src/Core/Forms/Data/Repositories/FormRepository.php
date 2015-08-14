<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaForm as Model,
	NovaFormRepositoryInterface;
use Nova\Foundation\Data\Repositories\BaseRepository;

class FormRepository extends BaseRepository implements NovaFormRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

}

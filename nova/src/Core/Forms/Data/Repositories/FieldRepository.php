<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaFormField as Model,
	NovaFormFieldRepositoryInterface;
use Nova\Foundation\Data\Repositories\BaseRepository;

class FieldRepository extends BaseRepository implements NovaFormFieldRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

}

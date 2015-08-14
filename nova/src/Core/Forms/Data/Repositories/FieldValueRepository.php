<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaFormFieldValue as Model,
	NovaFormFieldValueRepositoryInterface;
use Nova\Foundation\Data\Repositories\BaseRepository;

class FieldValueRepository extends BaseRepository implements NovaFormFieldValueRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

}

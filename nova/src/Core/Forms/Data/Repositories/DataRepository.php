<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaFormData as Model,
	FormDataRepositoryInterface;

class DataRepository extends BaseFormRepository implements FormDataRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

}

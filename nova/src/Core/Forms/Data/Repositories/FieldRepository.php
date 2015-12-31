<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaForm,
	NovaFormField as Model,
	FormFieldRepositoryInterface;

class FieldRepository extends BaseFormRepository implements FormFieldRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

}

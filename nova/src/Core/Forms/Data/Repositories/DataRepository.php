<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaFormData as Model;
use FormDataRepositoryContract;

class DataRepository extends BaseFormRepository implements FormDataRepositoryContract
{
	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}
}

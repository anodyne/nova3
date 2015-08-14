<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaFormSection as Model,
	NovaFormSectionRepositoryInterface;
use Nova\Foundation\Data\Repositories\BaseRepository;

class SectionRepository extends BaseRepository implements NovaFormSectionRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

}

<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaForm,
	NovaFormTab as Model,
	FormTabRepositoryInterface;
use Nova\Foundation\Data\Repositories\BaseRepository;

class TabRepository extends BaseRepository implements FormTabRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function getFormTabs(NovaForm $form)
	{
		return $form->tabs->sortBy('order');
	}

}

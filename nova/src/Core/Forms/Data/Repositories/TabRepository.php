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

	public function countLinkIds(NovaForm $form, $linkId)
	{
		if ( ! $form->tabs) return 0;

		return $form->tabs->filter(function ($tab) use ($linkId)
		{
			return $tab->link_id === $linkId;
		})->count();
	}

	public function find($id)
	{
		return $this->getById($id);
	}

	public function getFormTabs(NovaForm $form)
	{
		return $form->tabs->sortBy('order');
	}

}

<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaForm,
	NovaFormSection as Model,
	FormSectionRepositoryInterface;
use Nova\Foundation\Data\Repositories\BaseRepository;

class SectionRepository extends BaseRepository implements FormSectionRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function getBoundSections(NovaForm $form)
	{
		return $form->sections->filter(function ($section)
		{
			return (int) $section->tab_id > 0;
		});
	}

	public function getUnboundSections(NovaForm $form)
	{
		return $form->sections->filter(function ($section)
		{
			return $section->tab_id === null or (int) $section->tab_id === 0;
		})->sortBy('order');
	}

}

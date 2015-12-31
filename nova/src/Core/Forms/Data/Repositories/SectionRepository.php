<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaForm,
	NovaFormSection as Model,
	FormSectionRepositoryInterface;

class SectionRepository extends BaseFormRepository implements FormSectionRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function delete($resource)
	{
		// Get the resource
		$section = $this->getResource($resource);

		if ($section)
		{
			$section->fields->each(function ($field)
			{
				$field->data->each(function ($d)
				{
					$d->delete();
				});

				$field->values->each(function ($value)
				{
					$value->delete();
				});

				$field->delete();
			});

			$section->delete();

			return $section;
		}

		return false;
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

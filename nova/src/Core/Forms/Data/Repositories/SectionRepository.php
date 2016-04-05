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

	public function reassignSectionContent(Model $oldSection, $newSectionId)
	{
		// Reassign any fields
		$oldSection->fields->each(function ($field) use ($newSectionId)
		{
			$field->update(['section_id' => $newSectionId]);
		});
	}

	public function removeSectionContent(Model $section)
	{
		// Remove any fields
		$section->fields->each(function ($field)
		{
			// First remove any data associated with the field
			$field->data->each(function ($row)
			{
				$row->delete();
			});

			// Now delete the field
			$field->delete();
		});
	}

}

<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaForm,
	NovaFormSection as Model,
	FormSectionRepositoryContract;

class SectionRepository extends BaseFormRepository implements FormSectionRepositoryContract {

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

	public function getUnboundSections(NovaForm $form, array $relations = [], $allSections = false)
	{
		$relationship = ($allSections) ? 'sectionsUnboundAll' : 'sectionsUnbound';

		return $form->{$relationship}->load($relations);
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

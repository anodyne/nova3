<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaForm,
	NovaFormSection as Model,
	FormSectionRepositoryContract;
use Nova\Core\Forms\Events;

class SectionRepository extends BaseFormRepository implements FormSectionRepositoryContract {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function create(array $data)
	{
		$section = parent::create($data);

		event(new Events\FormSectionCreated($section));

		return $section;
	}

	public function delete($resource)
	{
		$section = parent::delete($resource);

		event(new Events\FormSectionDeleted($section->id, $section->name, $section->form->key));

		return $section;
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
			app('FormFieldRepository')->update($field, ['section_id' => $newSectionId]);
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
			app('FormFieldRepository')->delete($field);
		});
	}

	public function update($resource, array $data)
	{
		$section = parent::update($resource);

		event(new Events\FormSectionUpdated($section));

		return $section;
	}

	public function updateOrder($resource, $newOrder)
	{
		$section = parent::updateOrder($resource, $newOrder);

		event(new Events\FormSectionOrderUpdated($section));

		return $section;
	}

}

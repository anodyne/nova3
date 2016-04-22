<?php namespace Nova\Core\Forms\Data\Repositories;

use User,
	NovaForm as Model,
	FormRepositoryContract;

class FormRepository extends BaseFormRepository implements FormRepositoryContract {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	/**
	 * We need to modify the way we create a form to allow for handling
	 * access restrictions being stored as JSON in the database.
	 */
	public function create(array $data)
	{
		// Clean up the data
		$data = $this->cleanFieldValues($data);

		// Now create the form
		$form = parent::create($data);

		return $form;
	}

	public function delete($resource)
	{
		// Get the resource
		$form = $this->getResource($resource, 'key');

		if ($form)
		{
			// First, remove all the data
			$form->data->each(function ($data)
			{
				$data->delete();
			});

			// Remove all the fields
			$form->fields->each(function ($field)
			{
				// First remove all the field values
				$field->values->each(function ($value)
				{
					$value->delete();
				});

				// Now we can delete the field
				$field->delete();
			});

			// Remove all the sections
			$form->sections->each(function ($section)
			{
				$section->delete();
			});

			// Remove all the tabs
			$form->tabs->each(function ($tab)
			{
				$tab->delete();
			});

			// Finally, remove the form
			$form->delete();

			return $form;
		}

		return false;
	}

	public function getByKey($key, array $with = [])
	{
		return $this->getFirstBy('key', $key, $with);
	}

	public function getFormCenterForms(array $with = [])
	{
		return $this->getManyBy('use_form_center', (int) true, $with);
	}

	public function getParentTabs(Model $form, array $relations = [], $allTabs = false)
	{
		$relationship = ($allTabs) ? 'parentTabsAll' : 'parentTabs';

		return $form->{$relationship}->load($relations);
	}

	public function getTabs(Model $form, array $relations = [], $allTabs = false)
	{
		$relationship = ($allTabs) ? 'tabsAll' : 'tabs';

		return $form->{$relationship}->load($relations);
	}

	public function getUnboundFields(Model $form, array $relations = [], $allFields = false)
	{
		$relationship = ($allFields) ? 'fieldsUnboundAll' : 'fieldsUnbound';

		return $form->{$relationship}->load($relations);
	}

	public function getUnboundSections(Model $form, array $relations = [], $allSections = false)
	{
		$relationship = ($allSections) ? 'sectionsUnboundAll' : 'sectionsUnbound';

		return $form->{$relationship}->load($relations);
	}

	public function getValidationRules(Model $form)
	{
		// Get all the fields
		$fields = $form->fields;

		if ($fields)
		{
			$rulesArr = [];

			foreach ($fields as $field)
			{
				if (count($field->validation_rules) > 0)
				{
					$fieldName = sprintf(config('nova.forms.fieldNameFormat'), $field->id);

					$rulesArr[$fieldName] = $field->validationRules();
				}
			}

			return $rulesArr;
		}

		return false;
	}

	/**
	 * We need to modify the way we update a form to allow for handling
	 * access restrictions being stored as JSON in the database.
	 */
	public function update($resource, array $data)
	{
		// Clean up the data
		$data = $this->cleanFieldValues($data);

		// Now update the form
		$form = parent::update($resource, $data);

		return $form;
	}

	protected function cleanFieldValues(array $data)
	{
		// Handle restrictions
		if (array_key_exists('restrictionValues', $data))
		{
			foreach ($data['restrictionValues'] as $type => $value)
			{
				$data['restrictions'][] = [
					'type' => $type,
					'value' => $value,
				];
			}

			unset($data['restrictionValues']);
		}

		return $data;
	}

}

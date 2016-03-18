<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaForm as Model,
	FormRepositoryInterface;;

class FormRepository extends BaseFormRepository implements FormRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
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

	public function getTabs(Model $form, array $relations = [])
	{
		return $form->tabs->filter(function ($tab)
		{
			return (int) $tab->parent_id === 0;
		})->sortBy('order')->load($relations);
	}

	public function getUnboundFields(Model $form, array $relations = [])
	{
		return $form->fields->filter(function ($field)
		{
			return (int) $field->tab_id === 0 and (int) $field->section_id === 0;
		})->sortBy('order')->load($relations);
	}

	public function getUnboundSections(Model $form, array $relations = [])
	{
		return $form->sections->filter(function ($section)
		{
			return (int) $section->tab_id === 0;
		})->sortBy('order')->load($relations);
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

}

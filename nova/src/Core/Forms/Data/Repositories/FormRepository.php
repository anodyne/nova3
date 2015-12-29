<?php namespace Nova\Core\Forms\Data\Repositories;

use NovaForm as Model,
	FormRepositoryInterface;
use Nova\Foundation\Data\Repositories\BaseRepository;

class FormRepository extends BaseRepository implements FormRepositoryInterface {

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

	public function find($id)
	{
		return $this->getById($id);
	}

	public function findByKey($key, array $with = [])
	{
		return $this->getFirstBy('key', $key, $with);
	}

}

<?php namespace Nova\Core\Forms\Data\Repositories;

use User,
	NovaForm,
	NovaFormData,
	NovaFormEntry as Model,
	FormDataRepositoryContract,
	FormEntryRepositoryContract,
	FormFieldRepositoryContract;

class EntryRepository extends BaseFormRepository implements FormEntryRepositoryContract {

	protected $model;
	protected $dataRepo;
	protected $fieldRepo;

	public function __construct(Model $model, FormDataRepositoryContract $data,
			FormFieldRepositoryContract $field)
	{
		$this->model = $model;
		$this->dataRepo = $data;
		$this->fieldRepo = $field;
	}

	public function delete($resource)
	{
		$item = $this->getResource($resource);

		if ($item)
		{
			// Remove all the data
			$item->data->each(function ($d)
			{
				$d->delete();
			});

			// Remove the entry
			$item->delete();

			return $item;
		}

		return false;
	}

	public function getFormEntries(NovaForm $form)
	{
		return $form->entries;
	}

	public function getUserEntries(User $user, $form = null)
	{
		$entries = $user->formCenterEntries->load(['form', 'data']);

		if ($form)
		{
			$entries = $entries->where('form_id', $form->id);
		}

		return $entries->sortByDesc('created_at');
	}

	public function insert(NovaForm $form, $user, array $data)
	{
		// Insert an entry record
		$entry = new Model;
		$entry->form()->associate($form);

		if ($user)
		{
			$entry->user()->associate($user);
		}
		else
		{
			$entry->ip_address = app('request')->ip();
		}

		$entry->save();

		// We don't want the CSRF token in here
		unset($data['_token']);

		foreach ($data as $field => $value)
		{
			// Get just the field ID out of the field name
			preg_match('!\d+!', $field, $matches);
			$fieldId = $matches[0];

			if (is_numeric($fieldId))
			{
				$this->dataRepo->create([
					'form_id' => $form->id,
					'field_id' => $fieldId,
					'user_id' => ($user) ? $user->id : null,
					'entry_id' => $entry->id,
					'value' => $value,
				]);
			}
		}

		return $entry;
	}

	public function update($id, array $data)
	{
		// Get the entry
		$entry = $this->getById($id);

		unset($data['_method']);
		unset($data['_token']);

		foreach ($data as $field => $value)
		{
			// Get just the field ID out of the field name
			preg_match('!\d+!', $field, $matches);
			$fieldId = $matches[0];

			if (is_numeric($fieldId))
			{
				// Set the attributes for finding the record
				$attributes = [
					'form_id' => $entry->form_id,
					'field_id' => $fieldId,
					'entry_id' => $entry->id,
					'user_id' => $entry->user_id,
				];

				// Set the values for updating/creating the record
				$values = [
					'form_id' => $entry->form_id,
					'field_id' => $fieldId,
					'entry_id' => $entry->id,
					'user_id' => $entry->user_id,
					'value' => $value,
				];

				$this->dataRepo->getModel()->updateOrCreate($attributes, $values);
			}
		}

		return $entry;
	}

}

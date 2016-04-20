<?php namespace Nova\Core\Forms\Data\Repositories;

use User,
	NovaForm,
	NovaFormEntry as Model,
	FormDataRepositoryInterface,
	FormEntryRepositoryInterface,
	FormFieldRepositoryInterface;

class EntryRepository extends BaseFormRepository implements FormEntryRepositoryInterface {

	protected $model;
	protected $dataRepo;
	protected $fieldRepo;

	public function __construct(Model $model, FormDataRepositoryInterface $data,
			FormFieldRepositoryInterface $field)
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
				$dataRecord = $this->dataRepo->create([
					'field_id' => $fieldId,
					'value' => $value,
				]);

				// Associate the form, entry, and user with the record
				$dataRecord->form()->associate($form);
				$dataRecord->user()->associate($user);
				$dataRecord->entry()->associate($entry);

				// Re-save the record so we keep the associations
				$dataRecord->save();
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
				$dataRecord = $entry->data->whereLoose('field_id', $fieldId);

				if ($dataRecord->count() > 0)
				{
					$dataRecord->first()->update(['value' => $value]);
				}
				else
				{
					$this->dataRepo->create([
						'form_id' => $entry->form_id,
						'field_id' => $fieldId,
						'entry_id' => $entry->id,
						'user_id' => $entry->user_id,
						'value' => $value,
					]);
				}
			}
		}

		return $entry;
	}

}

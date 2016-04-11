<?php namespace Nova\Core\Forms\Data\Repositories;

use User,
	NovaForm,
	NovaFormEntry as Model,
	FormDataRepositoryInterface,
	FormEntryRepositoryInterface;

class EntryRepository extends BaseFormRepository implements FormEntryRepositoryInterface {

	protected $model;
	protected $dataRepo;

	public function __construct(Model $model, FormDataRepositoryInterface $data)
	{
		$this->model = $model;
		$this->dataRepo = $data;
	}

	public function getUserEntries(User $user, $form = null)
	{
		$entries = $user->formCenterEntries;

		if ($form)
		{
			$entries = $entries->where('form_id', $form->id);
		}

		return $entries;
	}

	public function insert(NovaForm $form, User $user, array $data)
	{
		// Insert an entry record
		$entry = new Model;
		$entry->form()->associate($form);
		$entry->user()->associate($user);
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

}

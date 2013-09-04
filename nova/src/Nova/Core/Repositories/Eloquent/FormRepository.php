<?php namespace Nova\Core\Repositories\Eloquent;

use NovaForm;
use NovaFormData;
use SecurityTrait;
use FormProtectedException;
use FormRepositoryInterface;

class FormRepository implements FormRepositoryInterface {

	use SecurityTrait;

	/*
	|--------------------------------------------------------------------------
	| BaseRepositoryInterface Implementation
	|--------------------------------------------------------------------------
	*/

	/**
	 * Get everything out of the database.
	 *
	 * @return	Collection
	 */
	public function all()
	{
		return NovaForm::all();
	}
	
	/**
	 * Create a new item.
	 *
	 * @param	array	$data	Data to use for creation
	 * @return	Form
	 */
	public function create(array $data)
	{
		return NovaForm::create($data);
	}

	/**
	 * Delete an item.
	 *
	 * @param	int		$id		ID to delete
	 * @return	bool
	 */
	public function delete($id)
	{
		$id = $this->sanitizeInt($id);

		// Get the form
		$item = $this->find($id);

		if ($item)
		{
			if ($item->protected)
				throw new FormProtectedException;

			return $item->delete();
		}

		return false;
	}

	/**
	 * Find an item by ID.
	 *
	 * @param	int		$id		ID to find
	 * @return	object
	 */
	public function find($id)
	{
		$id = $this->sanitizeInt($id);

		return NovaForm::find($id);
	}

	/**
	 * Update an item.
	 *
	 * @param	int		$id		ID to update
	 * @param	array	$data	Data to use for update
	 * @return	object
	 */
	public function update($id, array $data)
	{
		$id = $this->sanitizeInt($id);

		// Get the form
		$item = $this->find($id);

		if ($item)
			return $item->update($data);

		return false;
	}

	/*
	|--------------------------------------------------------------------------
	| FormRepositoryInterface Implementation
	|--------------------------------------------------------------------------
	*/

	/**
	 * Create a form field.
	 *
	 * @param	array	$data	Data to use for creating the field
	 * @param	Form	$form	The Form object
	 * @return	Form
	 */
	public function createField(array $data, $form)
	{
		// Create the field
		$newField = $form->fields()->getModel()->newInstance($data);

		// Attach the field to the form
		$item = $form->fields()->save($newField);

		if (array_key_exists('field_values', $data))
		{
			// Break the values into an array
			$valuesArr = explode(',', $data['field_values']);

			foreach ($valuesArr as $key => $value)
			{
				// Create a new form value for this field
				$newValue = $item->values()->getModel()->newInstance([
					'value' => e(trim($value)),
					'order' => $key
				]);
				$item->values()->save($newValue);
			}
		}

		return $item;
	}

	/**
	 * Create a new FormViewer entry.
	 *
	 * @param	int		$id				The data ID to use
	 * @param	array	$data			Data to use creating the entry
	 * @param	Form	$form			Form object
	 * @param	User	$currentUser	The current user
	 * @return	void
	 */
	public function createFormViewerEntry($id, array $data, $form, $currentUser)
	{
		$id = $this->sanitizeInt($id);

		if ( ! $id)
			return false;

		// If we're creating a new entry, we need to figure out what the ID should be
		if ((int) $id === 0)
		{
			// Get all entries and order them by data ID
			$entries = $this->getFormViewerDataEntries($form);

			if ($entries->count() > 0)
			{
				// Grab the last entry in the collection
				$lastEntry = $entries->last();

				// Increment the data ID
				$id = (int) $lastEntry->data_id + 1;
			}
			else
			{
				$id = 1;
			}
		}

		foreach ($data as $field => $value)
		{
			if (is_numeric($field))
			{
				NovaFormData::create([
					'form_id'		=> $form->id,
					'field_id'		=> $field,
					'data_id'		=> $id,
					'value'			=> trim(e($value)),
					'created_by'	=> $currentUser->id,
				]);
			}
		}
	}

	/**
	 * Create a form section.
	 *
	 * @param	array	$data	Data to use for creating the section
	 * @param	Form	$form	The Form object
	 * @return	Form
	 */
	public function createSection(array $data, $form)
	{
		// Create the section
		$newSection = $form->sections()->getModel()->newInstance($data);
		
		// Attach it to the form
		return $form->sections()->save($newSection);
	}

	/**
	 * Create a form tab.
	 *
	 * @param	array	$data	Data to use for creating the tab
	 * @param	Form	$form	The Form object
	 * @return	Form
	 */
	public function createTab(array $data, $form)
	{
		// Create the tab
		$newTab = $form->tabs()->getModel()->newInstance($data);

		// Attach it to the form
		return $form->tabs()->save($newTab);
	}

	/**
	 * Delete a form field.
	 *
	 * @param	int		$id		Field ID to delete
	 * @param	Form	$form	The Form object
	 * @return	bool
	 */
	public function deleteField($id, $form)
	{
		$id = $this->sanitizeInt($id);

		// Get the field
		$item = $form->fields()->find($id);

		if ($item)
			return $item->delete();

		return false;
	}

	/**
	 * Delete a FormViewer entry.
	 *
	 * @param	int		$id		Data ID to delete
	 * @param	Form	$form	The Form object
	 * @return	bool
	 */
	public function deleteFormViewerEntry($id, $form)
	{
		$id = $this->sanitizeInt($id);

		// Get the entries
		$entries = NovaFormData::key($form->key)->entry($id)->get();

		if ($entries->count() > 0)
		{
			foreach ($entries as $entry)
			{
				$entry->delete();
			}
		}
	}

	/**
	 * Delete a form section.
	 *
	 * @param	int		$id		Section ID to delete
	 * @param	int		$newId	New section to use
	 * @param	Form	$form	The Form object
	 * @return	bool
	 */
	public function deleteSection($id, $newId, $form)
	{
		$id = $this->sanitizeInt($id);

		// Get the section
		$item = $form->sections()->find($id);

		if ($item)
		{
			// Sanitize the new ID
			$newId = $this->sanitizeInt($newId);

			if ( ! $newId)
				return false;

			if ($item->fields->count() > 0)
			{
				foreach ($item->fields as $field)
				{
					$field->update(['section_id' => $newId]);
				}
			}

			return $item->delete();
		}

		return false;
	}

	/**
	 * Delete a form tab.
	 *
	 * @param	int		$id		Tab ID to delete
	 * @param	int		$newId	New tab to use
	 * @param	Form	$form	The Form object
	 * @return	bool
	 */
	public function deleteTab($id, $newId, $form)
	{
		$id = $this->sanitizeInt($id);

		// Get the tab
		$item = $form->tabs()->find($id);

		if ($item)
		{
			// Sanitize the new ID
			$newId = $this->sanitizeInt($newId);

			if ( ! $newId)
				return false;

			if ($item->sections->count() > 0)
			{
				foreach ($item->sections as $section)
				{
					$section->update(['tab_id' => $newId]);
				}
			}

			return $item->delete();
		}

		return false;
	}

	/**
	 * Find a form by its form key.
	 *
	 * @param	string	$key	The form key
	 * @return	Form
	 */
	public function findByKey($key)
	{
		$key = $this->sanitizeString($key);

		return NovaForm::key($key)->first();
	}

	/**
	 * Get a form's data entries.
	 *
	 * @param	Form	$form	Form object
	 * @return	Collection
	 */
	public function getFormViewerDataEntries($form)
	{
		return NovaFormData::key($form->key)->orderAsc('data_id')->get();
	}

	/**
	 * Get a specific FormViewer entry.
	 *
	 * @param	int		$id		Data entry to get
	 * @param	Form	$form	Form object
	 */
	public function getFormViewerEntry($id, $form)
	{
		$id = $this->sanitizeInt($id);

		if ( ! $id)
			return false;

		return NovaFormData::key($form->key)->entry($id)->first();
	}

	/**
	 * Get a form's data entries as a paginated result set.
	 *
	 * @param	Form	$form		Form object
	 * @param	int		$perPage	Number of results per page
	 * @return	Collection
	 */
	public function getPaginatedFormViewerEntries($form, $perPage = 50)
	{
		// Start grabbing the entries
		$entries = NovaFormData::key($form->key)->group('data_id')->orderDesc('created_at');

		// Make sure we take into account what we want to use as a display
		if ((int) $form->form_viewer_display > 0)
		{
			$entries = $entries->where('field_id', $form->form_viewer_display);
		}

		return $entries->paginate($perPage);
	}

	/**
	 * Update a form field.
	 *
	 * @param	int		$id		Field ID to update
	 * @param	array	$data	Data to use for the update
	 * @param	Form	$form	The Form object
	 * @return	Form
	 */
	public function updateField($id, array $data, $form)
	{
		$id = $this->sanitizeInt($id);

		// Get the field
		$item = $form->fields()->find($id);

		if ($item)
			return $item->update($data);

		return false;
	}

	/**
	 * Update a FormViewer entry.
	 *
	 * @param	int		$id		The data ID to use
	 * @param	array	$data	Data to use updating the entry
	 * @param	Form	$form	Form object
	 * @return	void
	 */
	public function updateFormViewerEntry($id, array $data, $form)
	{
		$id = $this->sanitizeInt($id);

		if ( ! $id)
			return false;

		foreach ($data as $field => $value)
		{
			if (is_numeric($field))
			{
				$data = NovaFormData::key($form->key)->entry($id)->formField($field)->first();
				$data->update(['value' => trim(e($value))]);
			}
		}
	}

	/**
	 * Update a form section.
	 *
	 * @param	int		$id		Section ID to update
	 * @param	array	$data	Data to use for the update
	 * @param	Form	$form	The Form object
	 * @return	Form
	 */
	public function updateSection($id, array $data, $form)
	{
		$id = $this->sanitizeInt($id);

		// Get the section
		$item = $form->sections()->find($id);

		if ($item)
			return $item->update($data);

		return false;
	}

	/**
	 * Update a form tab.
	 *
	 * @param	int		$id		Tab ID to update
	 * @param	array	$data	Data to use for the update
	 * @param	Form	$form	The Form object
	 * @return	Form
	 */
	public function updateTab($id, array $data, $form)
	{
		$id = $this->sanitizeInt($id);

		// Get the tab
		$item = $form->tabs()->find($id);

		if ($item)
			return $item->update($data);

		return false;
	}

}
<?php namespace Nova\Core\Repositories\Eloquent;

use FormModel;
use FormTabModel;
use UtilityTrait;
use FormDataModel;
use SecurityTrait;
use FormFieldModel;
use FormValueModel;
use FormSectionModel;
use FormProtectedException;
use FormRepositoryInterface;

class FormRepository implements FormRepositoryInterface {

	use UtilityTrait;
	use SecurityTrait;

	/**
	 * Get all the forms.
	 *
	 * @return	Collection
	 */
	public function all()
	{
		return FormModel::all();
	}

	/**
	 * Check that an item is actually part of the requested form.
	 *
	 * @param	object	$item		The item being checked
	 * @param	string	$formKey	Form key
	 * @return	bool
	 */
	public function checkItemForm($item, $formKey)
	{
		if ($item === null)
		{
			return true;
		}

		return ($item->form->key == $formKey);
	}
	
	/**
	 * Create a new form.
	 *
	 * @param	array	$data		Data to use for creation
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	Form
	 */
	public function create(array $data, $setFlash = true)
	{
		// Create the form
		$form = FormModel::create($data);

		if ($setFlash)
		{
			// Set the flash info
			$status = ($form) ? 'success' : 'danger';
			$message = ($form) 
				? lang('Short.alert.success.create', lang('form'))
				: lang('Short.alert.failure.create', lang('form'));

			// Flash the session
			$this->setFlashMessage($status, $message);
		}

		return $form;
	}

	/**
	 * Create a form field.
	 *
	 * @param	array	$data		Data to use for creating the field
	 * @param	Form	$form		The Form object
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	Field
	 */
	public function createField(array $data, $form, $setFlash = true)
	{
		// Create the field
		$newField = $form->fields()->getModel()->newInstance($data);

		// Attach the field to the form
		$item = $form->fields()->save($newField);

		// If we have values for the field, make sure to add them
		if (array_key_exists('field_values', $data))
		{
			// Break the values into an array
			$valuesArr = explode(',', $data['field_values']);

			foreach ($valuesArr as $key => $value)
			{
				// Create a new form value for this field
				$newValue = $item->values()->getModel()->newInstance([
					'value' => trim($value),
					'order' => $key
				]);
				$item->values()->save($newValue);
			}
		}

		if ($setFlash)
		{
			// Set the flash info
			$status = ($item) ? 'success' : 'danger';
			$message = ($item) 
				? lang('Short.alert.success.create', langConcat('form field'))
				: lang('Short.alert.failure.create', langConcat('form field'));

			// Flash the session
			$this->setFlashMessage($status, $message);
		}

		return $item;
	}

	/**
	 * Create a form field value.
	 *
	 * @param	array	$data		Data to use for creating the form field value
	 * @param	string	$formKey	The form key
	 * @param	int		$fieldId	Field ID of the value being added
	 * @return	Value
	 */
	public function createFieldValue(array $data, $formKey, $fieldId)
	{
		// Get the form
		$form = $this->findByKey($formKey);

		// Get the field
		$field = $form->fields()->find($fieldId);

		if ($field)
		{
			// Set a new instance
			$value = $field->values()->getModel()->newInstance([
				'value'		=> strtolower($data['content']),
				'content'	=> $data['content'],
				'field_id'	=> $fieldId,
				'order'		=> $data['order']
			]);

			// Save the value
			return $field->values()->save($value);
		}

		return false;
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
				FormDataModel::create([
					'form_id'		=> $form->id,
					'field_id'		=> $field,
					'data_id'		=> $id,
					'value'			=> trim($value),
					'created_by'	=> $currentUser->id,
				]);
			}
		}
	}

	/**
	 * Create a form section.
	 *
	 * @param	array	$data		Data to use for creating the section
	 * @param	Form	$form		The Form object
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	Section
	 */
	public function createSection(array $data, $form, $setFlash = true)
	{
		// Create the section
		$newSection = $form->sections()->getModel()->newInstance($data);
		
		// Attach it to the form
		$section = $form->sections()->save($newSection);

		if ($setFlash)
		{
			// Set the flash info
			$status = ($section) ? 'success' : 'danger';
			$message = ($section) 
				? lang('Short.alert.success.create', langConcat('form section'))
				: lang('Short.alert.failure.create', langConcat('form section'));

			// Flash the session
			$this->setFlashMessage($status, $message);
		}

		return $section;
	}

	/**
	 * Create a form tab.
	 *
	 * @param	array	$data		Data to use for creating the tab
	 * @param	Form	$form		The Form object
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	Tab
	 */
	public function createTab(array $data, $form, $setFlash = true)
	{
		// Create the tab
		$newTab = $form->tabs()->getModel()->newInstance($data);

		// Attach it to the form
		$tab = $form->tabs()->save($newTab);

		if ($setFlash)
		{
			// Set the flash info
			$status = ($tab) ? 'success' : 'danger';
			$message = ($tab) 
				? lang('Short.alert.success.create', langConcat('form tab'))
				: lang('Short.alert.failure.create', langConcat('form tab'));

			// Flash the session
			$this->setFlashMessage($status, $message);
		}

		return $tab;
	}

	/**
	 * Delete a form.
	 *
	 * @param	int		$id			ID to delete
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	Form
	 */
	public function delete($id, $setFlash = true)
	{
		// Get the form
		$form = $this->find($id);

		if ($form)
		{
			if ((bool) $form->protected)
			{
				throw new FormProtectedException;
			}

			// Delete the form
			$delete = $form->delete();

			if ($setFlash)
			{
				// Set the flash info
				$status = ($delete) ? 'success' : 'danger';
				$message = ($delete)
					? lang('Short.alert.success.delete', lang('form'))
					: lang('Short.alert.failure.delete', lang('form'));

				// Flash the session
				$this->setFlashMessage($status, $message);
			}

			return $form;
		}

		return false;
	}

	/**
	 * Delete a form field.
	 *
	 * @param	int		$id			Field ID to delete
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	bool
	 */
	public function deleteField($id, $setFlash = true)
	{
		// Get the field
		$field = $this->findField($id);

		// Delete the field
		$delete = $field->delete();

		if ($setFlash)
		{
			// Set the flash info
			$status = ($delete) ? 'success' : 'danger';
			$message = ($delete) 
				? lang('Short.alert.success.delete', langConcat('form field'))
				: lang('Short.alert.failure.delete', langConcat('form field'));

			// Flash the session
			$this->setFlashMessage($status, $message);
		}

		return $field;
	}

	/**
	 * Delete a form field value.
	 *
	 * @param	int		$id		Field value ID to delete
	 * @return	bool
	 */
	public function deleteFieldValue($id)
	{
		// Get the field value
		$value = $this->findFieldValue($id);

		// Delete the field value
		$value->delete();

		return $value;
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
		$entries = FormDataModel::key($form->key)->entry($id)->get();

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
	 * @param	int		$id			Section ID to delete
	 * @param	int		$newId		New section to use
	 * @param	Form	$form		The Form object
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	bool
	 */
	public function deleteSection($id, $newId, $form, $setFlash = true)
	{
		// Get the section
		$section = $form->sections()->find($this->sanitizeInt($id));

		if ($section)
		{
			// Sanitize the new ID
			$newId = $this->sanitizeInt($newId);

			if ($section->fields->count() > 0)
			{
				foreach ($section->fields as $field)
				{
					$field->update(['section_id' => $newId]);
				}
			}

			// Delete the section
			$delete = $section->delete();

			if ($setFlash)
			{
				// Set the flash info
				$status = ($delete) ? 'success' : 'danger';
				$message = ($delete) 
					? lang('Short.alert.success.delete', langConcat('form section'))
					: lang('Short.alert.failure.delete', langConcat('form section'));

				// Flash the session
				$this->setFlashMessage($status, $message);
			}

			return $delete;
		}

		return false;
	}

	/**
	 * Delete a form tab.
	 *
	 * @param	int		$id			Tab ID to delete
	 * @param	int		$newId		New tab to use
	 * @param	Form	$form		The Form object
	 * @param	bool	$setFlash	Set flash message?
	 * @return	bool
	 */
	public function deleteTab($id, $newId, $form, $setFlash = true)
	{
		// Get the tab
		$tab = $form->tabs()->find($this->sanitizeInt($id));

		if ($tab)
		{
			// Sanitize the new ID
			$newId = $this->sanitizeInt($newId);

			if ($tab->sections->count() > 0)
			{
				foreach ($tab->sections as $section)
				{
					$section->update(['tab_id' => $newId]);
				}
			}

			// Delete the tab
			$delete = $tab->delete();

			if ($setFlash)
			{
				// Set the flash info
				$status = ($delete) ? 'success' : 'danger';
				$message = ($delete) 
					? lang('Short.alert.success.delete', langConcat('form tab'))
					: lang('Short.alert.failure.delete', langConcat('form tab'));

				// Flash the session
				$this->setFlashMessage($status, $message);
			}

			return $delete;
		}

		return false;
	}

	/**
	 * Find a form.
	 *
	 * @param	int		$id		ID to find
	 * @return	Form
	 */
	public function find($id)
	{
		return FormModel::find($this->sanitizeInt($id));
	}

	/**
	 * Find a form by its form key.
	 *
	 * @param	string	$key	The form key
	 * @return	Form
	 */
	public function findByKey($key)
	{
		return FormModel::key($this->sanitizeString($key))->first();
	}

	/**
	 * Find a form field.
	 *
	 * @param	int		$id		Field ID
	 * @return	Field
	 */
	public function findField($id)
	{
		return FormFieldModel::find($this->sanitizeInt($id));
	}

	/**
	 * Find a form field value.
	 *
	 * @param	int		$id		Field value ID
	 * @return	Value
	 */
	public function findFieldValue($id)
	{
		return FormValueModel::find($this->sanitizeInt($id));
	}

	/**
	 * Find a form section.
	 *
	 * @param	int		$id		Section ID
	 * @return	Section
	 */
	public function findSection($id)
	{
		return FormSectionModel::find($this->sanitizeInt($id));
	}

	/**
	 * Find a form tab.
	 *
	 * @param	int		$id		Tab ID
	 * @return	Tab
	 */
	public function findTab($id)
	{
		return FormTabModel::find($this->sanitizeInt($id));
	}

	/**
	 * Get a field's values.
	 *
	 * @param	Field	$field
	 * @return	Collection
	 */
	public function getFormFieldValues($field)
	{
		return $field->values->sortBy(function($v)
		{
			return $v->order;
		});
	}

	/**
	 * Get all the form fields for a form.
	 *
	 * @param	string	$formKey	Form key
	 * @return	Collection
	 */
	public function getFormFields($formKey)
	{
		$form = $this->findByKey($formKey);

		return $form->fields;
	}

	/**
	 * Get all of a form's fields and order them by label.
	 *
	 * @param	string	$formKey	Form key
	 * @param	string	$key		Field to use as the array key
	 * @param	string	$value		Field to use as the array value
	 * @return	array
	 */
	public function getFormFieldsForDropdown($formKey, $key, $value)
	{
		// Get the form
		$form = $this->findByKey($formKey);

		// Start the fields array
		$fields[0] = lang('short.selectOne', langConcat('form field'));
		$fields += $form->fields()->active()
			->orderAsc('label')->get()
			->toSimpleArray($key, $value);

		return $fields;
	}

	/**
	 * Get all the form sections for a form.
	 *
	 * @param	string	$formKey	Form key
	 * @return	Collection
	 */
	public function getFormSections($formKey)
	{
		$form = $this->findByKey($formKey);

		return $form->sections->sortBy(function($s)
		{
			return $s->order;
		});
	}

	/**
	 * Get all of a form's sections and put them into an array.
	 *
	 * @param	string	$formKey	Form key
	 * @param	string	$key		Field to use as the array key
	 * @param	string	$value		Field to use as the array value
	 * @return	array
	 */
	public function getFormSectionsForDropdown($formKey, $key, $value)
	{
		// Get the form
		$form = $this->findByKey($formKey);

		// Start the sections array
		$sections[0] = lang('short.selectOne', langConcat('form section'));
		$sections += $form->sections()->active()
			->orderAsc('name')->get()
			->toSimpleArray($key, $value);

		return $sections;
	}

	/**
	 * Get the tabs and sections for a form broken up by
	 * tab.
	 *
	 * @param	string	$formKey	Form key
	 * @return	array
	 */
	public function getFormSectionsWithTabs($formKey)
	{
		// Get the sections
		$sections = $this->getFormSections($formKey);

		// Start an array to hold all the data
		$final = [];

		if ($sections->count() > 0)
		{
			foreach ($sections as $section)
			{
				if ($section->tab_id > 0)
				{
					$final[$section->tab_id][] = $section;
				}
				else
				{
					$final[] = $section;
				}
			}
		}

		return $final;
	}

	/**
	 * Get all the form tabs for a form.
	 *
	 * @param	string	$formKey	Form key
	 * @return	Collection
	 */
	public function getFormTabs($formKey)
	{
		$form = $this->findByKey($formKey);

		return $form->tabs->sortBy(function($t)
		{
			return $t->order;
		});
	}

	/**
	 * Get all of a form's tabs and put them into an array.
	 *
	 * @param	string	$formKey	Form key
	 * @param	string	$key		Field to use as the array key
	 * @param	string	$value		Field to use as the array value
	 * @return	array
	 */
	public function getFormTabsForDropdown($formKey, $key, $value)
	{
		// Get the form
		$form = $this->findByKey($formKey);

		// Start the tabs array
		$tabs[0] = lang('short.selectOne', langConcat('form tab'));
		$tabs += $form->tabs()->active()
			->orderAsc('name')->get()
			->toSimpleArray($key, $value);

		return $tabs;
	}

	/**
	 * Get a form's data entries.
	 *
	 * @param	Form	$form	Form object
	 * @return	Collection
	 */
	public function getFormViewerDataEntries($form)
	{
		return FormDataModel::key($form->key)->orderAsc('data_id')->get();
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

		return FormDataModel::key($form->key)->entry($id)->first();
	}

	/**
	 * Get the form key for an item.
	 *
	 * @param	object	$item	The item to check
	 * @return	string
	 */
	public function getItemFormKey($item)
	{
		return $item->form->key;
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
		$entries = FormDataModel::key($form->key)
			->group('data_id')
			->orderDesc('created_at');

		// Make sure we take into account what we want to use as a display
		if ((int) $form->form_viewer_display > 0)
		{
			$entries = $entries->where('field_id', $form->form_viewer_display);
		}

		return $entries->paginate($perPage);
	}

	/**
	 * Update a form.
	 *
	 * @param	int		$id			ID to update
	 * @param	array	$data		Data to use for update
	 * @param	bool	$setFlash	Set flash message?
	 * @return	Form
	 */
	public function update($id, array $data, $setFlash = true)
	{
		// Get the form
		$form = $this->find($id);

		// Update the form
		$update = $form->update($data);

		if ($setFlash)
		{
			// Set the flash info
			$status = ($update) ? 'success' : 'danger';
			$message = ($update) 
				? lang('Short.alert.success.update', lang('form'))
				: lang('Short.alert.failure.update', lang('form'));

			// Flash the session
			$this->setFlashMessage($status, $message);
		}

		return $update;
	}

	/**
	 * Update a form field.
	 *
	 * @param	int		$id			Field ID to update
	 * @param	array	$data		Data to use for the update
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	Field
	 */
	public function updateField($id, array $data, $setFlash = true)
	{
		// Get the field
		$field = $this->findField($id);

		// Update the field
		$update = $field->update($data);

		if ($setFlash)
		{
			// Set the flash info
			$status = ($update) ? 'success' : 'danger';
			$message = ($update) 
				? lang('Short.alert.success.update', langConcat('form field'))
				: lang('Short.alert.failure.update', langConcat('form field'));

			// Flash the session
			$this->setFlashMessage($status, $message);
		}

		return $update;
	}

	/**
	 * Update a form field value.
	 *
	 * @param	int		$id		Value ID to update
	 * @param	array	$data	Data to use for the update
	 * @return	Value
	 */
	public function updateFieldValue($id, array $data)
	{
		// Get the field value
		$value = $this->findFieldValue($id);

		// Update the field value
		return $value->update($data);
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
				$data = FormDataModel::key($form->key)->entry($id)->formField($field)->first();
				$data->update(['value' => trim(e($value))]);
			}
		}
	}

	/**
	 * Update a form section.
	 *
	 * @param	int		$id			Section ID to update
	 * @param	array	$data		Data to use for the update
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	Section
	 */
	public function updateSection($id, array $data, $setFlash = true)
	{
		// Get the section
		$section = $this->findSection($id);

		// Update the section
		$update = $section->update($data);

		if ($setFlash)
		{
			// Set the flash info
			$status = ($update) ? 'success' : 'danger';
			$message = ($update) 
				? lang('Short.alert.success.update', langConcat('form section'))
				: lang('Short.alert.failure.update', langConcat('form section'));

			// Flash the session
			$this->setFlashMessage($status, $message);
		}

		return $update;
	}

	/**
	 * Update a form tab.
	 *
	 * @param	int		$id			Tab ID to update
	 * @param	array	$data		Data to use for the update
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	Tab
	 */
	public function updateTab($id, array $data, $setFlash = true)
	{
		// Get the tab
		$tab = $this->findTab($id);

		// Update the tab
		$update = $tab->update($data);

		if ($setFlash)
		{
			// Set the flash info
			$status = ($update) ? 'success' : 'danger';
			$message = ($update) 
				? lang('Short.alert.success.update', langConcat('form tab'))
				: lang('Short.alert.failure.update', langConcat('form tab'));

			// Flash the session
			$this->setFlashMessage($status, $message);
		}

		return $update;
	}

}
<?php namespace Nova\Core\Handlers\Form;

use User;
use Status;
use Character;
use SystemEvent;
use NovaFormData;
use NovaFormSection;

class Field {

	/**
	 * When a field is created, we need to loop through the various pieces and
	 * make sure that data records are added.
	 *
	 * When a field is created, we need to check the containing section to see
	 * how we should handle activating/deactivating the section.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function afterCreate($model)
	{
		// What should be in the data?
		$data = array(
			'form_key'	=> $model->form_key,
			'field_id'	=> $model->id,
			'value'		=> '',
		);

		switch ($model->form_key)
		{
			case 'character':
				// Get all the active characters
				$characters = Character::active()->get();

				if ($characters->count() > 0)
				{
					foreach ($characters as $c)
					{
						NovaFormData::add(array('data_id' => $c->id));
					}
				}
			break;

			case 'user':
				// Get all the active users
				$users = User::active()->get();

				if ($users->count() > 0)
				{
					foreach ($users as $u)
					{
						NovaFormData::add(array('data_id' => $u->id));
					}
				}
			break;
		}

		/**
		 * Section cleanup
		 */
		$section = NovaFormSection::find($model->section_id);

		if ($section !== null)
		{
			if ($section->fields !== null)
			{
				// Loop through the fields and get the information about status
				foreach ($section->fields as $f)
				{
					$active[$f->id] = (int) $f->status;
				}

				// Get a count of the different values
				$active_count = array_count_values($active);

				// If there are no active fields OR the number of actives is more than 0
				if (in_array(Status::ACTIVE, $active) 
						or (array_key_exists(1, $active_count) and $active_count[1] > 0))
				{
					if ($section->status === Status::INACTIVE)
					{
						// There won't be any active fields left, so disable the section
						$section->status = Status::ACTIVE;
						
						// Save the record
						$section->save();
					}
				}
			}
			else
			{
				if ($section->status === Status::ACTIVE)
				{
					// There are no fields in the section, so disable it
					$section->status = Status::INACTIVE;
					
					// Save the record
					$section->save();
				}
			}
		}

		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.form.field_create', $model->name, lang('action.created'));
	}

	/**
	 * When a field is updated, we need to grab the section and do some checks
	 * to see if we should be activating or deactivating the section because of
	 * the number of fields or the number of active fields.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function afterUpdate($model)
	{
		/**
		 * Section cleanup
		 */
		$section = NovaFormSection::find($model->section_id);

		if ($section !== null)
		{
			if ($section->fields !== null)
			{
				// Loop through the fields and get the information about status
				foreach ($section->fields as $f)
				{
					$active[$f->id] = (int) $f->status;
				}

				// Get a count of the different values
				$active_count = array_count_values($active);

				// If there are no active fields OR the number of actives is 0
				if ( ! in_array(Status::ACTIVE, $active) 
						or (array_key_exists(1, $active_count) and $active_count[1] == 0))
				{
					// Only do the update if the section is active
					if ($section->status === Status::ACTIVE)
					{
						// There won't be any active fields left, so disable the section
						$section->status = Status::INACTIVE;
						
						// Save the record
						$section->save();
					}
				}
				else
				{
					// Only do the update if the section is inactive
					if ($section->status === Status::INACTIVE)
					{
						// Set the section to status
						$section->status = Status::ACTIVE;
						
						// Save the record
						$section->save();
					}
				}
			}
			else
			{
				// Only do the update if the section is active
				if ($section->status === Status::ACTIVE)
				{
					// There are no fields in the section, so disable it
					$section->status = Status::INACTIVE;
					
					// Save the record
					$section->save();
				}
			}
		}

		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.form.field_update', $model->label, $model->form_key);
	}

	/**
	 * When a field is deleted, we need to loop through and remove all data
	 * associated with that field.
	 *
	 * When a field is deleted, we need to loop through and remove any values
	 * associated with that field.
	 *
	 * Check what deleting the field will do to the active count of fields
	 * in a section and activate/deactivate the section accordingly.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function beforeDelete($model)
	{
		/**
		 * Value cleanup
		 */
		if ($model->values !== null)
		{
			foreach ($model->values as $val)
			{
				// Delete the value
				$val->delete();
			}
		}

		/**
		 * Data cleanup
		 */
		$data = NovaFormData::getData('field', $model->id);

		if ($data !== null)
		{
			foreach ($data as $val)
			{
				// Delete the data
				$val->delete();
			}
		}

		/**
		 * Section cleanup
		 */
		$section = NovaFormSection::find($model->section_id);

		if ($model->section_id > 0 and $section !== null)
		{
			if ($section->fields !== null)
			{
				// Loop through the fields and get the information about status
				foreach ($section->fields as $f)
				{
					$active[$f->id] = (int) $f->status;
				}

				// Get a count of the different values
				$active_count = array_count_values($active);

				// If there are no active fields OR the number of actives is
				// less than 2 (the current field removal would make it 0)
				if ( ! in_array(Status::ACTIVE, $active) 
						or (array_key_exists(1, $active_count) and $active_count[1] < 2))
				{
					if ($section->status === Status::ACTIVE)
					{
						// There won't be any active fields left, so disable the section
						$section->status = Status::INACTIVE;
						
						// Save the record
						$section->save();
					}
				}
			}
			else
			{
				if ($section->status === Status::ACTIVE)
				{
					// There are no fields in the section, so disable it
					$section->status = Status::INACTIVE;
					
					// Save the record
					$section->save();
				}
			}
		}

		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.form.field_delete', $model->label, $model->form_key);
	}

}
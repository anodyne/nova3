<?php namespace Nova\Core\Events\Models\Form;

/**
 * Form field event handler.
 *
 * created
 * When a field is created, we need to loop through the various pieces and
 * make sure that data records are added.
 *
 * When a field is created, we need to check the containing section to see
 * how we should handle activating/deactivating the section.
 *
 * updated
 * When a field is updated, we need to grab the section and do some checks
 * to see if we should be activating or deactivating the section because of
 * the number of fields or the number of active fields.
 *
 * deleting
 * When a field is deleted, we need to loop through and remove all data
 * associated with that field.
 *
 * When a field is deleted, we need to loop through and remove any values
 * associated with that field.
 *
 * Check what deleting the field will do to the active count of fields
 * in a section and activate/deactivate the section accordingly.
 */

use Str;
use Status;
use SystemEvent;
use BaseModelEventHandler;
use UserModel;
use CharacterModel;

class Field extends BaseModelEventHandler {

	public function created($model)
	{
		if ( ! empty($model->form->data_model))
		{
			// What should be in the data?
			$data = [
				'form_id'	=> $model->form->id,
				'field_id'	=> $model->id,
				'value'		=> '',
			];

			// Figure out if we need to add leading slashes or not
			$dataModel = (Str::contains($model->form->data_model, '\\'))
				? $model->form->data_model
				: '\\'.$model->form->data_model;
			
			// Call the createFieldData method on the data model
			call_user_func_array([$dataModel, 'createFieldData'], [$data]);
		}

		/**
		 * Section cleanup
		 */

		$section = $model->section;

		if ($section)
		{
			if ($section->fields->count() > 0)
			{
				// Loop through the fields and get the information about status
				foreach ($section->fields as $f)
				{
					$active[$f->id] = (int) $f->status;
				}

				// Get a count of the different values
				$activeCount = array_count_values($active);

				// If there are no active fields OR the number of actives is more than 0
				if (in_array(Status::ACTIVE, $active) 
						or (array_key_exists(1, $activeCount) and $activeCount[1] > 0))
				{
					if ($section->status === Status::INACTIVE)
					{
						// Update the section
						$section->update(['status' => Status::ACTIVE]);
					}
				}
			}
			else
			{
				if ($section->status === Status::ACTIVE)
				{
					// Update the section
					$section->update(['status' => Status::INACTIVE]);
				}
			}
		}

		/**
		 * System Event
		 */
		SystemEvent::addUserEvent(
			'event.admin.form.item',
			$model->name,
			langConcat('form field'),
			$model->form->name,
			lang('action.created')
		);
	}

	public function updated($model)
	{
		/**
		 * Section cleanup
		 */

		$section = $model->section;

		if ($section)
		{
			if ($section->fields->count() > 0)
			{
				// Loop through the fields and get the information about status
				foreach ($section->fields as $f)
				{
					$active[$f->id] = (int) $f->status;
				}

				// Get a count of the different values
				$activeCount = array_count_values($active);

				// If there are no active fields OR the number of actives is 0
				if ( ! in_array(Status::ACTIVE, $active) 
						or (array_key_exists(1, $activeCount) and $activeCount[1] == 0))
				{
					// Only do the update if the section is active
					if ($section->status === Status::ACTIVE)
					{
						// Update the section
						$section->update(['status' => Status::INACTIVE]);
					}
				}
				else
				{
					// Only do the update if the section is inactive
					if ($section->status === Status::INACTIVE)
					{
						// Update the section
						$section->update(['status' => Status::ACTIVE]);
					}
				}
			}
			else
			{
				// Only do the update if the section is active
				if ($section->status === Status::ACTIVE)
				{
					// Update the section
						$section->update(['status' => Status::INACTIVE]);
				}
			}
		}

		/**
		 * System Event
		 */
		SystemEvent::addUserEvent(
			'event.admin.form.item',
			$model->name,
			langConcat('form field'),
			$model->form->name,
			lang('action.updated')
		);
	}

	public function deleting($model)
	{
		/**
		 * Value cleanup
		 */
		
		if ($model->values->count() > 0)
		{
			foreach ($model->values as $value)
			{
				// Delete the value
				$value->delete();
			}
		}

		/**
		 * Data cleanup
		 */

		if ($model->data->count() > 0)
		{
			foreach ($model->data as $data)
			{
				// Delete the data
				$data->delete();
			}
		}

		/**
		 * Section cleanup
		 */

		$section = $model->section;

		if ($section)
		{
			if ($section->fields->count() > 0)
			{
				// Loop through the fields and get the information about status
				foreach ($section->fields as $f)
				{
					$active[$f->id] = (int) $f->status;
				}

				// Get a count of the different values
				$activeCount = array_count_values($active);

				// If there are no active fields OR the number of actives is
				// less than 2 (the current field removal would make it 0)
				if ( ! in_array(Status::ACTIVE, $active) 
						or (array_key_exists(1, $activeCount) and $activeCount[1] < 2))
				{
					if ($section->status === Status::ACTIVE)
					{
						// Update the section
						$section->update(['status' => Status::INACTIVE]);
					}
				}
			}
			else
			{
				if ($section->status === Status::ACTIVE)
				{
					// Update the section
					$section->update(['status' => Status::INACTIVE]);
				}
			}
		}
	}

	public function deleted($model)
	{
		SystemEvent::addUserEvent(
			'event.admin.form.item',
			$model->name,
			langConcat('form field'),
			$model->form->name,
			lang('action.deleted')
		);
	}

}
<?php namespace Nova\Core\Services\Events\Form;

use Status;
use NovaFormTab;
use SystemEvent;
use NovaFormData;
use NovaFormField;
use NovaFormSection;

class Section {

	/**
	 * When a new section is added, we need to check to see how many sections
	 * exist already. If there's only 1 (i.e. the one we just created) then we
	 * need to update all of the fields for that form to move them in to the
	 * newly created section otherwise we won't have access to edit the fields
	 * any more.
	 *
	 * When a new section is created, we need to check the containing tab's
	 * status to figure out if we should be activating/deactivating the tab.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function afterCreate($model)
	{
		// What form are we updating?
		$form = $model->form_key;

		// Count how many sections we have in this key
		$sections = NovaFormSection::getItems($form);

		if (count($sections) == 1)
		{
			// Get all the fields for this form
			$fields = NovaFormField::getFormItems($form);

			if (count($fields) > 0)
			{
				foreach ($fields as $f)
				{
					// Set the field to have the ID of the newly created section
					$f->section_id = $model->id;

					// Save the record
					$f->save();
				}
			}
		}

		/**
		 * Tab cleanup
		 */
		$tab = NovaFormTab::find($model->tab_id);

		if ($tab !== null)
		{
			if ($tab->sections !== null)
			{
				// Loop through the sections and get the information about status
				foreach ($tab->sections as $s)
				{
					$active[$s->id] = (int) $s->status;
				}

				// Get a count of the different values
				$active_count = array_count_values($active);

				// If there are no active sections OR the number of actives is more than 0
				if (in_array(Status::ACTIVE, $active) 
						or (array_key_exists(1, $active_count) and $active_count[1] > 0))
				{
					if ($tab->status === Status::INACTIVE)
					{
						// There won't be any active sections left, so disable the tab
						$tab->status = Status::ACTIVE;
						
						// Save the record
						$tab->save();
					}
				}
			}
			else
			{
				if ($tab->status === Status::ACTIVE)
				{
					// There are no sections in the tab, so disable it
					$tab->status = Status::INACTIVE;
					
					// Save the record
					$tab->save();
				}
			}
		}

		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.form.section_create', $model->name, $model->form_key);
	}

	/**
	 * When a section is updated, we need to check that tab's sections to see
	 * how we should handle activating/deactivating tabs based on the sections.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function afterUpdate($model)
	{
		/**
		 * Tab cleanup
		 */
		$tab = NovaFormTab::find($model->tab_id);

		if ($tab !== null)
		{
			if ($tab->sections !== null)
			{
				// Loop through the sections and get the information about status
				foreach ($tab->sections as $s)
				{
					$active[$s->id] = (int) $s->status;
				}

				// Get a count of the different values
				$active_count = array_count_values($active);

				// If there are no active sections OR the number of actives is only 1
				if ( ! in_array(Status::ACTIVE, $active) 
						or (array_key_exists(1, $active_count) and $active_count[1] == 0))
				{
					if ($tab->status === Status::ACTIVE)
					{
						// There won't be any active sections left, so disable the tab
						$tab->status = Status::INACTIVE;
						
						// Save the record
						$tab->save();
					}
				}
				else
				{
					if ($tab->status === Status::INACTIVE)
					{
						// Make sure the tab is active
						$tab->status = Status::ACTIVE;
						
						// Save the record
						$tab->save();
					}
				}
			}
			else
			{
				if ($tab->status === Status::ACTIVE)
				{
					// There are no sections in the tab, so disable it
					$tab->status = Status::INACTIVE;
					
					// Save the record
					$tab->save();
				}
			}
		}

		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.form.section_update', $model->label, $model->form_key);
	}

	/**
	 * When a section is deleted, we need to loop through its tab sections
	 * and see if we should be activating/deactivating any tabs.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function beforeDelete($model)
	{
		/**
		 * Tab cleanup
		 */
		$tab = NovaFormTab::find($model->tab_id);

		if ($tab !== null)
		{
			if ($tab->sections !== null)
			{
				// Loop through the sections and get the information about status
				foreach ($tab->sections as $s)
				{
					$active[$s->id] = (int) $s->status;
				}

				// Get a count of the different values
				$active_count = array_count_values($active);

				// If there are no active sections OR the number of actives is less
				// than 2 (the current section removal would make it 0)
				if ( ! in_array(Status::ACTIVE, $active) 
						or (array_key_exists(1, $active_count) and $active_count[1] < 2))
				{
					if ($tab->status === Status::ACTIVE)
					{
						// There won't be any active sections left, so disable the tab
						$tab->status = Status::INACTIVE;
						
						// Save the record
						$tab->save();
					}
				}
			}
			else
			{
				if ($tab->status === Status::ACTIVE)
				{
					// There are no sections in the tab, so disable it
					$tab->status = Status::INACTIVE;
					
					// Save the record
					$tab->save();
				}
			}
		}

		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.form.section_delete', $model->label, $model->form_key);
	}

}
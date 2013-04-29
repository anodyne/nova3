<?php namespace Nova\Core\Services\Events\Form;

use NovaFormTab;
use SystemEvent;
use NovaFormData;
use NovaFormField;
use NovaFormSection;

class Tab {

	/**
	 * When a new tab is added, we need to check to see how many tabs exist
	 * already. If there's only 1 (i.e. the one we just created) then we need to
	 * update all of the sections for that form to move them in to the newly
	 * created tab. If there aren't any sections either, we need to create a 
	 * blank section and move all the fields in to that section. If these steps 
	 * aren't done, we could orphan fields and sections for the form.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function afterCreate($model)
	{
		// What form are we updating?
		$form = $model->form_key;

		// Count how many tabs we have in this form
		$tabs = NovaFormTab::getFormItems($form);

		if ($tabs->count() < 2)
		{
			// Get all the sections for this form
			$sections = NovaFormSection::getFormItems($form);

			if ($sections->count() > 0)
			{
				foreach ($sections as $s)
				{
					// Set the section to have the ID of the newly created tab
					$s->tab_id = $model->id;

					// Save the record
					$s->save();
				}
			}
			else
			{
				// Create a new section
				$sec = NovaFormSection::add(array(
					'form_key'	=> $form,
					'tab_id'	=> $model->id,
					'name'		=> '',
					'order'		=> 0
				), true);

				// Get all the fields and move them in to the section
				$fields = NovaFormField::getFormItems($form);

				if (count($fields) > 0)
				{
					foreach ($fields as $f)
					{
						// Update the field section
						$f->section_id = $sec->id;

						// Save the field
						$f->save();
					}
				}
			}
		}

		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.form.tab_create', $model->name, $model->form_key);
	}

	/**
	 * When a tab is updated, create a system event.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function afterUpdate($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.form.tab_update', $model->name, $model->form_key);
	}

	/**
	 * When a tab is deleted, create a system event.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function beforeDelete($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.form.tab_delete', $model->name, $model->form_key);
	}

}
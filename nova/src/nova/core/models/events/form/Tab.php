<?php namespace Nova\Core\Models\Events\Form;

/**
 * Form tab event handler.
 *
 * afterCreate
 * When a new tab is created, we need to check to see how many tabs exist
 * already. If there's only 1 (i.e. the one we just created) then we need to
 * update all of the sections for that form to move them in to the newly
 * created tab. If there aren't any sections either, we need to create a 
 * blank section and move all the fields in to that section. If these steps 
 * aren't done, we could orphan fields and sections for the form.
 *
 * afterUpdate
 * Create a system event. 
 *
 * beforeDelete
 * Create a system event.
 */

use SystemEvent;
use NovaFormSection;
use BaseEventHandler;

class Tab extends BaseEventHandler {

	public function afterCreate($model)
	{
		// What form are we updating?
		$form = $model->form;

		// We only have the tab we just created...
		if ($form->tabs->count() == 1)
		{
			// There were no tabs before, so let's move all the sections
			// into the tab we just created
			if ($form->sections->count() > 0)
			{
				foreach ($form->sections as $section)
				{
					// Set the section to have the ID of the newly created tab
					$section->tab_id = $model->id;
					$s->save();
				}
			}
			else
			{
				// Create a new section
				$newSection = new NovaFormSection([
					'form_id'	=> $form->id,
					'tab_id'	=> $model->id,
					'name'		=> '',
					'order'		=> 0
				]);

				// We don't have any sections, so let's create a blank one
				$model->section()->save($newSection);

				// We have fields...
				if ($form->fields->count() > 0)
				{
					// Loop through the fields
					foreach ($form->fields as $field)
					{
						// Update the field section
						$field->section_id = $newSection->id;
						$field->save();
					}
				}
			}
		}

		/**
		 * System Event
		 */
		SystemEvent::addUserEvent(
			'event.admin.form.item',
			$model->name,
			langConcat('form tab'),
			$model->form->name,
			lang('action.created')
		);
	}

	public function afterUpdate($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent(
			'event.admin.form.item',
			$model->name,
			langConcat('form tab'),
			$model->form->name,
			lang('action.updated')
		);
	}

	public function beforeDelete($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent(
			'event.admin.form.item',
			$model->name,
			langConcat('form tab'),
			$model->form->name,
			lang('action.deleted')
		);
	}

}
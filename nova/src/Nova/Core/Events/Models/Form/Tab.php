<?php namespace Nova\Core\Events\Models\Form;

/**
 * Form tab event handler.
 *
 * created
 * When a new tab is created, we need to check to see how many tabs are attached
 * to the form already. If the tab we created is the only tab, we need to look 
 * at the sections. In the event there are no sections, but there are fields 
 * attached, we create a new section and put all the fields into the newly 
 * created section. If there are sections, we'll take the first one and assign 
 * all the fields to that section.
 *
 * updated
 * Create a system event. 
 *
 * deleting
 * Create a system event.
 */

use SystemEvent;
use FormSectionModel;
use BaseModelEventHandler;

class Tab extends BaseModelEventHandler {

	public function created($model)
	{
		// What form are we updating?
		$form = $model->form;

		// We only have the tab we just created...
		if ($form->tabs->count() == 1)
		{
			// There were no tabs before, but there are sections
			// attached to this form (not sure how that would
			// happen, but let's account for it anyway)
			if ($form->sections->count() > 0)
			{
				foreach ($form->sections as $section)
				{
					// Add the sections to the newly created tab
					$section->update(['tab_id' => $model->id]);
				}
			}

			// There are fields attached to this form
			if ($form->fields->count() > 0)
			{
				// We don't have any sections
				if ($form->sections->count() == 0)
				{
					// Create a new section
					$newSection = new FormSectionModel([
						'form_id'	=> $form->id,
						'tab_id'	=> $model->id,
						'name'		=> '',
						'order'		=> 0
					]);

					// Attach the section to the tab
					$model->sections->save($newSection);

					foreach ($form->fields as $field)
					{
						// Add the fields to the newly created section
						$field->update(['section_id' => $newSection->id]);
					}
				}
				else
				{
					foreach ($form->fields as $field)
					{
						// Add the fields to the first section we find
						$field->update(['section_id' => $model->sections->first()->id]);
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

	public function updated($model)
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

	public function deleted($model)
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
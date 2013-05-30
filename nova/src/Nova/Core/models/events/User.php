<?php namespace Nova\Core\Models\Events;

use NovaForm;
use SystemEvent;
use NovaFormData;

class User {

	/**
	 * When a user is created, we need to create blank data records
	 * to prevent errors being thrown when the user is updated and
	 * we need to create the user preferences as well.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function afterCreate($model)
	{
		/**
		 * Create the user settings.
		 */
		$model->createUserPreferences();
		
		/**
		 * Fill the user rows for the dynamic form with blank data for editing later.
		 */
		$form = NovaForm::getForm('user');
		
		if ($form->fields->count() > 0)
		{
			foreach ($form->fields as $field)
			{
				NovaFormData::create([
					'form_id' 	=> $form->id,
					'field_id' 	=> $field->id,
					'data_id' 	=> $model->id,
					'value' 	=> '',
				]);
			}
		}

		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.item', lang('user'), $model->name, lang('action.created'));
	}

	/**
	 * Post-update event.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function afterUpdate($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.item', lang('user'), $model->name, lang('action.updated'));
	}

	/**
	 * Pre-delete event.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function beforeDelete($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.item', lang('user'), $model->name, lang('action.deleted'));
	}

}
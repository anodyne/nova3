<?php namespace Nova\Core\Models\Events\Form;

/**
 * Form field value event handler.
 *
 * afterCreate
 * Create a system event.
 *
 * afterUpdate
 * Create a system event. 
 *
 * beforeDelete
 * Create a system event.
 */

use SystemEvent;
use BaseEventHandler;

class Value extends BaseEventHandler {

	public function afterCreate($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent(
			'event.admin.form.item',
			$model->content,
			langConcat('form field value'),
			$model->field->form->name,
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
			$model->content,
			langConcat('form field value'),
			$model->field->form->name,
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
			$model->content,
			langConcat('form field value'),
			$model->field->form->name,
			lang('action.deleted')
		);
	}

}
<?php namespace Nova\Core\Events\Form;

/**
 * Form field value event handler.
 *
 * created
 * Create a system event.
 *
 * updated
 * Create a system event. 
 *
 * deleting
 * Create a system event.
 */

use BaseEventHandler;

class ValueEventHandler extends BaseEventHandler {

	public function created($model)
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

	public function updated($model)
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

	public function deleted($model)
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
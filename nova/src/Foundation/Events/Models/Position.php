<?php namespace Nova\Core\Events\Models;

use SystemEvent;
use BaseModelEventHandler;

class Position extends BaseModelEventHandler {
	
	/**
	 * After create event
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function created($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.position', lang('base.position'), $model->name, lang('action.created'));
	}

	/**
	 * After update event
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function updated($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.position', lang('base.position'), $model->name, lang('action.updated'));
	}

	/**
	 * Before delete event
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function deleting($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.admin.position', lang('base.position'), $model->name, lang('action.deleted'));
	}

}
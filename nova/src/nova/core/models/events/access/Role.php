<?php namespace Nova\Core\Models\Events\Access;

use SystemEvent;
use BaseEventHandler;

class Role extends BaseEventHandler {
	
	public function created($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.item', langConcat('access role'), $model->name, lang('action.created'));
	}

	public function updated($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.item', langConcat('access role'), $model->name, lang('action.updated'));
	}

	public function deleting($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.item', langConcat('access role'), $model->name, lang('action.deleted'));
	}

}
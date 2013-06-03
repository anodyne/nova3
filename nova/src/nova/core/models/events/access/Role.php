<?php namespace Nova\Core\Models\Events\Access;

use SystemEvent;
use BaseEventHandler;

class Role extends BaseEventHandler {
	
	public function afterCreate($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.item', langConcat('access role'), $model->name, lang('action.created'));
	}

	public function afterUpdate($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.item', langConcat('access role'), $model->name, lang('action.updated'));
	}

	public function beforeDelete($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.item', langConcat('access role'), $model->name, lang('action.deleted'));
	}

}
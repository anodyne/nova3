<?php namespace Nova\Core\Services\Events\Access;

use SystemEvent;

class Role {
	
	/**
	 * After create event
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function afterCreate($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.item', langConcat('access role'), $model->name, lang('action.created'));
	}

	/**
	 * After update event
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function afterUpdate($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.item', langConcat('access role'), $model->name, lang('action.updated'));
	}

	/**
	 * Before delete event
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function beforeDelete($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.item', langConcat('access role'), $model->name, lang('action.deleted'));
	}

}
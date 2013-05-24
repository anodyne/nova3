<?php namespace Nova\Core\Services\Events;

use SystemEvent;
use SystemRoute as SystemRouteModel;

class SystemRoute {
	
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
		SystemEvent::addUserEvent('event.item', langConcat('system page'), $model->name, lang('action.created'));
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
		SystemEvent::addUserEvent('event.item', langConcat('system page'), $model->name, lang('action.updated'));
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
		SystemEvent::addUserEvent('event.item', langConcat('system page'), $model->name, lang('action.deleted'));
	}

	/**
	 * After the model is saved, we need to re-cache the routes,
	 * but only if we're adding an unprotected route (user-created).
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function afterSave($model)
	{
		if ((bool) $model->protected === false)
		{
			SystemRouteModel::cache();
		}
	}

}
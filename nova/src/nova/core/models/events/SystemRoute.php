<?php namespace nova\core\models\events;

use SystemEvent;
use BaseEventHandler;

class SystemRoute extends BaseEventHandler {

	public static $lang = 'system route';
	public static $name = 'name';

	/**
	 * Before delete event
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function deleting($model)
	{
		if ((bool) $model->protected === false)
		{
			\SystemRoute::cache();
		}
	}

	/**
	 * After the model is saved, we need to re-cache the routes,
	 * but only if we're adding an unprotected route (user-created).
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function saved($model)
	{
		if ((bool) $model->protected === false)
		{
			\SystemRoute::cache();
		}
	}

}
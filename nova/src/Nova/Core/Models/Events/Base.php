<?php namespace Nova\Core\Models\Events;

use SystemEvent;

/**
 * Base event handler that sets all the different event methods.
 */

class Base {

	public static $lang = '';
	public static $name = 'name';

	public function saving($model)
	{
		# code...
	}

	public function updating($model)
	{
		# code...
	}

	public function creating($model)
	{
		# code...
	}

	public function created($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent(
			'event.item',
			langConcat(static::$lang),
			$model->{static::$name},
			lang('action.created')
		);
	}

	public function updated($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent(
			'event.item',
			langConcat(static::$lang),
			$model->{static::$name},
			lang('action.updated')
		);
	}

	public function saved($model)
	{
		# code...
	}

	public function deleting($model)
	{
		# code...
	}

	public function deleted($model)
	{
		/**
		 * System Event
		 */
		SystemEvent::addUserEvent(
			'event.item',
			langConcat(static::$lang),
			$model->{static::$name},
			lang('action.deleted')
		);
	}

}
<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package		Fuel
 * @version		1.0
 * @author		Fuel Development Team
 * @license		MIT License
 * @copyright	2010 - 2012 Fuel Development Team
 * @link		http://fuelphp.com
 */

namespace Nova\Foundation\Database;

abstract class Observer
{
	protected static $_instances = array();

	public static function ormNotify($instance, $event)
	{
		$modelClass = get_class($instance);

		if (method_exists(static::instance($modelClass), $event))
		{
			static::instance($modelClass)->{$event}($instance);
		}
	}

	public static function instance($modelClass)
	{
		$observer = get_called_class();
		
		if (empty(static::$_instances[$observer][$modelClass]))
		{
			static::$_instances[$observer][$modelClass] = new static($modelClass);
		}

		return static::$_instances[$observer][$modelClass];
	}
}

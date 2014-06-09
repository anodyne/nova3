<?php namespace Nova\Core\Events;

use SystemEvent;

class BaseEventHandler {

	public static $item = '';
	public static $name = 'name';

	/**
	 * Create a new system event.
	 *
	 * @param	string	$action		Language item for the action
	 * @param	string	$item		Language item for what we're doing
	 * @param	string	$name		The item
	 * @param	string	$langItem	The base language item to use
	 * @return	void
	 */
	public function createSystemEvent($action, $item, $name, $langItem = 'event.item')
	{
		SystemEvent::addUserEvent($langItem, langConcat($item), $name, langConcat($action));
	}

}
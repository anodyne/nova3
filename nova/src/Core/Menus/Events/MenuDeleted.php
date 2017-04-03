<?php namespace Nova\Core\Menus\Events;

use Nova\Foundation\Events\Event;

class MenuDeleted extends Event
{
	public $key;
	public $name;

	public function __construct($key, $name)
	{
		$this->key = $key;
		$this->name = $name;
	}
}

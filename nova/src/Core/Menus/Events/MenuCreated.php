<?php namespace Nova\Core\Menus\Events;

use Menu;
use Nova\Foundation\Events\Event;

class MenuCreated extends Event
{
	public $resource;

	public function __construct(Menu $resource)
	{
		$this->resource = $resource;
	}
}

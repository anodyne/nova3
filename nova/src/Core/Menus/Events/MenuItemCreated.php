<?php namespace Nova\Core\Menus\Events;

use MenuItem;
use Nova\Foundation\Events\Event;

class MenuItemCreated extends Event
{
	public $resource;

	public function __construct(MenuItem $resource)
	{
		$this->resource = $resource;
	}
}

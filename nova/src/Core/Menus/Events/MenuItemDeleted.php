<?php namespace Nova\Core\Menus\Events;

use Nova\Foundation\Events\Event;

class MenuItemDeleted extends Event
{
	public $title;
	public $link;

	public function __construct($title, $link)
	{
		$this->title = $title;
		$this->link = $link;
	}
}

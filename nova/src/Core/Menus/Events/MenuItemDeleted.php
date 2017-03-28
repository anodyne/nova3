<?php namespace Nova\Core\Menus\Events;

use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class MenuItemDeleted extends Event
{
	use SerializesModels;

	protected $title;
	protected $link;

	public function __construct($title, $link)
	{
		$this->title = $title;
		$this->link = $link;
	}
}

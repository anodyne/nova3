<?php namespace Nova\Core\Menus\Events;

use Menu;
use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class MenuWasCreated extends Event {

	use SerializesModels;

	protected $menu;

	public function __construct(Menu $menu)
	{
		$this->menu = $menu;
	}

}

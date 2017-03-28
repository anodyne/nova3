<?php namespace Nova\Core\Menus\Events;

use Menu;
use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class MenuCreated extends Event
{
	use SerializesModels;

	protected $resource;

	public function __construct(Menu $resource)
	{
		$this->resource = $resource;
	}
}

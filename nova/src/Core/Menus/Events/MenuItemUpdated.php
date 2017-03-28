<?php namespace Nova\Core\Menus\Events;

use MenuItem;
use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class MenuItemUpdated extends Event
{
	use SerializesModels;

	protected $resource;

	public function __construct(MenuItem $resource)
	{
		$this->resource = $resource;
	}
}

<?php namespace Nova\Core\Pages\Events;

use Page;
use Nova\Foundation\Events\Event;

class PageUpdated extends Event
{
	public $resource;

	public function __construct(Page $resource)
	{
		$this->resource = $resource;
	}
}

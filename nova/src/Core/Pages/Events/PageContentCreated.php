<?php namespace Nova\Core\Pages\Events;

use PageContent;
use Nova\Foundation\Events\Event;

class PageContentCreated extends Event
{
	public $resource;

	public function __construct(PageContent $resource)
	{
		$this->resource = $resource;
	}
}

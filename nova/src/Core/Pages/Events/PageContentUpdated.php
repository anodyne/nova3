<?php namespace Nova\Core\Pages\Events;

use PageContent;
use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class PageContentUpdated extends Event
{
	use SerializesModels;

	protected $resource;

	public function __construct(PageContent $resource)
	{
		$this->resource = $resource;
	}
}

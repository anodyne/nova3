<?php namespace Nova\Core\Pages\Events;

use Page;
use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class PageWasCreated extends Event {

	use SerializesModels;

	protected $page;

	public function __construct(Page $page)
	{
		$this->page = $page;
	}

}

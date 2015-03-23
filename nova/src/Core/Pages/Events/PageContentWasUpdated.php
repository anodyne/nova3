<?php namespace Nova\Core\Pages\Events;

use PageContent;
use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class PageContentWasUpdated extends Event {

	use SerializesModels;

	protected $content;

	public function __construct(PageContent $content)
	{
		$this->content = $content;
	}

}

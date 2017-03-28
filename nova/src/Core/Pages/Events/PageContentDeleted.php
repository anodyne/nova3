<?php namespace Nova\Core\Pages\Events;

use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class PageContentDeleted extends Event
{
	use SerializesModels;

	protected $key;
	protected $type;

	public function __construct($key, $type)
	{
		$this->key = $key;
		$this->type = $type;
	}
}

<?php namespace Nova\Core\Pages\Events;

use Nova\Foundation\Events\Event;

class PageContentDeleted extends Event
{
	public $key;
	public $type;

	public function __construct($key, $type)
	{
		$this->key = $key;
		$this->type = $type;
	}
}

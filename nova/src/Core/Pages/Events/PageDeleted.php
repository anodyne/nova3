<?php namespace Nova\Core\Pages\Events;

use Nova\Foundation\Events\Event;

class PageDeleted extends Event
{
	public $name;
	public $key;
	public $uri;

	public function __construct($name, $key, $uri)
	{
		$this->name = $name;
		$this->key = $key;
		$this->uri = $uri;
	}
}

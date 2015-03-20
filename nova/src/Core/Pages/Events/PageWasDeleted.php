<?php namespace Nova\Core\Pages\Events;

use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class PageWasDeleted extends Event {

	use SerializesModels;

	protected $name;
	protected $key;
	protected $uri;

	public function __construct($name, $key, $uri)
	{
		$this->name = $name;
		$this->key = $key;
		$this->uri = $uri;
	}

}

<?php namespace Nova\Core\Menus\Events;

use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class MenuDeleted extends Event
{
	use SerializesModels;

	protected $key;
	protected $name;

	public function __construct($key, $name)
	{
		$this->key = $key;
		$this->name = $name;
	}
}

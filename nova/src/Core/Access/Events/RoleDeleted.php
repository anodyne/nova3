<?php namespace Nova\Core\Access\Events;

use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class RoleDeleted extends Event
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

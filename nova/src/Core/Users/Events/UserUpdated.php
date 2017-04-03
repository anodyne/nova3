<?php namespace Nova\Core\Users\Events;

use User;
use Nova\Foundation\Events\Event;

class UserUpdated extends Event
{
	public $resource;

	public function __construct(User $resource)
	{
		$this->resource = $resource;
	}
}

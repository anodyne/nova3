<?php namespace Nova\Core\Users\Events;

use User;
use Nova\Foundation\Events\Event;

class UserCreatedByAdmin extends Event
{
	public $resource;
	public $password;

	public function __construct(User $resource, $password)
	{
		$this->resource = $resource;
		$this->password = $password;
	}
}

<?php namespace Nova\Core\Users\Events;

use User;
use Nova\Foundation\Events\Event;

class UserUpdated extends Event
{
	public $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}
}

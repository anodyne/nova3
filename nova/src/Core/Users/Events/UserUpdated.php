<?php namespace Nova\Core\Users\Events;

use User;
use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class UserUpdated extends Event {

	use SerializesModels;

	public $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

}

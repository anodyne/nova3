<?php namespace Nova\Core\Users\Events;

use User;
use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class UserRestoredByAdmin extends Event {

	use SerializesModels;

	public $user;
	public $password;

	public function __construct(User $user, $password)
	{
		$this->user = $user;
		$this->password = $password;
	}
}

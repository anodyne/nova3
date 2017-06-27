<?php namespace Nova\Users\Events;

use Nova\Users\User;
use Illuminate\Queue\SerializesModels;

class PasswordWasGenerated
{
	use SerializesModels;

	public $user;
	public $password;

	public function __construct(User $user, $password)
	{
		$this->user = $user;
		$this->password = $password;
	}
}

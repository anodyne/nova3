<?php namespace Nova\Users\Events;

use Illuminate\Queue\SerializesModels;

class AdminForcedPasswordReset
{
	use SerializesModels;

	public $users;

	public function __construct($users)
	{
		$this->users = $users;
	}
}

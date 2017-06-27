<?php namespace Nova\Users\Events;

use Nova\Users\User;
use Illuminate\Queue\SerializesModels;

class UserWasDeletedByAdmin
{
	use SerializesModels;

	public $name;
	public $email;

	public function __construct($name, $email)
	{
		$this->name = $name;
		$this->email = $email;
	}
}

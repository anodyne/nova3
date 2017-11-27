<?php namespace Nova\Users\Events;

use Nova\Users\User;
use Illuminate\Queue\SerializesModels;

class UserWasUpdatedByAdmin
{
	use SerializesModels;

	public $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}
}

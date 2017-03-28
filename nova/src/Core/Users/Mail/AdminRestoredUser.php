<?php namespace Nova\Core\Users\Mail;

use User;
use BaseMailable;

class AdminRestoredUser extends BaseMailable
{
	public $user;
	public $password;

	public function __construct(User $user, $password)
	{
		parent::__construct();

		$this->user = $user;
		$this->password = $password;
	}

	public function build()
	{
		return $this->subject('User Account Restored')
			->replyTo('foo@example.com')
			->view('admin/users/user-restored');
	}
}

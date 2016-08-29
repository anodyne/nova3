<?php namespace Nova\Core\Users\Mail;

use User, BaseMailable;

class AdminCreatedUser extends BaseMailable {

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
		return $this->subject('User Account Created')
			->replyTo('foo@example.com')
			->view('admin/users/user-added');
	}
}

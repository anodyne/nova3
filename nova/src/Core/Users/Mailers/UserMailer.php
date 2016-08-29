<?php namespace Nova\Core\Users\Mailers;

use User, BaseMailer;

class UserMailer extends BaseMailer {

	public function sendNewUserPassword(User $user, $password)
	{
		return $this->send('admin/users/user-added', [
			'to' => $user->email,
			'from' => [$this->settings->mail_default_address, $this->settings->mail_default_name],
			'subject' => "",
		]);
	}
}

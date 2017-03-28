<?php namespace Nova\Core\Users\Listeners;

use Mail;
use AdminCreatedUserMailer;

class EmailNewUserPassword
{
	public function handle($event)
	{
		Mail::to($event->user->email)
			->queue(new AdminCreatedUserMailer($event->user, $event->password));
	}
}

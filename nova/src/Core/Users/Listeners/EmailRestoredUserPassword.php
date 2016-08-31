<?php namespace Nova\Core\Users\Listeners;

use Mail, AdminRestoredUserMailer;

class EmailRestoredUserPassword {

	public function handle($event)
	{
		Mail::to($event->user->email)
			->queue(new AdminRestoredUserMailer($event->user, $event->password));
	}
}

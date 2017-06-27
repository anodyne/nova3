<?php namespace Nova\Users\Listeners;

use Mail;
use Nova\Users\Mail\SendNewPassword;
use Nova\Users\Events\PasswordWasGenerated;

class SendPasswordToUser
{
	public function handle(PasswordWasGenerated $event)
	{
		// Send the email
		Mail::to($event->user->email)->send(new SendNewPassword($event->password));
	}
}

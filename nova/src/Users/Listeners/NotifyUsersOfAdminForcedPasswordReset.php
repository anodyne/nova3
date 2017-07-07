<?php namespace Nova\Users\Listeners;

use Mail;
use Nova\Users\Events\AdminForcedPasswordReset;
use Nova\Users\Mail\SendAdminForcedPasswordResetNotification;

class NotifyUsersOfAdminForcedPasswordReset
{
	public function handle(AdminForcedPasswordReset $event)
	{
		// Get an array of email addresses
		$recipients = $event->users->map(function ($user) {
			return $user->email;
		})->all();

		// Send the email
		Mail::bcc($recipients)->send(new SendAdminForcedPasswordResetNotification);
	}
}

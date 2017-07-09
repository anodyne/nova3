<?php namespace Nova\Users\Listeners;

use Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Nova\Users\Events\AdminForcedPasswordReset;
use Nova\Users\Mail\SendAdminForcedPasswordResetNotification;

class NotifyUsersOfAdminForcedPasswordReset
{
	use InteractsWithQueue;

	public function handle(AdminForcedPasswordReset $event)
	{
		// Send the email
		Mail::bcc($event->recipients)->send(new SendAdminForcedPasswordResetNotification);
	}
}

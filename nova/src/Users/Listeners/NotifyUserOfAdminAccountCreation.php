<?php namespace Nova\Users\Listeners;

use Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Nova\Users\Events\UserWasCreatedByAdmin;
use Nova\Users\Mail\SendUserAccountCreatedNotification;

class NotifyUserOfAdminAccountCreation
{
	use InteractsWithQueue;

	public function handle(UserWasCreatedByAdmin $event)
	{
		// Send the email
		Mail::to($event->user->email)->send(new SendUserAccountCreatedNotification);
	}
}

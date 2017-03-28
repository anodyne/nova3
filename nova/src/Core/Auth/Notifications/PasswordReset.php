<?php namespace Nova\Core\Auth\Notifications;

use Nova\Foundation\Notification;

class PasswordReset extends Notification
{
	public function toArray($notifiable)
	{
		return [];
	}
}

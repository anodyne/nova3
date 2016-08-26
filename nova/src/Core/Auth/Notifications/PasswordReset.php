<?php namespace Nova\Core\Auth\Notifications;

use Nova\Foundation\BaseNotification;

class PasswordReset extends BaseNotification {

	public function toArray($notifiable)
	{
		return [];
	}
}

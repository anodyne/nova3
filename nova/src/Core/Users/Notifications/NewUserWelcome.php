<?php namespace Nova\Core\Users\Notifications;

use Nova\Foundation\BaseNotification;

class NewUserWelcome extends BaseNotification
{
	public function toArray($notifiable)
	{
		return [
			'user_id' => $notifiable->id
		];
	}
}

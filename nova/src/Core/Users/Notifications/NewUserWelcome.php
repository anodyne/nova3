<?php namespace Nova\Core\Users\Notifications;

use Nova\Foundation\Notifications\Notification;

class NewUserWelcome extends Notification
{
	public function toArray($notifiable)
	{
		return [
			'user_id' => $notifiable->id
		];
	}
}

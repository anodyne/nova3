<?php namespace Nova\Core\Characters\Notifications;

class CharacterLinkedToUser
{
	public function via($notifiable)
	{
		return ['database'];
	}

	public function toArray($notifiable)
	{
		return [];
	}
}

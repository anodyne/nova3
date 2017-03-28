<?php namespace Nova\Core\Characters\Notifications;

class CharacterCreated
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

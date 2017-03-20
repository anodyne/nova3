<?php namespace Nova\Foundation;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification as IlluminateNotification;

abstract class Notification extends IlluminateNotification implements ShouldQueue {
	
	use Queueable;

	public function via($notifiable)
	{
		return ['database'];
	}
}

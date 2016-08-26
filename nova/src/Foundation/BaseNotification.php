<?php namespace Nova\Foundation;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

abstract class BaseNotification extends Notification implements ShouldQueue {
	
	use Queueable;

	public function via($notifiable)
	{
		return ['database'];
	}
}

<?php namespace Nova\Foundation\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification as IlluminateNotification;

abstract class Notification extends IlluminateNotification implements ShouldQueue
{
	use Queueable;

	protected $via = ['database'];

	public function via($notifiable)
	{
		return $this->via;
	}
}

<?php

namespace Nova\Foundation\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Nova\Foundation\Mail\SendJobFailedNotification;

class QueuedJobFailed extends Notification
{
	use Queueable;

	protected $jobType;

	public function __construct($jobType)
	{
		$this->jobType = $jobType;
	}

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
		return new SendJobFailedNotification($this->jobType);
    }
}

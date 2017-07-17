<?php namespace Nova\Users\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendUserAccountCreatedNotification extends Mailable
{
	use Queueable, SerializesModels;

	public function build()
	{
		return $this->markdown('emails.users.admin-created-user', ['url' => route('password.request')]);
	}
}

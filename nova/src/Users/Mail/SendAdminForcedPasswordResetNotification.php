<?php namespace Nova\Users\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAdminForcedPasswordResetNotification extends Mailable
{
	use Queueable, SerializesModels;

	public function build()
	{
		return $this->markdown('components.emails.users.admin-forced-password-reset', ['url' => route('password.request')]);
	}
}

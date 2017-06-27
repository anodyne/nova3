<?php namespace Nova\Users\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNewPassword extends Mailable
{
	use Queueable, SerializesModels;

	protected $password;

	public function __construct($password)
	{
		$this->password = $password;
	}

	public function build()
	{
		return $this->markdown('emails.users.password', ['password' => $this->password]);
	}
}

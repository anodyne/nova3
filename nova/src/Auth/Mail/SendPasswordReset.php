<?php namespace Nova\Auth\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPasswordReset extends Mailable
{
	use Queueable, SerializesModels;

	protected $token;

	public function __construct($token)
	{
		$this->token = $token;
	}

	public function build()
	{
		return $this->markdown('components.emails.auth.password-reset', ['token' => $this->token]);
	}
}

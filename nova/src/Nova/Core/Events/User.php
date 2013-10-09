<?php namespace Nova\Core\Events;

use UseMailer as Mailer;

class User {

	protected $mailer;

	public function __construct(Mailer $mailer)
	{
		$this->mailer = $mailer;
	}

	public function onUserCreated($data)
	{
		$this->mailer->created($data);
	}

	public function onPasswordReset($data)
	{
		$this->mailer->passwordReset($data);
	}

}
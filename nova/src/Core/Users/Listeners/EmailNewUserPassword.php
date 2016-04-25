<?php namespace Nova\Core\Users\Listeners;

use UserMailer as Mailer;

class EmailNewUserPassword {

	protected $mailer;

	public function __construct(Mailer $mailer)
	{
		$this->mailer = $mailer;
	}

	public function handle($event)
	{
		$this->mailer->sendNewUserPassword($event->user, $event->password);
	}

}

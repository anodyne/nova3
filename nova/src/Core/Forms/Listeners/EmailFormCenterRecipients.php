<?php namespace Nova\Core\Forms\Listeners;

use FormCenterMailer as Mailer;

class EmailFormCenterRecipients {
	
	protected $mailer;

	public function __construct(Mailer $mailer)
	{
		$this->mailer = $mailer;
	}

	public function handle($event)
	{
		if ($event instanceof Events\FormCenterFormWasCreated)
		{
			$this->mailer->created($event->entry, $event->form);
		}

		if ($event instanceof Events\FormCenterFormWasUpdated)
		{
			$this->mailer->updated($event->entry, $event->form);
		}
	}

}

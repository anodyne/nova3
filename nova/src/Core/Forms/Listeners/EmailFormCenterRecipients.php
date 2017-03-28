<?php namespace Nova\Core\Forms\Listeners;

use Mail;
use FormCenterMailer as Mailer;

class EmailFormCenterRecipients
{
	protected $mailer;

	public function __construct(Mailer $mailer)
	{
		$this->mailer = $mailer;
	}

	public function handle($event)
	{
		if ($event instanceof Events\FormCenterFormWasCreated) {
			Mail::to($event->form->email_recipients)
				->queue(new FormEntryAdded($event->entry, $event->form));
			//$this->mailer->created($event->entry, $event->form);
		}

		if ($event instanceof Events\FormCenterFormWasUpdated) {
			Mail::to($event->form->email_recipients)
				->queue(new FormEntryEdited($event->entry, $event->form));
			//$this->mailer->updated($event->entry, $event->form);
		}
	}
}

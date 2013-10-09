<?php namespace Nova\Core\Events;

use FormViewerMailer as Mailer;

class FormViewer {

	protected $mailer;

	public function __construct(Mailer $mailer)
	{
		$this->mailer = $mailer;
	}

	public function onFormViewerCreated($data)
	{
		$this->mailer->newForm($data);
	}

}
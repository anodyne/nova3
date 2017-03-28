<?php namespace Nova\Foundation;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

abstract class BaseMailable extends Mailable
{
	use Queueable, SerializesModels;

	public function __construct()
	{
		//
	}

	public function subject($subject)
	{
		$subjectPrefix = app('nova.settings')->get('mail_subject_prefix');

		$this->subject = "{$subjectPrefix} {$subject}";

		return $this;
	}

	public function view($view, array $data = [])
	{
		$this->view = locate()->email($view);
		$this->viewData = $data;

		return $this;
	}
}

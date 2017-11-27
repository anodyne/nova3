<?php namespace Nova\Dashboard\Mail;

use Date;
use Nova\Settings\Settings;
use Illuminate\Mail\Mailable;

class SendTestEmail extends Mailable
{
	public function build()
	{
		// Grab the date and format it
		$date = Date::now()->format('F jS Y @ h:ia');

		// Grab the email prefix
		$prefix = Settings::item('mail_subject_prefix')->first()->value;

		return $this->subject("{$prefix} Test Email")
			->markdown('emails.dashboard.test', compact('date'));
	}
}

<?php namespace Nova\Foundation\Services\Mailers;

use Illuminate\Contracts\Mail\Mailer;
use Nova\Foundation\Services\Locator\Locatable;

class BaseMailer
{
	protected $mailer;
	protected $locator;
	protected $settings;

	public function __construct(Mailer $mailer, Locatable $locator)
	{
		$this->mailer = $mailer;
		$this->locator = $locator;
		$this->settings = app('nova.settings');
	}

	final public function raw($text, array $payload)
	{
		// Build the message callback
		$message = $this->buildMessage($payload);

		// Pass the email off to the queue
		return $this->mailer->raw($text, $message);
	}

	final public function send($view, array $payload)
	{
		// Build the message callback
		$message = $this->buildMessage($payload);

		// Pass the email off to the queue
		return $this->mailer->queue($this->locator->email($view), $payload, $message);
	}

	protected function buildMessage(array $payload)
	{
		return function ($message) use ($payload) {
			$calls = ['to', 'cc', 'bcc', 'from', 'replyTo'];

			foreach ($calls as $call) {
				if (array_key_exists($call, $payload)) {
					call_user_func_array([$message, $call], [$payload[$call]]);
				}
			}

			if (array_key_exists('subject', $payload)) {
				$subjectMask = "[%s] %s";

				$message->subject(sprintf(
					$subjectMask,
					app('nova.settings')->mail_subject_prefix,
					$payload['subject']
				));
			}
		};
	}
}

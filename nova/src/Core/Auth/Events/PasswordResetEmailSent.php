<?php namespace Nova\Core\Auth\Events;

use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class PasswordResetEmailSent extends Event {

	use SerializesModels;

	public $email;
	public $timestamp;

	public function __construct($email, $timestamp)
	{
		$this->email = $email;
		$this->timestamp = $timestamp;
	}
}

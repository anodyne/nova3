<?php namespace Nova\Core\Auth\Events;

use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class PasswordResetFailed extends Event
{
	use SerializesModels;

	public $email;
	public $response;
	public $timestamp;

	public function __construct($email, $response, $timestamp)
	{
		$this->email = $email;
		$this->response = $response;
		$this->timestamp = $timestamp;
	}
}

<?php namespace Nova\Core\Auth\Events;

use User;
use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class PasswordResetRequired extends Event
{
	use SerializesModels;

	public $user;
	public $timestamp;

	public function __construct(User $user, $timestamp)
	{
		$this->user = $user;
		$this->timestamp = $timestamp;
	}
}

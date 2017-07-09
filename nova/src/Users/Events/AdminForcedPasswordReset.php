<?php namespace Nova\Users\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AdminForcedPasswordReset
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $recipients;

	public function __construct($recipients)
	{
		$this->recipients = $recipients;
	}
}

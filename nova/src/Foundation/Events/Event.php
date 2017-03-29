<?php namespace Nova\Foundation\Events;

use Illuminate\Queue\SerializesModels;

abstract class Event
{
	use SerializesModels;
}

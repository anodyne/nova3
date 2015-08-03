<?php namespace Nova\Core\Access\Events;

use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class PermissionWasDeleted extends Event {

	use SerializesModels;

	protected $name;
	protected $displayName;

	public function __construct($name, $displayName)
	{
		$this->name = $name;
		$this->displayName = $displayName;
	}

}

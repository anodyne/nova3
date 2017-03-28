<?php namespace Nova\Core\Access\Events;

use Role;
use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class RoleDuplicated extends Event
{
	use SerializesModels;

	protected $oldResource;
	protected $newResource;

	public function __construct(Role $oldResource, Role $newResource)
	{
		$this->oldResource = $oldResource;
		$this->newResource = $newResource;
	}
}

<?php namespace Nova\Core\Access\Events;

use Permission;
use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class PermissionWasUpdated extends Event {

	use SerializesModels;

	protected $resource;

	public function __construct(Permission $resource)
	{
		$this->resource = $resource;
	}

}

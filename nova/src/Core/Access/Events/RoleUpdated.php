<?php namespace Nova\Core\Access\Events;

use Role;
use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class RoleUpdated extends Event
{
	use SerializesModels;

	protected $resource;

	public function __construct(Role $resource)
	{
		$this->resource = $resource;
	}
}

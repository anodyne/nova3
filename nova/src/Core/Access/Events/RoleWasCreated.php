<?php namespace Nova\Core\Access\Events;

use Role;
use Nova\Foundation\Events\Event;
use Illuminate\Queue\SerializesModels;

class RoleWasCreated extends Event {

	use SerializesModels;

	protected $role;

	public function __construct(Role $role)
	{
		$this->role = $role;
	}

}

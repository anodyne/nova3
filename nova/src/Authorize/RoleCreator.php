<?php namespace Nova\Authorize;

use Nova\Foundation\Creator;
use Nova\Authorize\Repositories\RoleRepositoryContract;

class RoleCreator extends Creator
{
	public function __construct(RoleRepositoryContract $repo)
	{
		$this->repo = $repo;
	}

	public function afterCreate()
	{
		// Attach the permissions if we have them
		if (array_key_exists('permissions', $this->data)) {
			$this->item->updatePermissions($this->data['permissions']);
		}
	}
}

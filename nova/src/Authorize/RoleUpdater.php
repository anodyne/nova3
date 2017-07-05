<?php namespace Nova\Authorize;

use Nova\Foundation\Updater;
use Nova\Authorize\Repositories\RoleRepositoryContract;

class RoleUpdater extends Updater
{
	public function __construct(RoleRepositoryContract $repo)
	{
		$this->repo = $repo;
	}

	public function afterUpdate()
	{
		// Attach the permissions if we have them
		if (array_key_exists('permissions', $this->data)) {
			$this->item->updatePermissions($this->data['permissions']);
		}
	}
}

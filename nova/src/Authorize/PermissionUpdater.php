<?php namespace Nova\Authorize;

use Nova\Foundation\Updater;
use Nova\Authorize\Repositories\PermissionRepositoryContract;

class PermissionUpdater extends Updater
{
	public function __construct(PermissionRepositoryContract $repo)
	{
		$this->repo = $repo;
	}
}

<?php namespace Nova\Authorize;

use Nova\Foundation\Creator;
use Nova\Authorize\Repositories\PermissionRepositoryContract;

class PermissionCreator extends Creator
{
	public function __construct(PermissionRepositoryContract $repo)
	{
		$this->repo = $repo;
	}
}

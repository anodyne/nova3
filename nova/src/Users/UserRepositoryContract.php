<?php namespace Nova\Users;

use Nova\Foundation\Repositories\BaseRepositoryContract;

interface UserRepositoryContract extends BaseRepositoryContract
{
	public function all(array $with = [], $trashed = false);
	public function restore($resource);
}

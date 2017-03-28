<?php namespace Nova\Core\Access\Data\Contracts;

use Nova\Foundation\Data\Contracts\BaseRepositoryContract;

interface PermissionRepositoryContract extends BaseRepositoryContract
{
	public function allByComponent();
	public function find($id);
}

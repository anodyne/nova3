<?php namespace Nova\Core\Access\Data\Contracts;

use Nova\Foundation\Data\Contracts\BaseRepositoryContract;

interface RoleRepositoryContract extends BaseRepositoryContract {

	public function duplicate($resource, $newName = null, $newKey = null);
	public function find($id);

}

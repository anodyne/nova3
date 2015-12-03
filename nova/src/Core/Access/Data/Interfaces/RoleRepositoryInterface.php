<?php namespace Nova\Core\Access\Data\Interfaces;

use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface RoleRepositoryInterface extends BaseRepositoryInterface {

	public function duplicate($resource, $newName = null, $newKey = null);
	public function find($id);

}

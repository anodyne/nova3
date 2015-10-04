<?php namespace Nova\Core\Access\Data\Interfaces;

use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface RoleRepositoryInterface extends BaseRepositoryInterface {

	public function duplicate($resource);
	public function find($id);

}

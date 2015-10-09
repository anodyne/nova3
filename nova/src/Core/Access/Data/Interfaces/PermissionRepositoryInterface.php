<?php namespace Nova\Core\Access\Data\Interfaces;

use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface PermissionRepositoryInterface extends BaseRepositoryInterface {

	public function allByComponent();
	public function find($id);

}

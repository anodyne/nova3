<?php namespace Nova\Core\Access\Data\Interfaces;

use Illuminate\Routing\Route;
use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface PermissionRepositoryInterface extends BaseRepositoryInterface {

	public function create(array $data);
	public function delete($id);
	public function find($id);
	public function update($id, array $data);

}

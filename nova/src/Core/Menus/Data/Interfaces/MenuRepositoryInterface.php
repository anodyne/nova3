<?php namespace Nova\Core\Menus\Data\Interfaces;

use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface MenuRepositoryInterface extends BaseRepositoryInterface {

	public function create(array $data);
	public function delete($id, $newId);
	public function find($id);
	public function update($id, array $data);

}

<?php namespace Nova\Core\Menus\Data\Interfaces;

use Menu;
use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface MenuItemRepositoryInterface extends BaseRepositoryInterface {

	public function create(array $data);
	public function delete($id);
	public function find($id);
	public function getMainMenuItems($menu);
	public function getSubMenuItems($menu);
	public function getSubMenuItemsAsArray($menu);
	public function reorder(Menu $menu, array $newPositions);
	public function update($id, array $data);

}

<?php namespace Nova\Core\Menus\Data\Interfaces;

use Menu;
use Illuminate\Support\Collection;
use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface MenuItemRepositoryInterface extends BaseRepositoryInterface {

	public function createDivider(array $data);
	public function find($id);
	public function getMainMenuItems($menu);
	public function getSubMenuItems($menu);
	public function reorder(Menu $menu, array $newPositions);
	public function splitSubMenuItemsIntoArray(Collection $menuItemCollection);

}

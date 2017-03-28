<?php namespace Nova\Core\Menus\Data\Contracts;

use Menu;
use Illuminate\Support\Collection;
use Nova\Foundation\Data\Contracts\BaseRepositoryContract;

interface MenuItemRepositoryContract extends BaseRepositoryContract
{
	public function createDivider(array $data);
	public function find($id);
	public function getMainMenuItems($menu);
	public function getSubMenuItems($menu);
	public function reorder(Menu $menu, array $newPositions);
	public function splitSubMenuItemsIntoArray(Collection $menuItemCollection);
}

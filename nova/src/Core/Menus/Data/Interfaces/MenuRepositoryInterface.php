<?php namespace Nova\Core\Menus\Data\Interfaces;

use Menu;
use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface MenuRepositoryInterface extends BaseRepositoryInterface {

	public function deleteAndUpdate($resource, $newId);
	public function find($id);
	public function getByKey($key);
	public function getPages(Menu $menu);
	public function updatePages(array $pages, $newMenuId);

}

<?php namespace Nova\Core\Menus\Data\Contracts;

use Menu;
use Nova\Foundation\Data\Contracts\BaseRepositoryContract;

interface MenuRepositoryContract extends BaseRepositoryContract
{
	public function deleteAndUpdate($resource, $newId);
	public function find($id);
	public function getByKey($key);
	public function getPages(Menu $menu);
	public function updatePages(array $pages, $newMenuId);
}

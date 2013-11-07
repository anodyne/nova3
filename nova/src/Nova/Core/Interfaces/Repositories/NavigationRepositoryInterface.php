<?php namespace Nova\Core\Interfaces\Repositories;

use BaseRepositoryInterface;

interface NavigationRepositoryInterface extends BaseRepositoryInterface {

	/**
	 * Duplicate a navigation item.
	 *
	 * @param	int		$id			Navigation ID to duplicate
	 * @param	string	$newName	New name of the duplicated item
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	Nav
	 */
	public function duplicate($id, $newName, $setFlash = true);

}
<?php namespace Nova\Core\Interfaces\Repositories;

use BaseRepositoryInterface;

interface NavigationRepositoryInterface extends BaseRepositoryInterface {

	/**
	 * Get all site navigation items by their category.
	 *
	 * @return	array
	 */
	public function allByCategory();

	/**
	 * Get all site navigation items by their type.
	 *
	 * @param	string	$type	The type to get
	 * @return	array
	 */
	public function allByType($type = false);

	/**
	 * Get all site navigation items by their type and category.
	 *
	 * @return	array
	 */
	public function allByTypeAndCategory();

	/**
	 * Duplicate a navigation item.
	 *
	 * @param	int		$id			Navigation ID to duplicate
	 * @param	string	$newName	New name of the duplicated item
	 * @param	bool	$setFlash	Set a flash message?
	 * @return	Nav
	 */
	public function duplicate($id, $newName, $setFlash = true);

	public function getNavTypes();

}
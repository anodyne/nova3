<?php namespace Nova\Core\Interfaces\Repositories;

use BaseRepositoryInterface;

interface SystemRouteRepositoryInterface extends BaseRepositoryInterface {

	/**
	 * Cache the system routes.
	 *
	 * @return	void
	 */
	public function cache();

	/**
	 * Duplicate a system route.
	 *
	 * @param	int		$id			Route ID to duplicate
	 * @param	bool	$setFlash	Set the flash message?
	 * @return	SystemRoute
	 */
	public function duplicate($id, $setFlash = true);

}
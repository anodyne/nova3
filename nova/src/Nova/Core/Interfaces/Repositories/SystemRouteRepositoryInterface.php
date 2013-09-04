<?php namespace Nova\Core\Interfaces\Repositories;

use BaseRepositoryInterface;

interface SystemRouteRepositoryInterface extends BaseRepositoryInterface {

	/**
	 * Duplicate a system route.
	 *
	 * @param	int		$id		Route ID to duplicate
	 * @return	SystemRoute
	 */
	public function duplicate($id);

}
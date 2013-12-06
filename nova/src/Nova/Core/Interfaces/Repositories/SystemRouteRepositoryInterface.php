<?php namespace Nova\Core\Interfaces\Repositories;

use BaseRepositoryInterface;

interface SystemRouteRepositoryInterface extends BaseRepositoryInterface {

	/**
	 * Cache the routes.
	 *
	 * @return	void
	 */
	public function cache();

	/**
	 * Duplicate a route.
	 *
	 * @param	int		$id			Route ID to duplicate
	 * @param	bool	$setFlash	Set the flash message?
	 * @return	SystemRoute
	 */
	public function duplicate($id, $setFlash = true);

	/**
	 * Find a route based on its name.
	 *
	 * @param	string	$name	Route Name
	 * @param	string	$verb	HTTP verb to look for
	 * @param	bool	$count	Return only the count of items
	 * @return	Collection
	 */
	public function findByName($name, $verb = 'get', $count = false);

	/**
	 * Find a route based on its URI.
	 *
	 * @param	string	$uri	Route URI
	 * @param	string	$verb	HTTP verb to look for
	 * @param	bool	$count	Return only the count of items
	 * @return	Collection
	 */
	public function findByUri($uri, $verb = 'get', $count = false);

}
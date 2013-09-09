<?php namespace Nova\Core\Interfaces\Repositories;

use BaseRepositoryInterface;

interface SiteContentRepositoryInterface extends BaseRepositoryInterface {

	/**
	 * Find a specific item by key.
	 *
	 * @param	string	$key		Content key to use
	 * @param	bool	$valueOnly	Return just the value?
	 * @return	mixed
	 */
	public function findByKey($key, $valueOnly = true);

	/**
	 * Find content by the section and controller.
	 *
	 * @param	string	$section	The section to get
	 * @param	string	$controller	The controller to get
	 * @param	bool	$clean		Ignore the cache
	 * @return	Collection
	 */
	public function findBySection($section, $controller, $clean = false);

	public function updateByKey(array $data);

}
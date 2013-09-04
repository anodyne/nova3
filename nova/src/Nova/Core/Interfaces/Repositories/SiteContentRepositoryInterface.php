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

}
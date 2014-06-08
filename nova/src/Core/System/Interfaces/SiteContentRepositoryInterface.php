<?php namespace Nova\Core\System\Interfaces;

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

	/**
	 * Get the site content data for the admin section.
	 *
	 * @param	string	$return		What to return
	 * @return	array
	 */
	public function getForAdmin($return);

	/**
	 * Update the site content with a simple array.
	 *
	 * @param	array	$data	Data for the update
	 */
	public function updateByKey(array $data);

	/**
	 * Update the site content items URI by the old URI.
	 *
	 * @param	string	$oldURI		The old URI
	 * @param	string	$newURI		The new URI
	 * @return	void
	 */
	public function updateUri($oldURI, $newURI);

}
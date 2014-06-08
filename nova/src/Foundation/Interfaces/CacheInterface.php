<?php namespace Nova\Core\Interfaces;

interface CacheInterface {

	/**
	 * Cache the items.
	 *
	 * @param	string	Name of the cache item
	 * @param	mixed	Length (in minutes) to cache; false to cache for forever
	 * @return	void
	 */
	public static function cache($name, $length);

	/**
	 * Clear the cache items.
	 *
	 * @param	string	Name of the cache item to remove
	 * @return	void
	 */
	public static function clearCache($name);

}
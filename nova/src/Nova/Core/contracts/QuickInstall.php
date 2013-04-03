<?php namespace Nova\Core\Contracts;

interface QuickInstall {
	
	/**
	 * Install the item.
	 *
	 * @param	mixed	The location of the item or FALSE to install everything.
	 */
	public static function install($location = false);

	/**
	 * Uninstall all the items.
	 *
	 * @return	void
	 */
	public static function uninstallAll();

	/**
	 * Uninstall the item.
	 *
	 * @return	void
	 */
	public function uninstall();

}
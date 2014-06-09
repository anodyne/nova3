<?php namespace Nova\Foundation\Interfaces;

interface QuickInstallInterface {
	
	/**
	 * Get the path to where this resource is located.
	 *
	 * @return	string
	 */
	public static function getPath();

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
	 * Get the QuickInstall file.
	 *
	 * @param	string	File name
	 * @return	stdClass|bool
	 */
	public function getQuickInstallFile($file);

	/**
	 * Uninstall the item.
	 *
	 * @return	void
	 */
	public function uninstall();

}
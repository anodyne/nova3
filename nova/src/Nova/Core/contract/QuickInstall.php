<?php namespace Nova\Core\Lib\Contract;

interface QuickInstall {
	
	/**
	 * Install the item.
	 *
	 * @param	mixed	The location of the item or FALSE to install everything.
	 */
	public static function install($location = false);

	/**
	 * Uninstall the item.
	 *
	 * @param	string	The location of the item.
	 */
	public static function uninstall($location);

}
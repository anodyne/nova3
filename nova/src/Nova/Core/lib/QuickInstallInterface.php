<?php
/**
 * The QuickInstall interface provides guidelines for how to implement
 * the ability to use QuickInstall for anything. Simply implement the
 * methods and call the methods where you need them.
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Interface
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova\Core\Lib;

interface QuickInstallInterface {
	
	/**
	 * Install the item.
	 *
	 * @api
	 * @param	mixed	The location of the item or NULL to install everything.
	 */
	public static function install($location = null);

	/**
	 * Uninstall the item.
	 *
	 * @api
	 * @param	string	The location of the item.
	 */
	public static function uninstall($location);
}

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

interface SearchInterface {
	
	public function search($term);
}

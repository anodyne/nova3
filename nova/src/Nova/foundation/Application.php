<?php namespace Nova\Foundation;

/**
 * The Application is extended from the Laravel Application because
 * of a change to Laravel that hardcoded the config loader in. Instead
 * of making the simple change in the Laravel core, we've been told
 * we have to extend the Application class and do it ourselves.
 * Absolute foolishness.
 *
 * @package		Nova
 * @subpackage	Foundation
 * @category	Class
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

use Illuminate\Foundation\Application as LaravelApplication;

class Application extends LaravelApplication {

	/**
	 * Get the configuration loader instance.
	 *
	 * @return \Nova\Foundation\Config\LoaderInterface
	 */
	public function getConfigLoader()
	{
		return $this->make('config.loader');
	}

}
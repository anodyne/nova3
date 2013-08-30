<?php namespace Nova\Core\Lib;

use File;
use Cache;
use Sentry;
use Request;
use Settings;
use Nova\Extensions\Laravel\Application;

class Nova {

	public function __construct(Application $app)
	{
		$this->app = $app;
	}
	
	/**
	 * Pulls the web font index arrays from the base as well as the current skin.
	 *
	 * @param	string	$skin	The current skin
	 * @return 	array
	 */
	public function getIconIndex($skin)
	{
		// Load the icon index from the core first
		$commonIndex = $this->app['files']->getRequire(NOVAPATH.'views/icons.php');

		// Now load the icon index from the skin (if it has one)
		$skinIndex = ($this->app['files']->exists(APPPATH."skins/{$skin}/icons.php"))
			? $this->app['files']->getRequire(APPPATH."views/{$skin}/icons.php")
			: [];
		
		// Merge the files into an array
		return array_merge((array) $commonIndex, (array) $skinIndex);
	}

	/**
	 * Get the current rank set, whether it's the user's preference or the
	 * system default.
	 *
	 * @return	string
	 */
	public function getRank()
	{
		if (Sentry::check())
		{
			return Sentry::getUser()->getPreferenceItem('rank');
		}

		return Settings::getSettings('rank');
	}

	/**
	 * Get the current skin for a given section, whether it's the user's
	 * preference or the system default.
	 *
	 * @param	string	The section
	 * @return	string
	 */
	public function getSkin($section = false)
	{
		if (Cache::get('nova.installed') !== null)
		{
			if ($section === false)
			{
				// Figure out what section we're in
				$section = (Request::is('admin/*')) ? 'admin' : 'main';
			}

			if (Sentry::check())
			{
				return Sentry::getUser()->getPreferenceItem("skin_{$section}");
			}

			return Settings::getSettings("skin_{$section}");
		}
	}

}
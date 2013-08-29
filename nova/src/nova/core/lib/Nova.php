<?php namespace nova\core\lib;

use File;
use Cache;
use Sentry;
use Request;
use Settings;

class Nova {
	
	/**
	 * Pulls the web font index arrays from the base as well as the current skin.
	 *
	 * @param	string	The current skin
	 * @return 	array
	 */
	public function getIconIndex($skin)
	{
		// Load the icon index from the core first
		$commonIndex = include SRCPATH.'core/views/icons.php';

		// Now load the icon index from the skin (if it has one)
		$skinIndex = (File::exists(APPPATH."views/{$skin}/icons.php"))
			? include_once APPPATH."views/{$skin}/icons.php"
			: array();
		
		// Merge the files into an array
		$iconIndex = array_merge((array) $commonIndex, (array) $skinIndex);
		
		return $iconIndex;
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
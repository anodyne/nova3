<?php namespace Nova\Foundation\Utilities;

use App,
	File,
	Cache,
	Config,
	Request;

class Nova {

	public function __construct()
	{
		$this->auth			= $this->resolveBinding('NovaAuthInterface');
		$this->settings		= $this->resolveBinding('SettingsRepositoryInterface');
		$this->currentUser	= $this->auth->getUser();
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
		$commonIndex = File::getRequire(NOVAPATH.'views/icons.php');

		// Now load the icon index from the skin (if it has one)
		$skinIndex = (File::exists(APPPATH."skins/{$skin}/icons.php"))
			? File::getRequire(APPPATH."skins/{$skin}/icons.php")
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
		if ($this->auth->check())
		{
			return $this->auth->getUser()->getPreferenceItem('rank');
		}

		return $this->settings->findByKey('rank');
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

			if ($this->auth->check())
			{
				return $this->auth->getUser()->getPreferenceItem("skin_{$section}");
			}

			return $this->settings->findByKey("skin_{$section}");
		}
	}

	/**
	 * Resolve a binding out of the Application container.
	 *
	 * @param	string	$alias	The interface alias
	 * @return	object
	 */
	public function resolveBinding($alias)
	{
		// Get the aliases
		$classes = Config::get('app.aliases');

		return App::make($classes[$alias]);
	}

}
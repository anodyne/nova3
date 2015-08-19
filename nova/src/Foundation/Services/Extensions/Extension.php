<?php namespace Nova\Foundation\Services\Extensions;

use Illuminate\Contracts\Foundation\Application;

class Extension implements Extensible, ExtensibleInfo {

	protected $app;
	protected $name;
	protected $author;
	protected $credits;
	protected $version;
	protected $location;

	public function __construct($location, Application $app)
	{
		// Grab the JSON file and parse it
		$extension = json_decode(file_get_contents($app->extensionPath($location).'/extension.json'));

		// Assign the remaining properties
		$this->app 		= $app;
		$this->name 	= $extension->name;
		$this->author	= $extension->author;
		$this->credits 	= $extension->credits;
		$this->version 	= $extension->version;
		$this->location = $extension->location;

		// Allow for some initializing
		$this->initialize();
	}

	/**
	 * Method that allows for doing some initialization work for the extension
	 * that doesn't require overriding the class constructor. This is called
	 * after everything else in the constructor is called.
	 *
	 * @return	void
	 */
	protected function initialize()
	{
		$this->loadConfig();

		$this->loadFileRoutes();
	}

	protected function loadConfig()
	{
		// Build the path to the extension
		$pathToExtension = extension_path($this->location);

		if (file_exists($pathToExtension.'/config.php'))
		{
			// Grab the config array
			$configArrValues = require $pathToExtension.'/config.php';

			// Build the config array key
			list($vendor, $name) = explode('/', $this->location);
			$configArrKey = 'extension.'.strtolower($vendor).'.'.strtolower($name);

			// Dump it into the global config
			config([$configArrKey => $configArrValues]);
		}
	}

	protected function loadFileRoutes()
	{
		// Build the path to the extension
		$pathToExtension = extension_path($this->location);

		if (file_exists($pathToExtension.'/routes.php'))
		{
			require $pathToExtension.'/routes.php';
		}
	}

	/**
	 * Get the author of the extension.
	 *
	 * @return	string
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * Get the extension credits as straight text or parsed Markdown.
	 *
	 * @param	bool	$raw	Get the unparsed credits?
	 * @return	string
	 */
	public function getCredits($raw = false)
	{
		if ($raw) return $this->credits;

		return $this->app['nova.markdown']->parse($this->credits);
	}

	/**
	 * Get the full name of the extension.
	 *
	 * @return	string
	 */
	public function getFullName()
	{
		return $this->name;
	}

	/**
	 * Get the name of the extension folder or the full path to the extension.
	 *
	 * @param	bool	$raw	Get only the extension folder name?
	 * @return	string
	 */
	public function getLocation($raw = false)
	{
		if ($raw) return $this->location;

		return $this->app->extensionPath("{$this->vendor}/{$this->location}");
	}

	/**
	 * Get the vendor of the extension.
	 *
	 * @return	string
	 */
	public function getVendor()
	{
		return $this->vendor;
	}

	/**
	 * Get the version of the extension.
	 *
	 * @return	string
	 */
	public function getVersion()
	{
		return $this->version;
	}

	public function install()
	{
		return false;
	}
	
	public function uninstall()
	{
		return false;
	}

}

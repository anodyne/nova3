<?php namespace Nova\Foundation\Services\Extensions;

class Extension implements Extensible, ExtensibleInfo {

	protected $app;
	protected $name;
	protected $author;
	protected $vendor;
	protected $credits;
	protected $version;
	protected $location;

	public function __construct($extensionName, Application $app)
	{
		// Grab the JSON file and parse it
		$extension = json_decode(file_get_contents($app->extensionPath($extensionName).'/extension.json'));

		// Assign the remaining properties
		$this->app 		= $app;
		$this->name 	= $extension->name;
		$this->author	= $extension->author;
		$this->vendor 	= $extension->vendor;
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
	protected function initialize(){}

	public function loadConfig()
	{
		# code...
	}

	public function loadFileRoutes()
	{
		# code...
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

}
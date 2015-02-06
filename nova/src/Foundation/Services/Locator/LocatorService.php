<?php namespace Nova\Foundation\Services\Locator;

use Str, User;
use Symfony\Component\Finder\Finder;
use Dflydev\Symfony\FinderFactory\FinderFactory,
	Dflydev\Symfony\FinderFactory\FinderFactoryInterface;

class LocatorService {

	/**
	 * @var	array	Array of paths to search through
	 */
	protected $paths = [
		'extensions/Override/views/components',
		'themes/%theme%/components',
		'nova/views/components',
	];

	/**
	 * @var	array	Array of extensions to search through
	 */
	protected $extensions = [
		'.blade.php',
		'.php',
	];

	/**
	 * @var	User	The current user
	 */
	protected $user;

	/**
	 * @var	object	An object of all the settings
	 */
	protected $settings;

	/**
	 * @var	FinderFactory	Factory of the Symfony Finder
	 */
	protected $finderFactory;

	public function __construct(User $user = null, $settings = null,
			FinderFactoryInterface $finderFactory = null)
	{
		$this->user				= $user;
		$this->settings 		= $settings;
		$this->finderFactory	= $finderFactory ?: new FinderFactory;
	}

	/**
	 * Search for a ajax view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function ajax($file)
	{
		return $this->performSearch('ajax', $file);
	}

	/**
	 * Search for a javascript view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function javascript($file)
	{
		return $this->performSearch('js', $file);
	}

	/**
	 * Magic method that will catch methods that haven't been explicitly created.
	 *
	 * @param	string	$method	The method being attempted to be called
	 * @param	array	$args	The array of arguments passed to the method
	 * @return	string
	 */
	public function __call($method, $args)
	{
		if ( ! method_exists($this, $method))
		{
			return $this->performSearch(Str::plural($method), $args[0]);
		}
	}

	/**
	 * Get the extensions being searched.
	 *
	 * @return	array
	 */
	public function getExtensions()
	{
		return $this->extensions;
	}

	/**
	 * Get the paths being searched.
	 *
	 * @return	array
	 */
	public function getPaths()
	{
		return $this->paths;
	}

	/**
	 * Set the extensions to be searched.
	 *
	 * @param	array	$data
	 */
	public function setExtensions(array $data)
	{
		$this->extensions = $data;
	}

	/**
	 * Set the paths to be searched.
	 *
	 * @param	array	$data
	 */
	public function setPaths(array $data)
	{
		$this->paths = $data;
	}

	/**
	 * Search through the paths and extensions to find the right file.
	 *
	 * @internal
	 * @param	string	$type	The type of file to find
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 * @throws	LocatorException
	 */
	protected function performSearch($type, $file)
	{
		// Spin up a new instance of the finder
		$finder = $this->finderFactory->createFinder();

		// Make sure we're only returning files
		$finder->files();

		$additionalPath = false;

		if (Str::contains($file, '/'))
		{
			// Break out into the individual pieces
			$fileParts = explode('/', $file);

			// Update the filename
			$file = end($fileParts);

			// Drop the last element (the filename) off the array
			array_pop($fileParts);

			// Make a string out of the remaining pieces
			$additionalPath = implode('/', $fileParts);
		}

		// Loop through the paths and add them if they exist
		foreach ($this->paths as $path)
		{
			// Set the proper theme
			$path = str_replace('%theme%', $this->findCurrentTheme(), $path);

			// Build the final path
			$finalPath = "{$path}/{$type}";
			$finalPath = ( ! empty($additionalPath)) ? $finalPath."/{$additionalPath}" : $finalPath;

			$this->addPath($finalPath, $finder);
		}

		// Loop through the extensions and set the names we want to look for
		foreach ($this->extensions as $extension)
		{
			$finder->name($file.$extension);
		}

		if ($finder->count() == 0)
		{
			// Uh-oh! We didn't find anything, so throw an exception
			throw new LocatorException("The file [{$type}/{$file}] couldn't be found.");
		}

		// Turn the iterator into an array
		$finderArr = iterator_to_array($finder);

		// Return the first key (relative path to the file)
		$finalFilename = array_keys($finderArr)[0];

		foreach ($this->extensions as $extension)
		{
			$finalFilename = str_replace($extension, '', $finalFilename);
		}

		return $finalFilename;
	}

	/**
	 * Check the path to make sure it exists before trying to use it for a search.
	 *
	 * @internal
	 * @param	string	$path	The path to check
	 * @param	Finder	$finder	Instance of the Finder (passed by reference)
	 * @return	void
	 */
	protected function addPath($path, Finder &$finder)
	{
		if (is_dir($path))
		{
			$finder->in($path);
		}
	}

	/**
	 * Figure out what the current theme is.
	 *
	 * @internal
	 * @return	string
	 */
	protected function findCurrentTheme()
	{
		if ( ! app('nova.setup')->isInstalled()) return false;

		if ($this->user) return $this->user->getPreference('theme');

		return $this->settings->theme;
	}

}
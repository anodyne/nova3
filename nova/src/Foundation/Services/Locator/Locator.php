<?php namespace Nova\Foundation\Services\Locator;

use Str, User;
use Symfony\Component\Finder\Finder;
use Dflydev\Symfony\FinderFactory\FinderFactory,
	Dflydev\Symfony\FinderFactory\FinderFactoryInterface;

class Locator implements LocatorInterface {

	/**
	 * @var	array	Array of paths to search through
	 */
	protected $paths = [];

	/**
	 * @var	array	Array of paths to search through first
	 */
	protected $pathsFirst = [
		'extensions/Override/views/components',
		'themes/%theme%/components',
	];

	/**
	 * @var	array	Array of paths to search through between first and last
	 */
	protected $pathsAdditional = [];

	/**
	 * @var	array	Array of paths to search through last
	 */
	protected $pathsLast = [
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
	 * Search for an ajax view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function ajax($file)
	{
		return $this->performSearch('ajax', $file);
	}

	/**
	 * Search for an email view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function email($file)
	{
		return $this->performSearch('emails', $file);
	}

	/**
	 * Search for an error view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function error($file)
	{
		return $this->performSearch('errors', $file);
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
	 * Search for a page view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function page($file)
	{
		return $this->performSearch('pages', $file);
	}

	/**
	 * Search for a partial view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function partial($file)
	{
		return $this->performSearch('partials', $file);
	}

	/**
	 * Search for a structure view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function structure($file)
	{
		return $this->performSearch('structures', $file);
	}

	/**
	 * Search for a style view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function style($file)
	{
		return $this->performSearch('styles', $file);
	}

	/**
	 * Search for a template view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function template($file)
	{
		return $this->performSearch('templates', $file);
	}

	/**
	 * Get the file extensions being used in the search.
	 *
	 * @return	array
	 */
	public function getExtensions()
	{
		return $this->extensions;
	}

	/**
	 * Get the paths being used in the search.
	 *
	 * @return	array
	 */
	public function getPaths()
	{
		return $this->paths;
	}

	/**
	 * Register a new search path for the locator.
	 *
	 * @param	string	$path
	 * @return	void
	 */
	public function registerSearchPath($path)
	{
		array_push($this->pathsAdditional, $path);
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

		// Compile the paths to search
		$this->compilePaths();

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

		if ($this->user) return $this->user->preference('theme');

		return $this->settings->theme;
	}

	/**
	 * Compile the different paths into the final list to search.
	 *
	 * @internal
	 * @return	array
	 */
	protected function compilePaths()
	{
		$this->paths = array_merge($this->pathsFirst, $this->pathsAdditional, $this->pathsLast);

		return $this->paths;
	}

}

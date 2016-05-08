<?php namespace Nova\Foundation\Services\Locator;

use Str, User;
use Illuminate\Support\Collection;
use Symfony\Component\Finder\Finder;
use Dflydev\Symfony\FinderFactory\{FinderFactory, FinderFactoryInterface};

class Locator implements Locatable {

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
		'nova/resources/views/components',
		'nova/resources',
	];

	/**
	 * @var	array	Array of extensions to search through
	 */
	protected $extensions = [
		'.blade.php',
		'.php',
		'.css',
		'.js',
	];

	/**
	 * @var	User	The current user
	 */
	protected $user;

	/**
	 * @var	Collection	A Collection of all the settings
	 */
	protected $settings;

	/**
	 * @var	FinderFactory	Factory of the Symfony Finder
	 */
	protected $finderFactory;

	public function __construct(User $user = null, Collection $settings = null,
			FinderFactoryInterface $finderFactory = null)
	{
		$this->user				= $user;
		$this->settings 		= $settings;
		$this->finderFactory	= $finderFactory ?: new FinderFactory;

		// Compile the paths to search
		$this->compilePaths();
	}

	/**
	 * Search for an ajax view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function ajax($file): string
	{
		return $this->performSearch('ajax', $file);
	}

	/**
	 * Check to see if an ajax view file exists.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	bool
	 */
	public function ajaxExists($file): bool
	{
		return $this->exists('ajax', $file);
	}

	/**
	 * Search for an email view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function email($file): string
	{
		return $this->performSearch('emails', $file);
	}

	/**
	 * Check to see if an email view file exists.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	bool
	 */
	public function emailExists($file): bool
	{
		return $this->exists('emails', $file);
	}

	/**
	 * Search for an error view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function error($file): string
	{
		return $this->performSearch('errors', $file);
	}

	/**
	 * Check to see if an error view file exists.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	bool
	 */
	public function errorExists($file): bool
	{
		return $this->exists('errors', $file);
	}

	/**
	 * Check to see if a view file exists.
	 *
	 * @param	string	$type	The type of file to find
	 * @param	string	$file	The file to find (no extension)
	 * @return	bool
	 */
	public function exists($type, $file): bool
	{
		return $this->performSearch($type, $file, false);
	}

	/**
	 * Search for a javascript view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function javascript($file): string
	{
		return $this->performSearch('js', $file);
	}

	/**
	 * Check to see if a javascript view file exists.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	bool
	 */
	public function javascriptExists($file): bool
	{
		return $this->exists('js', $file);
	}

	/**
	 * Search for a page view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function page($file): string
	{
		return $this->performSearch('pages', $file);
	}

	/**
	 * Check to see if a page view file exists.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	bool
	 */
	public function pageExists($file): bool
	{
		return $this->exists('pages', $file);
	}

	/**
	 * Search for a partial view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function partial($file): string
	{
		return $this->performSearch('partials', $file);
	}

	/**
	 * Check to see if a partial view file exists.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	bool
	 */
	public function partialExists($file): bool
	{
		return $this->exists('partials', $file);
	}

	/**
	 * Search for a structure view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function structure($file): string
	{
		return $this->performSearch('structures', $file);
	}

	/**
	 * Check to see if a structure view file exists.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	bool
	 */
	public function structureExists($file): bool
	{
		return $this->exists('structures', $file);
	}

	/**
	 * Search for a style view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function style($file): string
	{
		return $this->performSearch('css', $file);
	}

	/**
	 * Check to see if a style view file exists.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	bool
	 */
	public function styleExists($file): bool
	{
		return $this->exists('styles', $file);
	}

	/**
	 * Search for a template view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function template($file): string
	{
		return $this->performSearch('templates', $file);
	}

	/**
	 * Check to see if a template view file exists.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	bool
	 */
	public function templateExists($file): bool
	{
		return $this->exists('templates', $file);
	}

	/**
	 * Get the file extensions being used in the search.
	 *
	 * @return	array
	 */
	public function getExtensions(): array
	{
		return $this->extensions;
	}

	/**
	 * Get the paths being used in the search.
	 *
	 * @return	array
	 */
	public function getPaths(): array
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
		$this->pathsAdditional[] = $path;

		// Re-compile the paths to search
		$this->compilePaths();
	}

	/**
	 * Search through the paths and extensions to find the right file.
	 *
	 * @internal
	 * @param	string	$type			The type of file to find
	 * @param	string	$file			The file to find (no extension)
	 * @param	bool	$throwOnMissing	Throw an exception if the file couldn't be found?
	 * @return	string
	 * @throws	LocatorException
	 */
	protected function performSearch($type, $file, $throwOnMissing = true)
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
			if ( ! $throwOnMissing)
			{
				return false;
			}

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
		if ( ! nova()->isInstalled())
		{
			return false;
		}

		if ($this->user)
		{
			return $this->user->preference('theme');
		}

		return $this->settings->get('theme');
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

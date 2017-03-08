<?php namespace Nova\Foundation;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\ProviderRepository,
	Illuminate\Foundation\Application as IlluminateApp;

class Application extends IlluminateApp {

	/**
	 * Bind all of the application paths in the container.
	 *
	 * @return	$this
	 */
	protected function bindPathsInContainer()
	{
		parent::bindPathsInContainer();

		// The paths established by the Nova core
		$novaPaths = ['asset', 'coreAsset', 'coreConfig', 'coreLang', 'coreResources',
			'extension', 'nova', 'rank', 'theme', 'themeRelative'];

		foreach ($novaPaths as $path) {
			$this->instance('path.'.$path, $this->{$path.'Path'}());
		}
	}

	/**
	 * Get the path to the application directory.
	 *
	 * @return	string
	 */
	public function path()
	{
		return $this->novaPath('src');
	}

	/**
	 * Get the path to the assets directory.
	 *
	 * @param	string	$asset	An asset to append
	 * @return	string
	 */
	public function assetPath($asset = false)
	{
		$segments = [$this->basePath, 'assets'];

		if ($asset) {
			$segments[] = $asset;
		}

		return join(DIRECTORY_SEPARATOR, $segments);
	}

	/**
	 * Get the path to the bootstrap directory.
	 *
	 * @return string
	 */
	public function bootstrapPath()
	{
		return join(DIRECTORY_SEPARATOR, [$this->basePath, 'nova', 'bootstrap']);
	}

	/**
	 * Get the path to the assets directory inside Nova.
	 *
	 * @param	string	$asset	An asset to append
	 * @return	string
	 */
	public function coreAssetPath($asset = false)
	{
		$segments = [$this->novaPath(), 'resources'];

		if ($asset) {
			$segments[] = $asset;
		}

		return join(DIRECTORY_SEPARATOR, $segments);
	}

	/**
	 * Get the path to the config directory inside Nova.
	 *
	 * @return	string
	 */
	public function coreConfigPath()
	{
		return $this->novaPath('config');
	}

	/**
	 * Get the path to the lang directory inside Nova.
	 *
	 * @return	string
	 */
	public function coreLangPath()
	{
		return join(DIRECTORY_SEPARATOR, ['nova', 'resources', 'lang']);
	}

	/**
	 * Get the path to the lang directory inside Nova.
	 *
	 * @return	string
	 */
	public function coreResourcesPath()
	{
		return join(DIRECTORY_SEPARATOR, [$this->basePath, 'nova', 'resources']);
	}

	/**
	 * Get the path to the database directory.
	 *
	 * @return	string
	 */
	public function databasePath()
	{
		return join(DIRECTORY_SEPARATOR, [$this->novaPath(), 'src', 'Setup', 'database']);
	}

	/**
	 * Get the path to the extensions directory.
	 *
	 * @param	string	$identifier	An extension vendor/name identifier to use
	 * @return	string
	 */
	public function extensionPath($identifier = false)
	{
		if ($identifier) {
			list($vendor, $name) = explode('/', $identifier);

			return $this->basePath."/extensions/{$vendor}/{$name}";
		}

		return $this->basePath.'/extensions';
	}

	/**
	 * Get the path to the language files.
	 *
	 * @return	string
	 */
	public function langPath()
	{
		return join(DIRECTORY_SEPARATOR, ['resources', 'lang']);
	}

	/**
	 * Get the path to the nova directory.
	 *
	 * @param	mixed	$location	A location within the nova directory
	 * @return	string
	 */
	public function novaPath($location = false)
	{
		$segments = [$this->basePath, 'nova'];

		if ($location) {
			$segments[] = $location;
		}

		return join(DIRECTORY_SEPARATOR, $segments);
	}

	/**
	 * Get the path to the public / web directory.
	 *
	 * @return	string
	 */
	public function publicPath()
	{
		return $this->basePath;
	}

	/**
	 * Get the path to the ranks directory.
	 *
	 * @param	string	$location	A rank set location to append
	 * @return	string
	 */
	public function rankPath($location = false)
	{
		$segments = [$this->basePath, 'ranks'];

		if ($location) {
			$segments[] = $location;
		}

		return join(DIRECTORY_SEPARATOR, $segments);
	}

	/**
	 * Get the path to the resources directory.
	 *
	 * @return string
	 */
	public function resourcePath()
	{
		return join(DIRECTORY_SEPARATOR, [$this->basePath, 'resources']);
	}

	/**
	 * Get the path to the themes directory.
	 *
	 * @param	string	$location	A theme location to append
	 * @return	string
	 */
	public function themePath($location = false)
	{
		$segments = [$this->basePath, 'themes'];

		if ($location) {
			$segments[] = $location;
		}

		return join(DIRECTORY_SEPARATOR, $segments);
	}

	/**
	 * Get the relative path to the themes directory.
	 *
	 * @param	string	$location	A theme location to append
	 * @return	string
	 */
	public function themeRelativePath($location = false)
	{
		$segments = ['themes'];

		if ($location) {
			$segment[] = $location;
		}

		return join(DIRECTORY_SEPARATOR, $segments);
	}

	public function buildStorageDirectory()
	{
		$directories = [
			'logs'
		];

		foreach ($directories as $dir) {
			$this->app['files']->makeDirectory(storage_path($dir));
		}
	}

	public function setDirectoryPermissions()
	{
		$directories = [
			storage_path('logs'),
			storage_path('framework'.DIRECTORY_SEPARATOR.'cache'),
			storage_path('framework'.DIRECTORY_SEPARATOR.'sessions'),
			storage_path('framework'.DIRECTORY_SEPARATOR.'views'),
		];

		foreach ($directories as $dir) {
			if ( ! $this->app['files']->isWritable($dir)) {
				dd("The [$dir] directory is not writable and must be for Laravel to work. Please set the permissions on this directory to 777.");
			}
		}
	}
}

<?php namespace Nova\Foundation;

use Illuminate\Foundation\Application as IlluminateApp;

class Application extends IlluminateApp {

	/**
	 * Bind all of the application paths in the container.
	 *
	 * @return	$this
	 */
	protected function bindPathsInContainer()
	{
		$this->instance('path', $this->path());

		// The paths established by the Laravel core
		$corePaths = ['base', 'config', 'database', 'lang', 'public', 'storage'];

		// The paths established by the Nova core
		$novaPaths = ['asset', 'coreAsset', 'coreConfig', 'extension', 'nova',
			'rank', 'theme'];

		// Combine the core paths with our own
		$paths = array_merge($corePaths, $novaPaths);

		foreach ($paths as $path)
		{
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
		if ($asset) return $this->basePath."/assets/$asset";

		return $this->basePath.'/assets';
	}

	/**
	 * Get the path to the assets directory inside Nova.
	 *
	 * @param	string	$asset	An asset to append
	 * @return	string
	 */
	public function coreAssetPath($asset = false)
	{
		if ($asset) return $this->novaPath("assets/$asset");

		return $this->novaPath('assets');
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
	 * Get the path to the database directory.
	 *
	 * @return	string
	 */
	public function databasePath()
	{
		return $this->novaPath('src/Setup/database');
	}

	/**
	 * Get the path to the extensions directory.
	 *
	 * @param	string	$identifier	An extension vendor/name identifier to use
	 * @return	string
	 */
	public function extensionPath($identifier = false)
	{
		if ($identifier)
		{
			list($vendor, $name) = explode('.', $identifier);

			return $this->basePath."/extensions/{ucfirst($vendor)}/{ucfirst($name)}";
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
		return $this->novaPath('lang');
	}

	/**
	 * Get the path to the nova directory.
	 *
	 * @param	mixed	$location	A location within the nova directory
	 * @return	string
	 */
	public function novaPath($location = false)
	{
		if ($location) return $this->basePath."/nova/$location";

		return $this->basePath.'/nova';
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
		if ($location) return $this->basePath."/ranks/$location";

		return $this->basePath.'/ranks';
	}

	/**
	 * Get the path to the themes directory.
	 *
	 * @param	string	$location	A theme location to append
	 * @return	string
	 */
	public function themePath($location = false)
	{
		if ($location) return $this->basePath."/themes/$location";

		return $this->basePath.'/themes';
	}

}
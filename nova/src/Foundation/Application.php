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
		$this->instance('path', $this->path());

		// The paths established by the Laravel core
		$corePaths = ['base', 'config', 'database', 'lang', 'public', 'storage'];

		// The paths established by the Nova core
		$novaPaths = ['asset', 'coreAsset', 'coreConfig', 'extension', 'nova',
			'rank', 'theme', 'themeRelative'];

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
		if ($asset) return $this->novaPath("resources/$asset");

		return $this->novaPath('resources');
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
		return $this->novaPath('resources/lang');
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

	/**
	 * Get the relative path to the themes directory.
	 *
	 * @param	string	$location	A theme location to append
	 * @return	string
	 */
	public function themeRelativePath($location = false)
	{
		if ($location) return "themes/$location";

		return 'themes';
	}

	public function buildStorageDirectory()
	{
		$directories = [
			'logs'
		];

		foreach ($directories as $dir)
		{
			$this->app['files']->makeDirectory(storage_path($dir));
		}
	}

	public function setDirectoryPermissions()
	{
		$directories = [
			storage_path('logs'),
			storage_path('framework/cache'),
			storage_path('framework/sessions'),
			storage_path('framework/views'),
		];

		foreach ($directories as $dir)
		{
			if ( ! $this->app['files']->isWritable($dir))
			{
				dd("The [$dir] directory is not writable and must be for Laravel to work. Please set the permissions on this directory to 777.");
				//throw new RuntimeException("The [$directory] directory is not writable. Please make sure you set permissions on the directory.");
				//exec(escapeshellcmd("chmod 775 $directory"));
			}
		}
	}

	/**
	 * Get the path to the configuration cache file.
	 *
	 * @return string
	 */
	public function getCachedConfigPath()
	{
		if ($this->vendorIsWritableForOptimizations())
		{
			return $this->basePath().'/nova/vendor/config.php';
		}
		else
		{
			return $this['path.storage'].'/framework/config.php';
		}
	}

	/**
	 * Get the path to the routes cache file.
	 *
	 * @return string
	 */
	public function getCachedRoutesPath()
	{
		if ($this->vendorIsWritableForOptimizations())
		{
			return $this->basePath().'/nova/vendor/routes.php';
		}
		else
		{
			return $this['path.storage'].'/framework/routes.php';
		}
	}

	/**
	 * Get the path to the cached "compiled.php" file.
	 *
	 * @return string
	 */
	public function getCachedCompilePath()
	{
		if ($this->vendorIsWritableForOptimizations())
		{
			return $this->basePath().'/nova/vendor/compiled.php';
		}
		else
		{
			return $this->storagePath().'/framework/compiled.php';
		}
	}

	/**
	 * Get the path to the cached services.json file.
	 *
	 * @return string
	 */
	public function getCachedServicesPath()
	{
		if ($this->vendorIsWritableForOptimizations())
		{
			return $this->basePath().'/nova/vendor/services.json';
		}
		else
		{
			return $this->storagePath().'/framework/services.json';
		}
	}

	/**
	 * Determine if vendor path is writable.
	 *
	 * @return bool
	 */
	public function vendorIsWritableForOptimizations()
	{
		if ($this->useStoragePathForOptimizations) return false;

		return is_writable($this->basePath().'/nova/vendor');
	}

}

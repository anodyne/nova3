<?php namespace Nova\Setup\Services;

use PDO;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Foundation\Application;

class SetupService {

	protected $app;

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	/**
	 * Run some basic checks on the server to make sure we can install
	 * Nova properly.
	 *
	 * @return	Collection
	 */
	public function checkEnvironment()
	{
		$checks = new Collection([
			'passes'			=> true,
			'php'				=> true,
			'writableDirs'		=> true,
			'writableDirsFull'	=> [],
			'pdo'				=> true,
			'pdoDrivers'		=> true,
			'pdoDriversFull'	=> [],
		]);

		// PHP version
		if (version_compare(PHP_VERSION, '5.5.0', '<'))
		{
			$checks->put('php', false);
			$checks->put('passes', false);
		}

		// Writable directories
		$directories = [
			storage_path(),
			storage_path('logs'),
			storage_path('app'),
			storage_path('framework/cache'),
			storage_path('framework/sessions'),
			storage_path('framework/views'),
			app('path.config'),
		];

		$errorDirs = [];

		foreach ($directories as $dir)
		{
			if ( ! is_writable($dir))
			{
				$errorString = str_replace(base_path(), '', $dir);
				$errorString.= ' ('.substr(sprintf('%o', fileperms($dir)), -4).')';
				$errorDirs[] = $errorString;

				$checks->put('writableDirs', false);
				$checks->put('passes', false);
			}
		}

		if ( ! $checks->get('writableDirs'))
			$checks->put('writableDirsFull', $errorDirs);

		// PDO
		if ( ! defined('PDO::ATTR_DRIVER_NAME'))
		{
			$checks->put('pdo', false);
			$checks->put('passes', false);
		}

		// MySQL and/or Postgres
		if ( ! in_array('mysql', PDO::getAvailableDrivers()) and ! in_array('pgsql', PDO::getAvailableDrivers()))
		{
			$checks->put('pdoDrivers', false);
			$checks->put('passes', false);
			$checks->put('pdoDriversFull', PDO::getAvailableDrivers());
		}

		return $checks;
	}

	/**
	 * Check to see if a component is configured.
	 *
	 * @param	string	$component
	 * @return	bool
	 */
	public function isConfigured($component)
	{
		if ($component == 'db')
		{
			if (file_exists($this->app->configPath().'/database.php')) return true;

			return false;
		}

		if ($component == 'mail')
		{
			if (file_exists($this->app->configPath().'/mail.php')) return true;

			return false;
		}

		if ($component == 'session')
		{
			if (file_exists($this->app->configPath().'/session.php')) return true;

			return false;
		}
	}

	/**
	 * Check if Nova is installed.
	 *
	 * @return	bool
	 */
	public function isInstalled()
	{
		return $this->app['cache']->get('nova.installed', false);
	}

}

<?php namespace Nova\Setup\Services;

use PDO;
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
		$checks = collect([
			'passes'			=> true,
			'php'				=> true,
			'writableDirs'		=> true,
			'writableDirsFull'	=> [],
			'pdo'				=> true,
			'pdoDrivers'		=> true,
			'pdoDriversFull'	=> [],
		]);

		// PHP version
		if (version_compare(PHP_VERSION, '5.5.9', '<'))
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
			nova_path('bootstrap/cache'),
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
		{
			$checks->put('writableDirsFull', $errorDirs);
		}

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

	public function icon($icon, $size = 'sm', $additional = null)
	{
		$map = [
			'1' => 'looks_one',
			'2' => 'looks_two',
			'3' => 'looks_3',
			'4' => 'looks_4',
			'5' => 'looks_5',
			'6' => 'looks_6',
			'user' => 'account_circle',
			'back' => 'arrow_back',
			'checkmark' => 'done',
			'done' => 'done_all',
			'forward' => 'arrow_forward',
			'info' => 'info',
			'migrate' => 'exit_to_app',
			'new' => 'new_releases',
			'refresh' => 'cached',
			'trash' => 'delete',
			'update' => 'system_update_alt',
			'warning' => 'warning',
		];

		// Set the icon we want to use
		$icon = $map[$icon];

		return partial('icon-setup', compact('icon', 'size', 'additional'));
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
			if (file_exists($this->app->configPath().'/database.php'))
			{
				return true;
			}

			return false;
		}

		if ($component == 'mail')
		{
			if (file_exists($this->app->configPath().'/mail.php'))
			{
				return true;
			}

			return false;
		}

		if ($component == 'session')
		{
			if (file_exists($this->app->configPath().'/session.php'))
			{
				return true;
			}

			return false;
		}
	}

}

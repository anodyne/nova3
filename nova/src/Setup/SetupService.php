<?php namespace Nova\Setup;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Foundation\Application;

class SetupService {

	protected $app;

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function checkEnvironment()
	{
		$checks = new Collection([
			'passes'		=> true,
			'php'			=> true,
			'writableDirs'	=> true,
		]);

		// PHP version
		if (version_compare(PHP_VERSION, '5.4.0', '<'))
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
			if ($this->app['config']['database.connections.mysql.host'] == 'DbHost')
				return false;
			
			return true;
		}

		if ($component == 'mail')
		{
			if ($this->app['config']['mail.driver'] == 'MailDriver')
				return false;
			
			return true;
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
	
	/**
	 * Set the config items in the .env file
	 *
	 * @param	string	$config
	 * @param	string	$value
	 * @return	void
	 */
	public function setConfig($config, $value)
	{
		$path = base_path('.env');

		if (file_exists($path))
		{
			file_put_contents($path, str_replace(
				$this->app['config'][$key], $value, file_get_contents($path)
			));
		}

		$this->app['config'][$key] = $value;
	}

}

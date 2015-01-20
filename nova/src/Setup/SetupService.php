<?php namespace Nova\Setup;

use Nova\Foundation\Application;

class SetupService {

	protected $app;

	public function __construct(Application $app)
	{
		$this->app = $app;
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

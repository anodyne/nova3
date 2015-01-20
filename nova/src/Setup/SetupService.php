<?php namespace Nova\Setup;

use Nova\Foundation\Application;

class SetupService {

	protected $app;

	public function __construct(Application $app)
	{
		$this->app = $app;
	}
	
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
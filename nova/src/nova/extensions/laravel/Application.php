<?php namespace nova\extensions\laravel;

use Illuminate\Foundation\Application as LaravelApp;

class Application extends LaravelApp {

	/**
	 * Get the configuration loader instance.
	 *
	 * @return \nova\extensions\laravel\config\LoaderInterface
	 */
	public function getConfigLoader()
	{
		return $this->make('config.loader');
	}

}
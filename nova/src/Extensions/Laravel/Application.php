<?php namespace Nova\Extensions\Laravel;

use Illuminate\Foundation\Application as LaravelApplication;

class Application extends LaravelApplication {

	/**
	 * Get the configuration loader instance.
	 *
	 * @return	\Nova\Extensions\Laravel\Config\LoaderInterface
	 */
	public function getConfigLoader()
	{
		return $this->make('config.loader');
	}

}
<?php namespace Nova\Foundation;

use Illuminate\Filesystem\Filesystem;
use Nova\Foundation\Config\CascadingFileLoader;
use Illuminate\Foundation\Application as LaravelApplication;

class Application extends LaravelApplication {

	/**
	 * Get the configuration loader instance.
	 *
	 * @return \Illuminate\Config\LoaderInterface
	 */
	public function getConfigLoader()
	{
		return new CascadingFileLoader(new Filesystem, false);
	}

}
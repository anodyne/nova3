<?php namespace Nova\Core\Providers;

use Nova\Core\Lib\Location;
use Illuminate\Support\ServiceProvider;

class LocationServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['location'] = $this->app->share(function() { return new Location; });
	}

}
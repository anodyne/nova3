<?php namespace Nova\Setup\Providers;

use Nova\Setup\Lib\Setup;
use Illuminate\Support\ServiceProvider;

class SetupServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerSetup();
	}

	protected function registerSetup()
	{
		$this->app['nova.setup'] = $this->app->share(function()
		{
			return new Setup;
		});
	}

}